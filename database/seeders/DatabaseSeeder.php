<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(LaratrustSeeder::class);

        $userAdmin = User::create([
            'name' => 'Admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('password')
        ]);
        $userAdmin->addRole('admin');

        $userSale = User::create([
            'name' => 'Sales',
            'email' => 'sales@app.com',
            'password' => bcrypt('password')
        ]);
        $userSale->addRole('sales_team');

        Product::factory(10)->create();


    }
}
