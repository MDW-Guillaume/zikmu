# Zik&Mu

## Fonctionnalités

- Authentification ->
- Lecture de musique en arrière plan
- Like de musique (AJAX ?)
- File d'attente ( Stockage de la liste en session ? )
- Lecture au clic sur une chanson

## A noter

### Les musiques

année - durée (minutes) - Artiste - Album

### Les artistes

Trié par genre > image de l'artiste

### Les albums

Nom de l'artiste > img de l'album

### Le code

- Les listes d'albums, de titres et d'artistes peuvent être générées par une fonction. 


## Recherches réalisées

### A réaliser

  - Lecture de musique en arrière plan
  - File d'attente ( Stockage de la liste en session ? )

### Réalisées

## Idées 

### Général

La version mobile peut se transformer en WebApp

## Inspirations

https://koel.dev/

## Installation

```
git clone git@github.com:MDW-Guillaume/zikmu.git
cd zikmu
composer install
nom install
cp .env.example .env
nano .env
```

Edit the Database configuration

```
php artisan migrate
php artisan db:seed
```

Generate the key

```
php artisan key:generate
```

Launch server

```
npm run dev
php artisan serve
```