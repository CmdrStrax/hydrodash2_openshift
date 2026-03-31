#!/bin/sh

set -x

escape() {
  printf '%s' "$1" | sed -e ':a' -e 'N' -e '$!ba' -e 's/[\/&|]/\\&/g'
}

#
# Fill postgis connection
#

sed -i'' "s|__POSTGRES_DATABASE__|$(escape "$POSTGRES_DATABASE")|g" "$GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml"
sed -i'' "s|__POSTGRES_HOST__|$(escape "$POSTGRES_HOST")|g" "$GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml"
sed -i'' "s|__POSTGRES_PORT__|$(escape "$POSTGRES_PORT")|g" "$GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml"
sed -i'' "s|__POSTGRES_USER__|$(escape "$POSTGRES_USER")|g" "$GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml"
sed -i'' "s|__POSTGRES_PASSWORD__|$(escape "$POSTGRES_PASSWORD")|g" "$GEOSERVER_DATA_DIR/workspaces/hydrodash/hydrodash/datastore.xml"

#
# Pass admin credentials from env
#

sed -i'' "s|__GEO_USER__|$(escape "$GEOSERVER_ADMIN_USER")|g" "$GEOSERVER_DATA_DIR/security/usergroup/default/users.xml"
sed -i'' "s|__GEO_PASSWORD__|$(escape "$GEOSERVER_ADMIN_PASSWORD")|g" "$GEOSERVER_DATA_DIR/security/usergroup/default/users.xml"
sed -i'' "s|__GEO_USER__|$(escape "$GEOSERVER_ADMIN_USER")|g" "$GEOSERVER_DATA_DIR/security/role/default/roles.xml"

#
# Pass custom web.xml
#

cp /opt/config_overrides/web.xml \
   /usr/local/tomcat/webapps/geoserver/WEB-INF/web.xml

#
# (future work) Pass custom config with env-variables
#

# Alter PROXY_BASE_URL and GEOSERVER_CSRF_WHITELIST from env.-variables

sed -i'' "s|__PROXY_BASE_URL__|$(escape "$PROXY_BASE_URL")|g" "/opt/config_overrides/custom_web.xml"
sed -i'' "s|__GEOSERVER_CSRF_WHITELIST__|$(escape "$GEOSERVER_CSRF_WHITELIST")|g" "/opt/config_overrides/custom_web.xml"

# Insert custom config before </web-app>

#sed -i'' '/<\/web-app>/e cat /opt/config_overrides/custom_web.xml' "/usr/local/tomcat/webapps/geoserver/WEB-INF/web.xml"
awk '
/<\/web-app>/ {
  system("cat /opt/config_overrides/custom_web.xml")
}
{ print }
' "/usr/local/tomcat/webapps/geoserver/WEB-INF/web.xml" \
> /tmp/web.xml && mv /tmp/web.xml "/usr/local/tomcat/webapps/geoserver/WEB-INF/web.xml"

exec "$@"
