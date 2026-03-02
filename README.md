# Portfolio PHP (PDO)

## Prérequis
- PHP 8+
- MySQL 8+

## Base de données
1. Crée une base `portfolio`.
2. Importe `portfolio.sql`.

## Configuration
Ajuste les identifiants dans `app/config/config.php` (valeurs par défaut MAMP: `root/root`, port `8889`).
Un fichier d'exemple est disponible dans `app/config/config.example.php`.

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
