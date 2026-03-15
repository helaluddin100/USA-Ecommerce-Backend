# B2B Ecommerce Admin Dashboard

A comprehensive B2B ecommerce admin dashboard built with Laravel 11 and Tailwind CSS, featuring advanced analytics and B2B-specific features.

## Features

### 🎯 Advanced Analytics Dashboard
- **Revenue Overview**: Real-time revenue tracking with growth metrics
- **Orders Analytics**: Comprehensive order statistics and trends
- **Customer Insights**: B2B customer analytics and performance metrics
- **Product Performance**: Top products and sales analysis
- **Interactive Charts**: Beautiful data visualizations using Chart.js
- **Monthly Trends**: 12-month revenue and orders tracking

### 🏢 B2B Specific Features
- **Bulk Orders Management**: Handle large volume B2B orders efficiently
- **Pricing Tiers**: Multi-tier pricing system for different customer segments
- **Customer Management**: Comprehensive B2B customer profiles and management
- **Order Tracking**: Detailed order status and management
- **Customer Analytics**: Individual customer performance metrics

### 🎨 Modern UI/UX
- **Tailwind CSS**: Beautiful, responsive design
- **Sidebar Navigation**: Intuitive admin navigation
- **Dashboard Cards**: Key metrics at a glance
- **Data Tables**: Sortable and filterable data tables
- **Status Badges**: Visual status indicators

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Tailwind CSS
- **Charts**: Chart.js
- **Build Tool**: Vite

## Installation

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/PostgreSQL/SQLite

### Setup Steps

1. **Install PHP Dependencies**
   ```bash
   composer install
   ```

2. **Install Node Dependencies**
   ```bash
   npm install
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   - Update `.env` with your database credentials
   ```bash
   php artisan migrate
   ```

5. **Build Assets**
   ```bash
   npm run dev
   # Or for production:
   npm run build
   ```

6. **Start Development Server**
   ```bash
   php artisan serve
   ```

7. **Access the Dashboard**
   - Navigate to: `http://localhost:8000/admin/dashboard`

## Project Structure

```
├── app/
│   └── Http/
│       └── Controllers/
│           └── Admin/
│               ├── DashboardController.php
│               ├── BulkOrderController.php
│               ├── PricingTierController.php
│               └── CustomerController.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── admin.blade.php
│   │   └── admin/
│   │       ├── dashboard.blade.php
│   │       ├── bulk-orders/
│   │       ├── pricing-tiers/
│   │       └── customers/
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
├── routes/
│   └── web.php
└── tailwind.config.js
```

## Routes

### Admin Routes
- `/admin/dashboard` - Main dashboard with analytics
- `/admin/bulk-orders` - Bulk orders management
- `/admin/pricing-tiers` - Pricing tiers management
- `/admin/customers` - Customer management
- `/admin/customers/{id}` - Customer details

## Dashboard Features

### Analytics Cards
- Total Revenue with growth percentage
- Total Orders with growth tracking
- Total Customers (B2B clients)
- Total Products in catalog
- Average Order Value
- Conversion Rate
- Revenue Growth

### Charts
- **Revenue Chart**: Line chart showing monthly revenue trends
- **Orders Chart**: Bar chart displaying monthly order volumes

### Data Tables
- **Top Customers**: List of top performing B2B customers
- **Top Products**: Best selling products
- **Recent Orders**: Latest order transactions

## B2B Features

### Bulk Orders
- Create and manage bulk orders
- Track order status (Pending, Processing, Completed)
- View order details and quantities
- Customer-specific bulk order management

### Pricing Tiers
- **Tier 1 - Enterprise**: 25% discount (1000+ quantity)
- **Tier 2 - Business**: 15% discount (500+ quantity)
- **Tier 3 - Standard**: 5% discount (100+ quantity)
- **Tier 4 - Starter**: Base pricing

### Customer Management
- Company information
- Contact person details
- Order history
- Total spending analytics
- Pricing tier assignment
- Customer status management

## Development

### Running in Development Mode
```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server
npm run dev
```

### Building for Production
```bash
npm run build
```

## Customization

### Tailwind Configuration
Edit `tailwind.config.js` to customize colors, spacing, and other design tokens.

### Adding New Analytics
1. Update `DashboardController.php` to add new data
2. Add new cards/charts in `dashboard.blade.php`
3. Update routes if needed

## Notes

- Currently using mock data for demonstration
- Replace mock data with actual database queries
- Add authentication middleware for production
- Implement proper authorization for admin routes
- Add form validation for create/edit operations

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
