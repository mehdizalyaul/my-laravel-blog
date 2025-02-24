# Blog Laravel

## Description

Ce projet est un blog développé avec Laravel, permettant aux utilisateurs de s'inscrire, se connecter et gérer des articles. Les utilisateurs authentifiés peuvent créer, modifier et supprimer des articles, tandis que les visiteurs peuvent uniquement consulter les articles existants.

## Fonctionnalités

-   Inscription et connexion des utilisateurs
-   Réinitialisation du mot de passe
-   Création, modification et suppression d'articles
-   Liste paginée des articles
-   Interface intuitive et responsive

## Installation

1. **Cloner le dépôt**
    ```bash
    git clone https://github.com/mehdizalyaul/my-laravel-blog.git
    cd blog
    ```
2. **Installer les dépendances**
    ```bash
    composer install
    npm install
    ```
3. **Configurer l'environnement**
    - Copier le fichier `.env.example` en `.env` :
        ```bash
        cp .env.example .env
        ```
    - Modifier les paramètres de la base de données dans le fichier `.env`
    - Générer la clé d'application :
        ```bash
        php artisan key:generate
        ```
4. **Exécuter les migrations et les seeders**
    ```bash
    php artisan migrate --seed
    ```
5. **Lancer le serveur**
    ```bash
    php artisan serve
    ```
    L'application sera disponible sur `http://127.0.0.1:8000`.

##
