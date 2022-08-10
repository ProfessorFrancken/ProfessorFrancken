# Contributing

# New instructions

```sh
git clone --branch dev-contributing https://github.com/ProfessorFrancken/ProfessorFrancken.git
cd ProfessorFrancken

cp .env.example .env

docker network create traefik_web

# Try to pull the images
docker compose pull

# If pulling images didn't work, try building manually
docker compose build php-base
docker compose build php
docker compose build scheduler
docker compose build queue-worker
docker compose build nginx
docker compose build php-coverage

docker compose run php composer install
docker compose run npm npm install
docker compose run npm npm run dev
docker compose run php php artisan key:generate
docker compose run php php artisan migrate:refresh --seed
docker compose up nginx
```
