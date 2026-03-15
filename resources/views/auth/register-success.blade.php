<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful - B2B Ecommerce</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="bg-white shadow-lg rounded-lg p-8 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Registration Successful!</h2>
                <p class="text-gray-600 mb-6">
                    {{ session('success', 'Your registration has been submitted successfully.') }}
                </p>
                <p class="text-sm text-gray-500 mb-6">
                    Our sales team will review your application and send you a confirmation email within 5 working days.
                </p>
                <a href="{{ route('register') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Back to Registration
                </a>
            </div>
        </div>
    </div>
</body>
</html>

