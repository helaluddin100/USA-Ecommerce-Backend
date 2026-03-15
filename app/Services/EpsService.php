<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * EPS (Easy Payment System) Gateway – per "EPS Merchant API Integration Guide V5" PDF.
 * Sandbox: https://sandboxpgapi.eps.com.bd  |  Production (V5): https://pgapi.eps.com.bd
 * Hash: HMAC-SHA512(data, Hash Key) then Base64.
 * Note: API docs (V4/V5) do not include a currency parameter; for USD display contact EPS.
 */
class EpsService
{
    protected string $baseUrl;

    protected ?string $merchantId = null;

    protected ?string $storeId = null;

    protected ?string $username = null;

    protected ?string $password = null;

    protected ?string $hashKey = null;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.eps.base_url', 'https://sandboxpgapi.eps.com.bd'), '/');
        $this->merchantId = config('services.eps.merchant_id');
        $this->storeId = config('services.eps.store_id');
        $this->username = config('services.eps.username');
        $this->password = config('services.eps.password');
        $this->hashKey = config('services.eps.hash_key');
    }

    public function hasCredentials(): bool
    {
        return $this->merchantId && $this->storeId && $this->username && $this->password && $this->hashKey;
    }

    /**
     * Step 1: Encode Hash Key UTF8. Step 2–4: HMAC-SHA512(data, key), then Base64.
     */
    private function createHash(string $data): string
    {
        $key = $this->hashKey ?? '';
        $binary = hash_hmac('sha512', $data, $key, true);
        return base64_encode($binary);
    }

    /**
     * API 01: GetToken – POST /v1/Auth/GetToken
     * Header: x-hash (hash of userName). Body: userName, password.
     */
    public function getToken(): ?string
    {
        if (! $this->hasCredentials()) {
            return null;
        }

        $url = $this->baseUrl . '/v1/Auth/GetToken';
        $xHash = $this->createHash($this->username);

        try {
            $response = Http::timeout(15)
                ->withHeaders(['x-hash' => $xHash])
                ->post($url, [
                    'userName' => $this->username,
                    'password' => $this->password,
                ]);

            $data = $response->json();
            if ($response->successful() && ! empty($data['token'])) {
                return $data['token'];
            }
            Log::warning('EPS GetToken failed', ['response' => $data ?? $response->body(), 'status' => $response->status()]);
        } catch (\Throwable $e) {
            Log::warning('EPS GetToken error', ['message' => $e->getMessage()]);
        }

        return null;
    }

    /**
     * API 02: Initialize Payment – POST /v1/EPSEngine/InitializeEPS
     * Header: x-hash (hash of merchantTransactionId), Authorization Bearer.
     * Returns RedirectURL to send customer to EPS payment page.
     */
    public function createPaymentLink(Order $order, string $successUrl, string $cancelUrl): ?string
    {
        $token = $this->getToken();
        if (! $token) {
            return null;
        }

        $order->load('items');
        $merchantTransactionId = $this->generateMerchantTransactionId($order);
        $xHash = $this->createHash($merchantTransactionId);

        $url = $this->baseUrl . '/v1/EPSEngine/InitializeEPS';

        $currency = config('services.eps.currency', 'USD');
        $payload = [
            'merchantId' => $this->merchantId,
            'storeId' => $this->storeId,
            'CustomerOrderId' => $order->order_number,
            'merchantTransactionId' => $merchantTransactionId,
            'transactionTypeId' => 1,
            'financialEntityId' => 0,
            'transitionStatusId' => 0,
            'totalAmount' => (float) round($order->total, 2),
            'Currency' => $currency,
            'CurrencyCode' => $currency,
            'currencyCode' => $currency,
            'currency' => $currency,
            'ipAddress' => request()->ip() ?? '127.0.0.1',
            'version' => '1',
            'successUrl' => $successUrl,
            'failUrl' => $cancelUrl,
            'cancelUrl' => $cancelUrl,
            'customerName' => $order->customer_name ?? 'Customer',
            'customerEmail' => $order->customer_email ?? '',
            'CustomerAddress' => $order->shipping_address ?? '',
            'CustomerAddress2' => '',
            'CustomerCity' => $this->extractCity($order->shipping_address),
            'CustomerState' => '',
            'CustomerPostcode' => '',
            'CustomerCountry' => 'US',
            'CustomerPhone' => $order->customer_phone ?? '',
            'ShipmentName' => '',
            'ShipmentAddress' => '',
            'ShipmentAddress2' => '',
            'ShipmentCity' => '',
            'ShipmentState' => '',
            'ShipmentPostcode' => '',
            'ShipmentCountry' => '',
            'ValueA' => $currency,
            'ValueB' => '',
            'ValueC' => '',
            'ValueD' => '',
            'ShippingMethod' => 'NO',
            'NoOfItem' => (string) $order->items->sum('quantity'),
            'ProductName' => $this->buildProductSummary($order),
            'ProductProfile' => 'general',
            'ProductCategory' => 'Demo',
            'ProductList' => $this->buildProductList($order),
        ];

        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'x-hash' => $xHash,
                    'Authorization' => 'Bearer ' . $token,
                ])
                ->post($url, $payload);

            $data = $response->json();

            if ($response->successful() && ! empty($data['RedirectURL'])) {
                return $data['RedirectURL'];
            }
            Log::warning('EPS Initialize failed', ['response' => $data ?? $response->body(), 'status' => $response->status()]);
        } catch (\Throwable $e) {
            Log::warning('EPS Initialize error', ['message' => $e->getMessage()]);
        }

        return null;
    }

    /** Merchant transaction ID: unique, minimum 10 digits (per PDF). */
    private function generateMerchantTransactionId(Order $order): string
    {
        return substr(str_replace(['-', ' ', '.'], '', uniqid((string) $order->id, true)), 0, 16);
    }

    private function extractCity(string $address = null): string
    {
        if (! $address || ! trim($address)) {
            return 'N/A';
        }
        $parts = array_map('trim', explode(',', $address));
        return $parts[1] ?? $parts[0] ?? 'N/A';
    }

    private function buildProductSummary(Order $order): string
    {
        $names = $order->items->pluck('product_name')->take(3)->toArray();
        return implode(', ', $names) ?: 'Order ' . $order->order_number;
    }

    /** ProductList array per PDF: ProductName, NoOfItem, ProductProfile, ProductCategory, ProductPrice. */
    private function buildProductList(Order $order): array
    {
        $list = [];
        foreach ($order->items as $item) {
            $list[] = [
                'ProductName' => $item->product_name,
                'NoOfItem' => (string) $item->quantity,
                'ProductProfile' => 'general',
                'ProductCategory' => 'Demo',
                'ProductPrice' => (string) round($item->price, 2),
            ];
        }
        if (empty($list)) {
            $list[] = [
                'ProductName' => 'Order ' . $order->order_number,
                'NoOfItem' => '1',
                'ProductProfile' => 'general',
                'ProductCategory' => 'Demo',
                'ProductPrice' => (string) round($order->total, 2),
            ];
        }
        return $list;
    }
}
