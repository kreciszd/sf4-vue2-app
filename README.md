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
Add new entries to hosts file:
```
127.0.0.1 phpadmin.app.beer
127.0.0.1 app.beer
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
You should be able to test aplication at:
http://localhost:8080/
---
Links:
---
Frontend aplication with vue:

- http://localhost:8080/

Backend api documentation with possibility of testing it:

- http://app.beer/api

phpMyAdmin:

- http://phpadmin.app.beer

Importer:
---
Importer is placed in backend Console command 
this command will start importer:
```
docker-compose exec backend bin/console import:beer-data  
```
Errors, informations from importer are stored and logged in `/var/log/importer_dev.log`
This was done with Symfony EventSubscriber.

Importer pulls data from api http://ontariobeerapi.ca and https://restcountries.eu (Country codes by country name) This is done in `Service/ExternalApiService.php`

Api:
---
Database structure and tables was done by symfony entities.

Api was done by Api Platform https://api-platform.com/. Setting for api is in every entity annotations
Custom filtering for Brewers (by beers count) is done in api platform  custom filter in `Filter\BeersCountOrderFilter.php`
Additionally, documentation has been created automatically.

Front:
---
Frontend applications is SPA done in Vue.js 2 and Vue framework called Vuetify https://vuetifyjs.com
Data is provided from api. There is server side pagination, filtering and sorting.


TODO:
---
Main thing todo is write some tests unfortunately I did not make it in time although I really wanted to.

Add also there is needed deploy to production setup

Importer: 
- Optimize importer queries and working
- Update records if there is some changes in api
- Run importer periodically

Frontend 
- Overall refactor mainly in filters components
- Mobile friendly

Opportunities to expand:
---
- Import more data from api (shops, availability) 
- Add custom CRUD operations
- Authentication
- Add this to frontend