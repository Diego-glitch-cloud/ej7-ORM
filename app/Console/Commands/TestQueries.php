<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Concert;
use Illuminate\Console\Command;

class TestQueries extends Command
{
    protected $signature = 'test:queries';
    protected $description = 'Ejecuta las 5 consultas de prueba Eloquent';

    public function handle()
    {
        $this->info('--- Consulta 1: Filtro y Ordenamiento ---');
        // 1. Obtener artistas formados después de 1990, ordenados alfabéticamente
        $artists = Artist::where('formed_year', '>', 1990)
            ->orderBy('name', 'asc')
            ->limit(5)
            ->get();
        foreach ($artists as $artist) {
            $this->line("- {$artist->name} ({$artist->formed_year})");
        }

        $this->info("\n--- Consulta 2: Uso de Relaciones (hasMany) ---");
        // 2. Obtener los álbumes de un artista específico (ej. el primer artista con álbumes)
        $artistWithAlbums = Artist::has('albums')->first();
        if ($artistWithAlbums) {
            $this->line("Álbumes de {$artistWithAlbums->name}:");
            foreach ($artistWithAlbums->albums as $album) {
                $this->line("  - {$album->title} ({$album->release_year})");
            }
        }

        $this->info("\n--- Consulta 3: Relación belongsToMany (Filtro en Pivote) ---");
        // 3. Obtener playlists que sean públicas y contar cuántas canciones tienen
        $publicPlaylists = Playlist::where('is_public', true)
            ->withCount('songs')
            ->orderByDesc('songs_count')
            ->limit(5)
            ->get();
        foreach ($publicPlaylists as $playlist) {
            $this->line("- Playlist '{$playlist->name}' tiene {$playlist->songs_count} canciones.");
        }

        $this->info("\n--- Consulta 4: Eager Loading (Evitando N+1) ---");
        // 4. Eager Loading
        // JUSTIFICACIÓN: Se usa `with('artist')` porque vamos a iterar sobre una lista de conciertos e imprimir
        // el nombre del artista de cada concierto. Si no usamos Eager Loading, por cada concierto se haría una 
        // consulta extra a la base de datos para buscar al artista, resultando en el Problema N+1.
        $concerts = Concert::with('artist')
            ->where('date', '>', now())
            ->orderBy('date', 'asc')
            ->limit(5)
            ->get();
            
        foreach ($concerts as $concert) {
            $this->line("- {$concert->city}: {$concert->artist->name} ({$concert->date->format('Y-m-d')})");
        }

        $this->info("\n--- Consulta 5: Filtro en relaciones (whereHas) ---");
        // 5. Obtener Usuarios que tengan tickets para un concierto en una ciudad específica o en el futuro
        $usersWithTickets = User::whereHas('tickets.concert', function ($query) {
            $query->where('date', '>', now());
        })->limit(5)->get();
        
        $this->line("Usuarios con tickets para futuros conciertos:");
        foreach ($usersWithTickets as $user) {
            $this->line("- {$user->name}");
        }
    }
}
