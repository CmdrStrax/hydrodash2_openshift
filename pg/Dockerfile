FROM postgres:18.2-trixie

RUN apt-get update
RUN apt-get upgrade -y
RUN apt-get install postgis -y
RUN apt-get install postgresql-17-postgis-3 -y

COPY hydrodash2_dump.sql /docker-entrypoint-initdb.d/
