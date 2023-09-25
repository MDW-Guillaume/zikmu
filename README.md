# Zik&Mu

## Installation

```
git clone git@github.com:MDW-Guillaume/zikmu.git
cd zikmu
composer install
npm install
cp .env.example .env
nano .env
```

Copier les dossiers dans le projet afin d'avoir cette arborescence 

```
storage/
├── app/
|   ├── albums/
|   ├── artistes/
|   ├── music-20s/

```

Creation of symbolic links
php artisan storage:link


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

## Idées 

### Général

La version mobile peut se transformer en WebApp

## Figma

https://www.figma.com/file/OU0s4ABT3h2eyCGnVSllfB/Ziq%26MU?type=design&node-id=127%3A0&mode=design&t=G2YfU8FHV4ip77Lv-1
