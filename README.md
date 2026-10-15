# pkmnsheet

## Lancement avec Docker et Traefik

Traefik doit déjà être démarré avec un entrypoint HTTP nommé `web` et un réseau
Docker partagé. Par défaut, ce projet utilise le réseau `traefik_network`.

```sh
docker compose up -d --build
```

L’application sera disponible sur <http://pkmnsheet.localhost>. Pour utiliser
un autre réseau Traefik, définissez `TRAEFIK_NETWORK` lors du lancement, par
exemple `TRAEFIK_NETWORK=proxy docker compose up -d --build`.

MySQL 8.4 est accessible depuis l’application via Doctrine sur
`database:3306`. Ses données sont conservées dans le volume Docker
`pkmnsheet_mysql_data`. Depuis l’hôte, MySQL est accessible sur
`127.0.0.1:3307`. Les identifiants par défaut sont réservés au développement
local ; définissez `MYSQL_PASSWORD`, `MYSQL_ROOT_PASSWORD` et `APP_SECRET` avec
des valeurs propres à votre environnement avant tout usage hors de la machine
locale. `docker compose down` conserve les données ; ne supprimez pas le volume
`pkmnsheet_mysql_data` si vous souhaitez les garder. Le volume PostgreSQL
`pkmnsheet_database_data` préexistant est laissé intact.
