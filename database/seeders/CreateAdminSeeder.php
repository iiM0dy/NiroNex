<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (!$email || !$password) {
            $this->command?->warn('ADMIN_EMAIL and ADMIN_PASSWORD are required to create the production admin user.');
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'first_name' => 'Admin',
                'last_name' => 'Super',
                'password' => Hash::make($password),
                'phone' => env('ADMIN_PHONE'),
                'birthday' => Carbon::now()->subYears(23),
                'email_verified_at' => Carbon::now(),
                'image' => null,
                'id_photo_type' => null,
                'id_photo_front' => null,
                'id_photo_back' => null,
                'selfie_photo' => null,
                'type' => UserType::Admin,
                'status' => UserStatus::Active,
                'plan_id' => null,
            ]
        );
    }
}
