<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Category::factory(3)->create();

        // profil 'admin' présent par défaut dans la BDD, même après un :fresh 
        $admin = User::create([
            "name" => "Chloé",
            "email" => "cg@gmail.com",
            "password" => Hash::make("cg@gmail.com"),
            "role" => "admin",
        ]);

        // un autre utilisateur créé par défaut pour l'exemple
        $user = User::create([
            "name" => "user",
            "email" => "user@gmail.com",
            "password" => Hash::make("user@gmail.com"),
            "role" => "user",
        ]);

        // une catégorie par défaut
        $category = Category::create([
            "name" => "Développement web"
        ]);
    }
}
