# Projet Cinéma

## Description

Voici notre projet simulant un cinéma fictif : Le Palace. 
Permettant de réserver des sièges, en fonction des séances des films.
Elle permet aussi une gestion admin.

## Fichiers annexes (/annexes a la racine du projet)

- `annexes/VisualCppRedist_AIO_x86_x64.exe`  
  → Package Microsoft Visual C++ Redistributable tout-en-un (inclut les versions 32 bits (x86) et 64 bits (x64).

- `annexes/vcredist2015_2017_2019_2022_x64.exe`  
  → Package Microsoft Visual C++ Redistributable 2015–2022 (64 bits), requis pour les systèmes Windows 64 bits.

- `annexes/vcredist2015_2017_2019_2022_x86.exe`  
  → Package Microsoft Visual C++ Redistributable 2015–2022 (32 bits), requis pour les applications 32 bits, même sur un système Windows 64 bits.

## Prérequis

- Installer node-js
- Installer wampserer (Voir la partie installation si besoin)
- Installer composer

## Installation de WampServer

1. Télécharger l'installeur wamp sur son site officiel.  

2. Si lors de  l'installation une fenêtre d'erreur vous indique qu'il vous manque des packages VC++, exécutez les fichiers exe ci-joint dans annexes. 

3. Aller dans les variable denvironement et ajouter php 08.04.15 dans les variable paths global (C:\wamp64\bin\php\08.04.15).

## Installation

### 1. Cloner le dépôt :

   git clone https://github.com/ceffDptInfo/projetCinema.git

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



