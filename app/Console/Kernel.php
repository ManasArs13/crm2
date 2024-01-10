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
       // $schedule->command('inspire')->hourly();
        $schedule->command('ms:import-amo')->hourly();
        $schedule->command('app:update-contacts-amo')->hourly();
        $schedule->command('ms:import-product')->hourly();
        $schedule->command('ms:import-color')->hourly();
        $schedule->command('ms:import-contact')->hourly();
        $schedule->command('ms:import-delivery')->hourly();
        $schedule->command('ms:import-order')->hourly();
        $schedule->command('ms:import-productsCategory')->hourly();
        $schedule->command('ms:import-status')->hourly();
        $schedule->command('ms:import-transport')->hourly();
        $schedule->command('ms:import-vehicleType')->hourly();
        $schedule->command('ms:import-demand')->hourly();
        $schedule->command('ms:import-residual')->hourly();
        $schedule->command('app:sync-contact-ms-amo')->hourly();
        $schedule->command('ms:reserve-order-ms')->hourly(); //->everyTwoHours() резерв заказов, каждые 2 часа
        $schedule->command('ms:ckeck-order-ms')->daily();
        $schedule->command('ms:calculation-of-delivery-price-norm')->hourly();
        $schedule->command('ms:import-tech-chart')->daily();
        $schedule->command('ms:import-processing')->hourly();
        $schedule->command('ms:import-supply')->hourly();
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
