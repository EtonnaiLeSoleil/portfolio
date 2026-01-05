# Portfolio PHP (PDO)

## Prérequis
- PHP 8+
- MySQL 8+

## Base de données
1. Crée une base `portfolio`.
2. Importe `portfolio.sql`.

## Configuration
Ajuste les identifiants dans `config.php` (valeurs par défaut MAMP: `root/root`, port `8889`).

## Fichiers
- Le CV est servi depuis `uploads/` (ex: `uploads/Antoine-Gouet-CV.pdf`).

## Lancer en local
Depuis le dossier du projet :

```bash
php -S localhost:8000
```

Puis ouvre :
- http://localhost:8000/index.php
- http://localhost:8000/login.php

## Connexion admin
Pour accéder à la page d'administration :
- http://localhost:8000/login.php

Identifiants fournis par défaut (seed dans `portfolio.sql`) :
- Email : antoine.gouet0706@hotmail.com
- Mot de passe : P0rtf8l10dEMé4P3
