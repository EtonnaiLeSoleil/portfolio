# Portfolio Professionnel

Bienvenue sur le dépôt de mon portfolio professionnel. Ce projet a pour but de présenter mes compétences, mes projets et mon parcours.

## 🚀 Fonctionnalités

* **Page publique** : Présentation (bio), projets réalisés, compétences techniques et formulaire de contact.
* **Téléchargement de CV** : Permet aux visiteurs de télécharger mon Curriculum Vitae.
* **Interface d'administration (sécurisée)** : Accès restreint par mot de passe (haché) pour ajouter/modifier/supprimer des projets, mettre à jour le profil professionnel et consulter les messages de contact.
* **Sécurité** : Protection CSRF implémentée, requêtes SQL préparées (PDO) pour éviter les injections, et protection XSS via l'échappement des données (htmlspecialchars).

## 🛠️ Stack Technique

* **Langage principal** : PHP 8+ (en pur)
* **Base de données** : MySQL 8+ (PDO)
* **Frontend** : HTML5, CSS3 (Vanilla), architecture Responsive Design
* **Conteneurisation** : Docker & Docker Compose (à venir / intégré)

## 📁 Architecture du Projet

```text
portfolio/
├── docker-compose.yml   # Configuration Docker (services web et db)
├── Dockerfile           # Image Docker pour le serveur web PHP
├── portfolio.sql        # Script de création et d'initialisation de la BDD
├── README.md            # Documentation du projet
├── app/
│   ├── bootstrap.php    # Initialisation de l'application
│   └── config/
│       └── config.php   # Chargement des variables d'environnement
├── lib/
│   ├── auth.php         # Gestion de l'authentification sécurisée
│   ├── db.php           # Connexion à la base de données via PDO
│   └── security.php     # Utilitaires de sécurité (CSRF, tokens)
└── public/              # Dossier racine du serveur web (DocumentRoot)
    ├── css/style.css    # Feuilles de style
    ├── img/             # Images publiques (favicon, logos, etc.)
    ├── templates/       # Vues HTML (header, footer, pages)
    ├── uploads/         # Fichiers uploadés (CV, images projets)
    └── index.php        # Point d'entrée principal
```

## ⚙️ Prérequis

- PHP 8+ et MySQL 8+ (pour une exécution locale traditionnelle)
- **OU** Docker & Docker Compose (recommandé)

## 🔧 Installation & Démarrage

### Option 1 : Avec Docker (Recommandé)

1. Clonez ce dépôt.
2. Copiez le fichier d'exemple des variables d'environnement (si existant) ou créez un `.env` contenant vos variables (DB_HOST, DB_NAME, DB_USER, etc.).
3. À la racine du projet, lancez :
   ```bash
   docker-compose up -d --build
   ```
4. Le site sera accessible sur `http://localhost:8000`.

### Option 2 : Exécution Locale sans Docker

1. **Base de données** :
   * Créez une base de données MySQL nommée `portfolio`.
   * Importez le fichier `portfolio.sql` fourni.
2. **Configuration** :
   * Créez un fichier `.env` à la racine (au même niveau que le dossier `app`), ou vérifiez que `config.php` a les bons identifiants de repli :
     ```ini
     DB_HOST=127.0.0.1
     DB_PORT=8889
     DB_NAME=portfolio
     DB_USER=root
     DB_PASS=root
     DB_CHARSET=utf8mb4
     ```
3. **Démarrage** :
   * Depuis le dossier racine du projet `portfolio/`, lancez le serveur PHP interne :
   ```bash
   php -S localhost:8000 -t public
   ```
   * Accédez au site sur `http://localhost:8000`.

## 🔒 Espace Administrateur

L'accès à l'interface d'administration `/login.php` se fait avec les identifiants par défaut suivants (issus du fichier `portfolio.sql`) :

* **Email** : `Admin@admin.admin`
* **Mot de passe** : `P0rtf8l10MAG1qu3`

⚠️ _Pensez à modifier ces identifiants pour un environnement de production._
