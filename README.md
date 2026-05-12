# Laboratorio Laravel & Eloquent - Plataforma de Música

Este proyecto es una aplicación Laravel con 10 tablas interconectadas que simulan una plataforma de música (estilo Spotify). Se utilizaron modelos Eloquent para manejar relaciones complejas y bases de datos pobladas con Factories y Seeders.

## Requisitos
- Docker y Docker Compose
- No se requiere tener PHP ni Composer instalados localmente, todo está dockerizado.

## Instrucciones de Instalación y Ejecución

### 1. Levantar los contenedores
Ejecuta el siguiente comando para construir y levantar los contenedores en segundo plano:
```bash
docker compose up --build -d
```
> [!WARNING]
> La primera vez que levantes el proyecto, el contenedor de MySQL tomará unos 10 a 15 segundos en inicializar la base de datos vacía. **Espera este tiempo** antes de correr las migraciones, de lo contrario obtendrás un error `Connection refused`.

### 2. Ejecutar Migraciones y Seeders
Este comando creará las 10 tablas en la base de datos e insertará **más de 13,000 registros** usando factories y relaciones dinámicas:
```bash
docker compose exec app php artisan migrate:fresh --seed
```

### 3. Verificar Consultas y Eager Loading
Se ha preparado un comando de Artisan que ejecuta 5 consultas avanzadas en Eloquent, demostrando: filtros, ordenamiento, uso de relaciones (`hasMany`, `belongsToMany`, `whereHas`) y **Eager Loading** para evitar el problema N+1.
```bash
docker compose exec app php artisan test:queries
```

## Estructura de la Base de Datos (10 Modelos)
1. `users` (hasOne Profile, hasMany Playlists, hasMany Tickets)
2. `profiles` (belongsTo User)
3. `artists` (hasMany Albums, hasMany Concerts)
4. `albums` (belongsTo Artist, hasMany Songs)
5. `genres` (hasMany Songs)
6. `songs` (belongsTo Album, belongsTo Genre, belongsToMany Playlists)
7. `playlists` (belongsTo User, belongsToMany Songs)
8. `concerts` (belongsTo Artist, hasMany Tickets)
9. `tickets` (belongsTo User, belongsTo Concert)
10. `playlist_song` (Tabla pivote para la relación Muchos a Muchos)

Todos los modelos correspondientes se encuentran en `app/Models/` y cada uno cuenta con sus métodos de relación declarados y la propiedad `$fillable`.
