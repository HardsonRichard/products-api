<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Laravel\Prompts\progress;

class UserProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = progress(
            label: "Seeding users",
            steps: 1,
            callback: fn() => User::factory()->count(100)->create(),
        );

        $products = progress(
            label: "Seeding products",
            steps: 20,
            callback: fn() => Product::factory()->count(100)->create(),
        );
    }
}