FROM docker.osgeo.org/geoserver:2.28.x

# Serve web.xml with WFS->JSON enabled

COPY ./geoserver_web.xml /opt/config_overrides/web.xml

# Serve data directory

#RUN chgrp -R 0 /opt/geoserver_data && chmod -R g=u /opt/geoserver_data
COPY ./data /opt/geoserver_data

# Set owner of operational directories to arbitrary user

#RUN chgrp -R 0 /opt/geoserver_data && chmod -R g=u /opt/geoserver_data
#RUN chgrp -R 0 /usr/local/tomcat/webapps/geoserver && chmod -R g=u /usr/local/tomcat/webapps/geoserver
#RUN chgrp -R 0 /usr/local/tomcat/conf && chmod -R g=u /usr/local/tomcat/conf
#RUN chgrp -R 0 /usr/local/tomcat/conf/server.xml && chmod -R g=u /usr/local/tomcat/conf/server.xml

