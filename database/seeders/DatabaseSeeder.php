<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@spa.local'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
            ]
        );

        $advisor = User::firstOrCreate(
            ['email' => 'advisor@spa.local'],
            [
                'name' => 'Asesor',
                'password' => Hash::make('password'),
            ]
        );

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $advisorRole = Role::firstOrCreate(['name' => 'advisor']);

        $admin->assignRole($adminRole);
        $advisor->assignRole($advisorRole);

        Service::firstOrCreate([
            'name' => 'Masaje Relajante',
        ], [
            'duration' => 60,
            'price' => 650,
            'description' => 'Sesión de masaje para eliminar estrés.',
            'is_active' => true,
        ]);

        $settings = [
            'landing.title' => 'Spa Boutique',
            'landing.subtitle' => 'Bienestar y relajación',
            'landing.description' => 'Agenda tu cita en segundos y recobra tu energía.',
            'business.phone' => '+521234567890',
            'business.address' => 'Calle Principal 123',
            'business.email' => 'contacto@spa.com',
            'business.whatsapp' => '+521234567890',
            'theme.primary' => env('LANDING_PRIMARY_COLOR', '#0e7490'),
            'theme.secondary' => env('LANDING_SECONDARY_COLOR', '#134e4a'),
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
