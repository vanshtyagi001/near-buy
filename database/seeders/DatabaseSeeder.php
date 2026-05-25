<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\City;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Cities
        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Miami'];
        $cityModels = [];
        
        foreach ($cities as $cityName) {
            $cityModels[] = City::create([
                'name' => $cityName,
                'slug' => Str::slug($cityName),
                'is_active' => true,
            ]);
        }

        // 2. Seed Categories
        $categories = [
            ['name' => 'Restaurants', 'icon' => 'utensils'],
            ['name' => 'Cafes', 'icon' => 'coffee'],
            ['name' => 'Clothing', 'icon' => 'tshirt'],
            ['name' => 'Electronics', 'icon' => 'laptop'],
            ['name' => 'Salons', 'icon' => 'cut'],
            ['name' => 'Services', 'icon' => 'concierge-bell'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
            ]);
        }

        // 3. Seed Default Admin User
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@nearbuy.com',
            'password' => Hash::make('password123'), // Default test password
            'role' => 'admin',
            'city_id' => $cityModels[0]->id, // Default to first seeded city
            'phone' => '123-456-7890',
            'is_active' => true,
        ]);
    }
}