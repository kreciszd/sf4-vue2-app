# sf4-vue2-app

docker-compose exec app bash

docker-compose up -d --force-recreate --build
docker-compose up --force-recreate --build


sf4 Vue2 Beer App
========================

Requirements
---
 * Docker


Run project
---
```
git clone https://github.com/DawidKre/sf4-vue2-app.git
cd sf4-vue2-app/
```
Start docker containers:
```
docker-compose up -d
```
Install composer dependencies
```
docker-compose exec backend composer install
```
Install npm dependencies
```
docker-compose exec backend yarn install
docker-compose exec backend yarn encore dev
```
Create app database schema (tables and relations)
```
docker-compose exec backend bin/console doctrine:schema:create 
```
Import data from external Api. Data about beers and brewers
```
docker-compose exec backend bin/console import:beer-data  
```

---
And that is all
You should be 