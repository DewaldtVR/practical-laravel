FROM php:8.2-fpm

ARG APP_USER=www
ARG APP_UID

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    default-mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    nano

# Get NodeJS and NPM
RUN curl -sS https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs

# Get Yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install -y yarn

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN apt-get update \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install mysqli pdo pdo_mysql exif \
    && docker-php-ext-enable pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create system user to run Composer and Artisan Commands
RUN if [ ${APP_UID:-0} -ne 0 ]; \
    then \
    useradd -G www-data,root -u $APP_UID -d /home/$APP_USER $APP_USER; \
    else \
    useradd -G www-data,root -d /home/$APP_USER $APP_USER; \
    fi

# Create Home dir for APP_USER
RUN mkdir -p /home/$APP_USER/.composer && \
    chown -R $APP_USER:$APP_USER /home/$APP_USER

# Copy existing application directory contents with permissions
COPY --chown=${APP_USER}:${APP_USER} ./ /var/www

# Mod Storage
# RUN chmod -R 755 /var/www/storage

# Set working directory
WORKDIR /var/www

# Change current user to APP_USER 
USER ${APP_USER}

# Run artisan migrate and seed
#RUN php artisan migrate --seed

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]