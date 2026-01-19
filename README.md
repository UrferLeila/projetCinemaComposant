# Projet Cinéma

## Description

Voici notre projet simulant un cinéma fictif : Le Palace. 
Permettant de réserver des sièges, en fonction des séances des films.
Elle permet aussi une gestion admin.

## Prérequis

- Installer node-js
- Installer wampserer (Voir la parti installation si besoin)
- Installer composer

## Installation de WampServer

1. Télécharger l'installeur wamp sur son site officiel.  

2. Si lors de  installation une fenêtre d'erreur vous indique qu'il vous manques des packages VC++ executer les exe si join 

3. Aller dans les variable denvironement et ajouter php 08.04.15 dans les variable paths global (C:\wamp64\bin\php\08.04.15)

## Installation

### 1. Cloner le dépôt :

   git clone <url-du-repository>

### 2. Env.dev :

    Copier le fichier env.dev coller le a la racine du projet puis renommer le en .env

### 3. Installer composer : 
    
    composer install 

### 4. Installer npm + vue : 
    
    npm install
    npm install vue axios
    npm install @vitejs/plugin-vue

### 5. Créer la base de données :

    php artisan db:seed
    php artisan migrate 
    php artisan db:seed DatabaseSeeder

### 6. Lancer les deux serveurs :

    npm run dev
    php artisan serve 



