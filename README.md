## Objetivo
Desarrollar una aplicación tipo API, en donde se apliquen todos los conocimientos posibles acerca del framework Laravel 10.x y versiones
anteriores. Esta API no requiere de autenticación para los distintos endpoints, se requiere consumir listados de tareas relacionados a
usuarios y empresas.

### Métricas de éxito
- **Se uso Laravel 10.x**
- **Se puede consultar el listado de empresas y sus tareas relacionadas**
- **Se implemento el uso de relaciones Eloquent HasMany**
- **Se implemento el uso de relaciones Eloquent BelongsTo**
- **Se utilizó validación para la creación de tareas**
- **Se limito la creación de tareas pendientes a 5 por usuario**
- **Los modelos están correctamente nombrados en base a las conveciones de Laravel**
- **Las tablas de base de datos se pueden crear mediante migraciones**
- **Los modelos cuentan con Factories**
- **Se crearon Seeders**
- **No se utilizo consultas en “crudo (raw)”**
- **Se subio el código a un repositorio de GIT**
- **Se adjuntaron capturas de pantalla de los resultados de las consultas a los puntos de consulta**

## Instalación
> composer install
- **Ajustar el archivo .env con la configuración de la base de datos a utilizar**
> php artisan migrate --seed || php artisan migrate:refresh --seed

## Ejecutar pruebas unitarias
> php artisan test 

## Endpoints
### GET /api/companies
```javascript
[{
        "id": 1,
        "name": "Kulas-Keeling",
        "tasks": [{
            "id": 1,
            "name": "Dr. Lauren Schaden",
            "description": "Id sunt facere sit rerum. Illo aut quia architecto quia rerum sed.",
            "is_completed": 1,
            "started_at": "2024-02-29T19:54:08.000000Z",
            "expired_at": null,
            "user": {
                "id": 1,
                "name": "Mr. Russell Ortiz"
            }
        }]
    },
    {
        "id": 2,
        "name": "Breitenberg-Feil",
        "tasks": [{
            "id": 2,
            "name": "Garret Howe",
            "description": "Nesciunt qui optio et veniam. Aspernatur nobis minus est quia perferendis debitis et. Veritatis esse ut reprehenderit sed. Est ut quis dolorem incidunt ab modi.",
            "is_completed": 0,
            "started_at": "2024-02-29T19:54:08.000000Z",
            "expired_at": "2024-03-03T19:54:08.000000Z",
            "user": {
                "id": 2,
                "name": "Demarcus Raynor IV"
            }
        }]
    },
    {
        "id": 3,
        "name": "Marks Inc",
        "tasks": []
    }
]
```

### GET /api/users
```javascript
[
  {
    "id": 15,
    "name": "Fatima Zboncak",
    "tasks": [
      {
        "id": 28,
        "name": "Mr. Jefferey Will I",
        "description": "Est amet sit qui debitis. Impedit quaerat porro itaque quam rerum rerum cum. Dolor consequatur pariatur optio voluptate voluptas cum minima. Praesentium consequuntur qui cum quia nostrum quas.",
        "is_completed": 1,
        "started_at": "2024-02-29T19:58:49.000000Z",
        "expired_at": null,
        "company": {
          "id": 23,
          "name": "Vandervort, Nikolaus and Schmitt"
        }
      }
    ]
  },
  {
    "id": 16,
    "name": "Prof. Patrick Ruecker",
    "tasks": [
      {
        "id": 29,
        "name": "Lorena Schoen Jr.",
        "description": "Ratione facere in eos ipsa. Maxime amet perspiciatis et. Nostrum facilis odit molestiae provident consequatur ipsum architecto. Iure sequi maiores ad laboriosam placeat et eum.",
        "is_completed": 0,
        "started_at": "2024-02-29T19:58:49.000000Z",
        "expired_at": "2024-03-03T19:58:49.000000Z",
        "company": {
          "id": 24,
          "name": "Padberg, Gulgowski and Kuphal"
        }
      }
    ]
  },
  {
    "id": 17,
    "name": "Donnie Roob",
    "tasks": []
  }
]
```
### GET /api/tasks
```javascript
[
  {
    "id": 8,
    "name": "Dennis Kemmer",
    "description": "Provident eaque autem esse hic. Dolorum expedita sapiente explicabo vitae nobis velit. Iure officia itaque ipsum id labore sed amet. Fugiat ut rerum occaecati magni.",
    "is_completed": 0,
    "started_at": "2024-02-29T20:00:07.000000Z",
    "expired_at": "2024-03-03T20:00:07.000000Z",
    "user": {
      "id": 4,
      "name": "Ambrose Hodkiewicz"
    },
    "company": {
      "id": 12,
      "name": "Crona-Maggio"
    }
  },
  {
    "id": 9,
    "name": "Haskell Klocko",
    "description": "Adipisci aut eligendi ipsa aspernatur ad totam aut. Culpa id accusamus temporibus minus aut. Veritatis voluptatum nesciunt aut expedita odio rerum.",
    "is_completed": 0,
    "started_at": "2024-02-29T20:00:07.000000Z",
    "expired_at": "2024-03-03T20:00:07.000000Z",
    "user": {
      "id": 5,
      "name": "Ignacio Jakubowski II"
    },
    "company": {
      "id": 13,
      "name": "Bosco Inc"
    }
  },
  {
    "id": 10,
    "name": "Lou Volkman Sr.",
    "description": "Minima itaque labore ratione sapiente. Sit quasi repellat dolores. Quia voluptates molestias quo.",
    "is_completed": 0,
    "started_at": "2024-02-29T20:00:07.000000Z",
    "expired_at": "2024-03-03T20:00:07.000000Z",
    "user": {
      "id": 6,
      "name": "Mr. Gregorio Erdman DDS"
    },
    "company": {
      "id": 14,
      "name": "Lindgren and Sons"
    }
  },
  {
    "id": 11,
    "name": "Marquise Bergnaum",
    "description": "Assumenda quae sint laborum optio nesciunt molestiae deleniti. Voluptatem sunt rem sed repellat.",
    "is_completed": 0,
    "started_at": "2024-02-29T20:00:07.000000Z",
    "expired_at": "2024-03-03T20:00:07.000000Z",
    "user": {
      "id": 7,
      "name": "Arlo Hills"
    },
    "company": {
      "id": 15,
      "name": "Hessel, Schimmel and Hamill"
    }
  },
  {
    "id": 12,
    "name": "Mayra McCullough",
    "description": "Incidunt dignissimos quidem delectus ipsum. Est illum doloremque nobis enim non pariatur amet.",
    "is_completed": 0,
    "started_at": "2024-02-29T20:00:07.000000Z",
    "expired_at": "2024-03-03T20:00:07.000000Z",
    "user": {
      "id": 8,
      "name": "Maxwell Turner"
    },
    "company": {
      "id": 16,
      "name": "Lemke-Kreiger"
    }
  }
]
```

### POST /api/tasks
```javascript
{
  "name": "Task 1",
  "description": "Task content 1",
  "started_at": "2024-02-29T20:01:36.000000Z",
  "expired_at": "2024-03-03T20:01:36.000000Z",
  "id": 23
}
```

### POST /api/tasks - Validación de 5 táreas máximo incompletas
```javascript
{
  "message": "No es posible crear más tareas, el máximo es de 5."
}
```