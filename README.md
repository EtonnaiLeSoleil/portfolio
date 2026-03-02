# Portfolio PHP (PDO)

## Prérequis
- PHP 8+
- MySQL 8+

## Base de données
1. Crée une base `portfolio`.
2. Importe `portfolio.sql`.

## Configuration
Il faut créer un fichier `.env` à la racine du projet et le remplir avec tes propres paramètres de base de données.
Voici un exemple de contenu à adapter :

```ini
DB_HOST=127.0.0.1
DB_PORT=8889
DB_NAME=portfolio
DB_USER=root
DB_PASS=root
DB_CHARSET=utf8mb4
```

Un fichier `config.php` charge ces variables, ou utilise des valeurs par défaut si le `.env` est absent.

## Fichiers
- Le CV est servi depuis `public/uploads/`.
- Le site est accessible via le dossier `public/`.

## Lancer en local
Depuis le dossier du projet :

```bash
php -S localhost:8000 -t public
```

Ouvre ton navigateur sur `http://localhost:8000`.
php -S localhost:8000
```

Puis ouvre :
- http://localhost:8000/index.php
- http://localhost:8000/login.php

## Connexion admin
Pour accéder à la page d'administration :
- http://localhost:8000/login.php

Identifiants fournis par défaut (seed dans `portfolio.sql`) :
- Email : Admin@admin.admin
- Mot de passe : P0rtf8l10MAG1qu3
