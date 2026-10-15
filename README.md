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

PostgreSQL est accessible depuis l’application via Doctrine et conserve ses
données dans le volume Docker `database_data`. Les identifiants par défaut
sont réservés au développement local ; définissez `POSTGRES_PASSWORD` et
`APP_SECRET` avec des valeurs propres à votre environnement avant tout usage
hors de la machine locale. `docker compose down` conserve les données ; ne
supprimez pas le volume `database_data` si vous souhaitez les garder.
