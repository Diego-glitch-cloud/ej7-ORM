<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Album;
use App\Models\Concert;
use App\Models\Song;
use App\Models\Playlist;
use App\Models\Ticket;
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

        // Paso 8: Generar modelos dependientes reciclando los ya creados
        $users = User::all();
        $artists = Artist::all();
        $albums = Album::all();
        $genres = Genre::all();

        Concert::factory(1100)->recycle($artists)->create();
        Song::factory(1100)->recycle($albums)->recycle($genres)->create();
        Playlist::factory(1100)->recycle($users)->create();
        
        $concerts = Concert::all();
        Ticket::factory(1100)->recycle($users)->recycle($concerts)->create();

        // Poblar tabla pivote (playlist_song)
        $playlists = Playlist::all();
        $songs = Song::all();

        foreach ($playlists as $playlist) {
            $playlist->songs()->attach(
                $songs->random(rand(2, 5))->pluck('id')->toArray()
            );
        }
    }
}
