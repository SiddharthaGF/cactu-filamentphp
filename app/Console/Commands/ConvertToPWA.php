<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

final class ConvertToPWA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:pwa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Copiando archivo base.blade.php...');
        if (file_exists(base_path('vendor/filament/filament/resources/views/components/layout/base.blade.php'))) {
            unlink(base_path('vendor/filament/filament/resources/views/components/layout/base.blade.php'));
        }
        copy(base_path('resources/views/components/layouts/base.blade.php'), base_path('vendor/filament/filament/resources/views/components/layout/base.blade.php'));
        $this->line('Archivo base.blade.php copiado con éxito');
    }
}
