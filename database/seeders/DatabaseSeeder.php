<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Company;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Database\Factories\CompanyFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(CitySeeder::class);
        $this->call(CategorySeeder::class);

        User::factory()->create([
            'image' => 'profile/4hHxL9FQTTFkYRHctziAmMYxALh72D1ZkTGBsPZS.jpg',
            'name' => 'Employer',
            'lastname' => '',
            'email' => 'employer@gmail.com',
            'city_id' => City::find(4)->id,
            'address' => 'street',
            'birthday' => '1999-11-04',
            'phone' => '+38349123456',
            'gender' => 'male',
            'role' => 'employer',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::factory()->create([
            'image' => 'profile/4hHxL9FQTTFkYRHctziAmMYxALh72D1ZkTGBsPZS.jpg',
            'name' => 'Employee',
            'lastname' => '',
            'email' => 'employee@gmail.com',
            'city_id' => City::find(4)->id,
            'address' => 'street',
            'birthday' => '1998-12-12',
            'phone' => '+38349111222',
            'gender' => 'female',
            'role' => 'employee',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::factory()->create([
            'image' => 'profile/4hHxL9FQTTFkYRHctziAmMYxALh72D1ZkTGBsPZS.jpg',
            'name' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@gmail.com',
            'city_id' => City::find(4)->id,
            'address' => 'Sami Frasheri',
            'birthday' => '1992-11-22',
            'phone' => '+38349222555',
            'gender' => 'male',
            'role' => 'admin',
            'password' => Hash::make('admin'),
            'is_premium' => true,
            'email_verified_at' => now(),
        ]);
        User::factory(10)->create();
        Company::factory(1)->create();
        Post::factory(10)->create();


        DB::table('oauth_clients')->insert([
            'id' => '01975a88-3059-7060-baf3-94a1869b048a',
            'name' => 'FindMate',
            'secret' => Hash::make('lQ6nWW65X6QrnwHi4MfyOaKuzLH5hI2YRK7aWmlg'),
            'provider' => 'users',
            'redirect_uris' => '',
            'grant_types' => '["password","refresh_token"]',
            'revoked' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

}
