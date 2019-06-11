FROM slope/baseimage:0.2.0

ENV DEBIAN_FRONTEND noninteractive

WORKDIR /var/www

########################################################################################################################
### Install dependencies ###############################################################################################
########################################################################################################################

RUN apt-get update -y && \
    apt-get install -y \
# Other PHP extensions needed for XLS parsing
      php7.2-gd \
      php7.2-zip \
      php7.2-ldap

########################################################################################################################
### Tweak default configurations #######################################################################################
########################################################################################################################

# Add custom configuration for nginx
COPY .docker/nginx/* /etc/nginx

# Configure xdebug extension but disable it by default
RUN sed -i "s|zend_extension=opcache.so|;zend_extension=opcache.so|" /etc/php/7.2/mods-available/opcache.ini && \
# Raise PHP memory limit (the import process seems to need that)
    sed -i "s|memory_limit = 128M|memory_limit = 256M|" /etc/php/7.2/fpm/php.ini && \
# Enable ldap extension
    sed -i "s|;extension=ldap|extension=ldap|" /etc/php/7.2/fpm/php.ini && \
# Remove the termination timout (the import process needs that)
    sed -i "s|;request_terminate_timeout = 0|request_terminate_timeout = 0|" /etc/php/7.2/fpm/pool.d/www.conf

########################################################################################################################
### Build application ##################################################################################################
########################################################################################################################

# Copy sources
COPY . /var/www

RUN set -x && \
# Source dummy environment variables to let the kernel caches be generated without exceptions for "env not found". These
# variables are not going to be baked into the resulting cached container as we use the %env(VAR)% syntax.
# - Install assets, dump assetic resources and warm cache up
    export $(cat .env.dist | sed '/^#/ d' | xargs ) && \
    export APP_ENV=prod && \
    composer install --no-dev --optimize-autoloader && \
    chmod -R 777 var resources && \
    yarn install && \
    yarn run encore production
