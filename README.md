# Portfolio PHP (PDO)

## Prérequis
- PHP 8+
- MySQL 8+

## Base de données
1. Crée une base `portfolio`.
2. Importe `portfolio.sql`.

## Configuration
Ajuste les identifiants dans `config.php` (valeurs par défaut MAMP: `root/root`, port `8889`).

## Lancer en local
Depuis le dossier du projet :

```bash
php -S localhost:8000
```

Puis ouvre :
- http://localhost:8000/index.php
- http://localhost:8000/login.php

## Connexion admin
Utilise l'email présent dans la table `user` et le mot de passe correspondant au hash déjà en base.
