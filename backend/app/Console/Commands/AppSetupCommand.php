<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AppSetupCommand extends Command
{
    protected $signature = 'app:setup';
    protected $description = 'Setup aplikasi Bylian Transportasi (storage link, cache, dll)';

    public function handle()
    {
        $this->info('Memulai setup aplikasi Bylian Transportasi...');

        $this->info('1. Membuat storage symlink...');
        Artisan::call('storage:link');
        $this->info(Artisan::output());

        $this->info('2. Clear cache...');
        Artisan::call('optimize:clear');
        $this->info(Artisan::output());

        $this->info('3. Cache config...');
        Artisan::call('config:cache');
        $this->info(Artisan::output());

        $this->info('4. Cache routes...');
        Artisan::call('route:cache');
        $this->info(Artisan::output());

        $this->info('✅ Setup selesai!');
    }
}