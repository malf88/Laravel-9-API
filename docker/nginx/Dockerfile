FROM nginx:1.17
ENV APP_NAME=default
RUN apt-get update && \
   DEBIAN_FRONTEND=noninteractive apt-get install -y \
   nginx-extras

COPY ./docker/nginx/config/default.conf /etc/nginx/sites-enabled/default 
RUN sed -i '1 ienv APP_NAME;' /etc/nginx/nginx.conf
