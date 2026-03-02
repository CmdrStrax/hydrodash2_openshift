#!/bin/sh

sed -i "s|__POSTGRES_DB__|${POSTGRES_DB}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml
sed -i "s|__POSTGRES_HOST__|${POSTGRES_HOST}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml
sed -i "s|__POSTGRES_PORT__|${POSTGRES_PORT}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml
sed -i "s|__POSTGRES_USER__|${POSTGRES_USER}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml
sed -i "s|__POSTGRES_PASSWORD__|${POSTGRES_PASSWORD}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml

exec "$@"