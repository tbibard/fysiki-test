# Fysiki test

Application symfony 4 (StofDoctrineExtension + VichUploader) + Boostrap 4 (JQuery + TinyMCE).

## Installation

Avec Traefik et Docker ou depuis une installation locale type LAMP.
Dans tous les cas :

```
$ mkdir [votre-dossier] && cd [votre-dossier]
$ git clone https://github.com/tbibard/fysiki-test.git .
```

### Traefik et Docker

```
$ cd docker
$ cp .env.dist .env
```

Adapter la variable VIRTUAL_HOST du fichier ./docker/.env
Créer une entrée dans votre fichier /etc/hosts (si pas de dns local type dnsmasq).
A noter que la bdd (MySQL/MariaDB) n'est pas intégrée dans le docker-compose.

```
$ docker-compose up -d
$ docker-compose exec fysiki_app composer install
$ docker-compose exec fysiki_app yarn install
$ docker-compose exec fysiki_app yarn encore dev
$ docker-compose exec fysiki_app yarn encore prod
```

Configurer la variable DATABASE_URL du fichier .env du projet afin d'accéder à une bdd existante.
Mise à jour/création du schéma :

```
$ docker-compose exec fysiki_app bin/console d:s:u --force
```

### Installation type LAMP

Vérification des [pré-requis pour Symfony][1].
Vous devez disposer également de Node.js et Yarn sur votre machine pour la gestion des assets.

```
$ mkdir [votre-dossier] && cd [votre-dossier]
$ git clone https://github.com/tbibard/fysiki-test.git .
$ composer install
$ yarn install && && yarn encore dev && yarn encore prod
```

Configurer la variable DATABASE_URL du fichier .env du projet afin d'accéder à une bdd existante.
Mise à jour/création du schéma :

```
$ bin/console d:s:u --force
```

Créer un vhost sous Apache/Nginx.


[1]: https://symfony.com/doc/current/setup.html#technical-requirements
