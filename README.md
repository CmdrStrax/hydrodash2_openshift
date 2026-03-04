# HydroDash

## Container

### pg

Postgres DB with Postgis extension. 
Mode: Dockerfile

### geoserver

Postgres Connection set via environment variables.
Custom configuration in geoserver_web.xml (will be revised).
Mode: Dockerfile

### php

CI4 Webapplication for Dashboard.
Postgres Connection and Geoserver Service URLs set via environment variables.
Mode: Dockerfile

## Environment variables

### Postgis

 - POSTGRES_HOST
 - POSTGRES_PORT
 - POSTGRES_DATABASE
 - POSTGRES_USER
 - POSTGRES_PASS

### Geoserver

 - GEOSERVER_ADMIN_USER
 - GEOSERVER_ADMIN_PASSWORD

 - PROXY_BASE_URL -> "https://test.domain/geoserver/"
 - GEOSERVER_CSRF_WHITELIST  -> "test.domain"
 - ENABLE_JSONP -> "true"
 
 - POSTGRES_HOST
 - POSTGRES_PORT
 - POSTGRES_DATABASE
 - POSTGRES_USER
 - POSTGRES_PASS

### PHP Webapp

 - PUBLIC_URL -> "https://test.domain/"
 - GEOSERVER_WMS_URL -> "https://test.domain/geoserver/hydrodash/wms?tiled=true"
 - GEOSERVER_WFS_URL -> "https://test.domain/geoserver/hydrodash/wfs"
 
 - POSTGRES_HOST
 - POSTGRES_PORT
 - POSTGRES_DATABASE
 - POSTGRES_USER
 - POSTGRES_PASS
