# Wordpress dev enviroment with Finish Scout theme

This repo holds my simple wordpress dev setup. Finish scout theme is preset for installation.

## Docker setup

- Wordpress
- Mariadb

## How to run

### Start in dev mode

```
docker-compose up
```

### Start in prod mode

Prod mode without volumes
```
docker-compose -f docker-compose.yml build
docker-compose -f docker-compose.yml up
```
