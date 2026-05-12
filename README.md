# Laboratorio Laravel & Eloquent - Plataforma de Música

**Estudiante:** Diego Andre Calderon Salazar  
**Carné:** 241263  

## Descripción del Proyecto

Este proyecto consiste en la implementación de un dominio basado en una plataforma de música utilizando el framework Laravel y su ORM Eloquent. El objetivo principal es demostrar el dominio avanzado sobre el diseño de bases de datos relacionales, la creación de migraciones, la implementación de modelos Eloquent y la optimización de consultas.

### Cumplimiento de Requerimientos

La aplicación ha sido diseñada y desarrollada cumpliendo estrictamente con los lineamientos del laboratorio:

1. **Definición de Tablas y Migraciones:** Se han creado 10 tablas interconectadas (`users`, `profiles`, `artists`, `albums`, `genres`, `songs`, `playlists`, `concerts`, `tickets`, y la tabla pivote `playlist_song`). Cada migración implementa correctamente los métodos `up()` y `down()`.
2. **Modelos Eloquent:** Se implementó un modelo para cada tabla (10 modelos en total). Todos cuentan con la propiedad `$fillable` para asignación masiva y `$casts` donde se requiere conversiones de tipos de datos.
3. **Relaciones entre Modelos:** Se definieron las relaciones formales en ambos sentidos de los modelos involucrados, abarcando `hasOne`, `hasMany`, `belongsTo` y `belongsToMany`.
4. **Volumen de Datos:** Mediante el uso de Factories y Seeders, la base de datos se inicializa con más de 13,000 registros coherentes, superando el mínimo requerido de 10,000 registros.
5. **Consultas y Optimización:** Se implementó un comando personalizado que ejecuta 5 consultas avanzadas demostrando el uso de relaciones, filtros (`whereHas`, `has`), agregaciones (`withCount`) y ordenamiento.
6. **Eager Loading:** Se integró Eager Loading (`with`) para evitar el problema de N+1 consultas. La justificación técnica se encuentra documentada tanto en el código fuente como en la salida del comando de prueba.

## Requisitos Previos

- Docker
- Docker Compose

*Nota: No es necesario contar con un entorno local de PHP, MySQL o Composer, ya que la infraestructura se encuentra completamente contenida utilizando Docker.*

## Instrucciones de Instalación y Ejecución

### 1. Inicialización del Entorno

Para construir y levantar los contenedores necesarios (Aplicación PHP, Servidor Web Nginx y Base de Datos MySQL), ejecute el siguiente comando en la raíz del proyecto:

```bash
docker compose up --build -d
```

**Importante:** Durante la primera ejecución, el contenedor de la base de datos requiere aproximadamente 15 segundos para inicializarse y aceptar conexiones. Se debe aguardar este tiempo antes de proceder al siguiente paso para evitar errores de conexión rechazada.

### 2. Migraciones y Población de Datos (Seeders)

Una vez que la base de datos esté lista, ejecute el siguiente comando para correr todas las migraciones y los seeders. Este proceso insertará más de 13,000 registros y puede demorar unos instantes:

```bash
docker compose exec app php artisan migrate:fresh --seed
```

### 3. Validación de Consultas y Relaciones

Para evaluar el correcto funcionamiento de las consultas Eloquent, las relaciones y la optimización mediante Eager Loading, ejecute el comando de pruebas integrado:

```bash
docker compose exec app php artisan test:queries
```

La terminal imprimirá el resultado de las cinco consultas requeridas, demostrando la integridad relacional de los datos generados y la justificación técnica del uso de Eager Loading para la prevención del problema N+1.

## Arquitectura de la Base de Datos

La estructura relacional se compone de la siguiente manera:

1. **User:** `hasOne` Profile, `hasMany` Playlists, `hasMany` Tickets.
2. **Profile:** `belongsTo` User.
3. **Artist:** `hasMany` Albums, `hasMany` Concerts.
4. **Album:** `belongsTo` Artist, `hasMany` Songs.
5. **Genre:** `hasMany` Songs.
6. **Song:** `belongsTo` Album, `belongsTo` Genre, `belongsToMany` Playlists.
7. **Playlist:** `belongsTo` User, `belongsToMany` Songs.
8. **Concert:** `belongsTo` Artist, `hasMany` Tickets.
9. **Ticket:** `belongsTo` User, `belongsTo` Concert.
10. **PlaylistSong:** Modelo pivote para la relación muchos a muchos entre Playlists y Songs.
