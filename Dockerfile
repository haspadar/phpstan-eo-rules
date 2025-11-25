# SPDX-FileCopyrightText: 2025 Konstantinas Mesnikas
#
# SPDX-License-Identifier: MIT

FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip zip curl bash fish \
    python3 python3-pip \
    libzip-dev libicu-dev zlib1g-dev libonig-dev \
    && docker-php-ext-install \
    intl zip mbstring \
    && pip3 install --break-system-packages reuse \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Set timezone
ENV TZ=UTC
RUN ln -fs /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Set working directory
WORKDIR /app

# Default command
CMD ["bash"]