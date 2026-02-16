FROM postgres:18.1-trixie

RUN apt-get update
RUN apt-get upgrade -y
RUN apt-get install postgis -y
RUN apt-get install postgresql-17-postgis-3 -y

ENV POSTGRES_DB hydrodash2
ENV POSTGRES_USER strax
ENV POSTGRES_PASSWORD strax

RUN chgrp -R 0 /docker-entrypoint-initdb.d/ && chmod -R g=u /docker-entrypoint-initdb.d/

COPY hydrodash2_dump.sql /docker-entrypoint-initdb.d/
