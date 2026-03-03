#!/bin/sh

set -e

# Fill postgis connection

sed -i "s|__POSTGRES_DATABASE__|${POSTGRES_DATABASE}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml
sed -i "s|__POSTGRES_HOST__|${POSTGRES_HOST}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml
sed -i "s|__POSTGRES_PORT__|${POSTGRES_PORT}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml
sed -i "s|__POSTGRES_USER__|${POSTGRES_USER}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml
sed -i "s|__POSTGRES_PASSWORD__|${POSTGRES_PASSWORD}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml

# Pass admin credentials from env

sed -i "s|__GEO_USER__|${GEOSERVER_ADMIN_USER}|g" $GEOSERVER_DATA_DIR/security/usergroup/default/users.xml
sed -i "s|__GEO_PASSWORD__|${GEOSERVER_ADMIN_PASSWORD}|g" $GEOSERVER_DATA_DIR/security/usergroup/default/users.xml
sed -i "s|__GEO_USER__|${GEOSERVER_ADMIN_USER}|g" $GEOSERVER_DATA_DIR/security/role/default/roles.xml

exec "$@"