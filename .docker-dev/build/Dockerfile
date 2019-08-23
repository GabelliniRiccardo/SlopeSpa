FROM slope/baseimage:0.2.0

ENV DEBIAN_FRONTEND noninteractive

WORKDIR /var/www

########################################################################################################################
### Install dependencies ###############################################################################################
########################################################################################################################

RUN apt-get update -y && \
    apt-get install -y \
# PHP extensions needed for development
      php7.2-xdebug \
# Other PHP extensions needed for XLS parsing
      php7.2-gd \
      php7.2-zip \
      php7.2-ldap \
      php7.2-curl \
# We need postfix to send e-mails when in development
      postfix

########################################################################################################################
### Tweak default configurations #######################################################################################
########################################################################################################################

# Add custom configuration for nginx
COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY nginx/sites-available /etc/nginx/sites-available

# Add custom startup scripts
COPY my_init.d/* /etc/my_init.d

# Configure xdebug extension but disable it by default
RUN sed -i "s|zend_extension=xdebug.so|;zend_extension=xdebug.so|" /etc/php/7.2/mods-available/xdebug.ini && \
    echo "xdebug.remote_host = localhost" >> /etc/php/7.2/mods-available/xdebug.ini && \
    echo "xdebug.remote_enable = 1" >> /etc/php/7.2/mods-available/xdebug.ini && \
# Disable opcache extension (tedious in development)
    sed -i "s|zend_extension=opcache.so|;zend_extension=opcache.so|" /etc/php/7.2/mods-available/opcache.ini && \
# Raise PHP memory limit (often, more memory is needed in development)
    sed -i "s|memory_limit = 128M|memory_limit = 256M|" /etc/php/7.2/fpm/php.ini && \
# Enable LDAP extension
    sed -i "s|;extension=ldap|extension=ldap|" /etc/php/7.2/fpm/php.ini && \
# Remove the termination timout
    sed -i "s|;request_terminate_timeout = 0|request_terminate_timeout = 0|" /etc/php/7.2/fpm/pool.d/www.conf && \

# Enable SSH for development
    rm -f /etc/service/sshd/down && \
    /usr/sbin/enable_insecure_key
