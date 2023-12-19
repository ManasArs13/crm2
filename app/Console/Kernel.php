<?php

namespace App\Console;

use App\Console\Commands\ImportFromAmo\ImportFromAmo;
use App\Console\Commands\SyncMS\CheckOrderMS;
use App\Console\Commands\ImportFromMS\ImportColor;
use App\Console\Commands\ImportFromMS\ImportContactMs;
use App\Console\Commands\ImportFromMS\ImportDelivery;
use App\Console\Commands\ImportFromMS\ImportDemand;
use App\Console\Commands\ImportFromMS\ImportOrderMs;
use App\Console\Commands\ImportFromMS\ImportProduct;
use App\Console\Commands\ImportFromMS\ImportProductsCategory;
use App\Console\Commands\ImportFromMS\ImportStatusMs;
use App\Console\Commands\ImportFromMS\ImportTransport;
use App\Console\Commands\ImportFromMS\ImportVehicleType;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ImportFromAmo::class,
        ImportProduct::class,
        ImportDelivery::class,
        ImportTransport::class,
        ImportColor::class,
        ImportOrderMs::class,
        ImportVehicleType::class,
        ImportContactMs::class,
        ImportProductsCategory::class,
        ImportStatusMs::class,
        ImportDemand::class,
        CheckOrderMS::class
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('inspire')->hourly();
        $schedule->command('ms:import-amo')->everyTenMinutes();
        $schedule->command('app:update-contacts-amo')->everyTenMinutes();
        $schedule->command('ms:import-product')->everyTenMinutes();
        $schedule->command('ms:import-color')->everyTenMinutes();
        $schedule->command('ms:import-contact')->everyTenMinutes();
        $schedule->command('ms:import-delivery')->everyTenMinutes();
        $schedule->command('ms:import-order')->everyTenMinutes();
        $schedule->command('ms:import-productsCategory')->everyTenMinutes();
        $schedule->command('ms:import-status')->everyTenMinutes();
        $schedule->command('ms:import-transport')->everyTenMinutes();
        $schedule->command('ms:import-vehicleType')->everyTenMinutes();
        $schedule->command('ms:import-demand')->everyTenMinutes();
        $schedule->command('ms:import-residual')->everyTenMinutes();
        $schedule->command('app:sync-contact-ms-amo')->everyTenMinutes();
        $schedule->command('ms:reserve-order-ms')->everyTenMinutes(); //->everyTwoHours() резерв заказов, каждые 2 часа
        $schedule->command('ms:ckeck-order-ms')->daily();
        $schedule->command('ms:calculation-of-delivery-price-norm')->everyTenMinutes();
        $schedule->command('ms:import-tech-chart')->mondays();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
