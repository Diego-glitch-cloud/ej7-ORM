<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Artist;
use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Paso 7: Generar 1100 registros por modelo base (Total 5500)
        User::factory(1100)->hasProfile()->create();
        Artist::factory(1100)->hasAlbums(1)->create();
        Genre::factory(1100)->create();
    }
}
