<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Throwable;

final class PrepareSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prepare:system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Preparate data base for the first time';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if ($this->confirm('¿Deseas continuar?')) {
            try {
                $this->info('Realizando Migraciones...');
                Artisan::call('migrate:fresh');
                $this->line('Migraciones realizadas con éxito');
                $this->newLine(2);
                $this->line('Ingrese los datos del usuario administrador');
                $this->newLine(1);
                $this->info('Si no ingresa los datos se tomarán los valores por defecto');
                $name = $this->ask('Nombre', env('ADMIN_NAME'));
                $email = $this->ask('Correo', env('ADMIN_EMAIL'));
                $this->newLine(1);
                $this->info('Establezca la contraseña, si no ingresa una asignará *123456789*');
                $password = $this->secret('Contraseña');
                if (empty($password)) {
                    $password = '123456789';
                }
                $this->info('Creando usuario administrador...');
                User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
                $this->line('Usuario administrador creado con éxito');
                $this->info('Ejecutando Seeders...');
                //Artisan::call('db:seed');
                $this->line('Seeders realizados con éxito');
                $this->info('Creando roles, permisos...');
                Artisan::call('shield:install --fresh --minimal');
                $this->line('Roles, permisos creados con éxito');
                $this->info('Base de datos preparada con éxito');
                $this->newLine(1);
                $this->info('credenciales de usuario administrador:');
                $this->line('Correo: ' . $email);
                $this->line('Contraseña: ' . $password);
                $this->newLine(2);
            } catch (Throwable $th) {
                $this->error('Error al preparar la base de datos');
                $this->error($th->getMessage());
            }
        }
    }
}
