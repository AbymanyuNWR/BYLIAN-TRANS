<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Driver;
use App\Models\Vehicle;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalBookings = Booking::count();
        $availableVehicles = Vehicle::where('status', 'available')->count();
        $availableDrivers = Driver::where('status', 'available')->count();
        
        $revenue = Booking::where('payment_status', 'paid')->sum('total_price');
        $formattedRevenue = 'Rp ' . number_format($revenue, 0, ',', '.');

        return [
            Stat::make('Total Bookings', $totalBookings)
                ->description('All registered trip orders')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('info'),
            Stat::make('Active Fleet', $availableVehicles)
                ->description('Vehicles ready for service')
                ->descriptionIcon('heroicon-m-truck')
                ->color('success'),
            Stat::make('Available Drivers', $availableDrivers)
                ->description('Chauffeurs ready to drive')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            Stat::make('Gross Revenue', $formattedRevenue)
                ->description('Total verified paid bookings')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
        ];
    }
}
