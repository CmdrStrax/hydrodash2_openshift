#!/bin/sh

set -e

# Fill postgis connection

sed -i "s|__POSTGRES_DB__|${POSTGRES_DB}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml
sed -i "s|__POSTGRES_HOST__|${POSTGRES_HOST}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml
sed -i "s|__POSTGRES_PORT__|${POSTGRES_PORT}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml
sed -i "s|__POSTGRES_USER__|${POSTGRES_USER}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml
sed -i "s|__POSTGRES_PASSWORD__|${POSTGRES_PASSWORD}|g" $GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml

# Pass admin credentials from env

GEOSERVER_ADMIN_USER="${GEOSERVER_ADMIN_USER:-admin}"
GEOSERVER_ADMIN_PASS="${GEOSERVER_ADMIN_PASS:-geoserver}"

USERS_FILE="$GEOSERVER_DATA_DIR/security/usergroup/default/users.properties"
ROLES_FILE="$GEOSERVER_DATA_DIR/security/usergroup/default/roles.properties"

mkdir -p "$(dirname "$USERS_FILE")"
mkdir -p "$(dirname "$ROLES_FILE")"

if ! grep -q "^$GEOSERVER_ADMIN_USER=" "$USERS_FILE" 2>/dev/null; then
  echo "Creating GeoServer admin user..."
  echo "$GEOSERVER_ADMIN_USER=$GEOSERVER_ADMIN_PASS,ROLE_ADMIN" > "$USERS_FILE"
  echo "$GEOSERVER_ADMIN_USER=ROLE_ADMIN" > "$ROLES_FILE"
fi

exec "$@"