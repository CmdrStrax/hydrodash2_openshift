FROM postgres:18.3-trixie

RUN apt-get update
RUN apt-get upgrade -y
RUN apt-get install postgis -y
RUN apt-get install postgresql-18-postgis-3 -y

RUN chgrp -R 0 /var/lib/postgresql && chmod -R g=u /var/lib/postgresql

COPY hydrodash2_dump_18-3.sql /docker-entrypoint-initdb.d/
