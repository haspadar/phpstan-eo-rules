# SPDX-FileCopyrightText: 2025 Konstantinas Mesnikas
#
# SPDX-License-Identifier: MIT
FROM php:8.2-cli

LABEL maintainer="haspadar@gmail.com"
LABEL org.opencontainers.image.source="https://github.com/haspadar/phpstan-eo-rules"
LABEL org.opencontainers.image.description="Development environment for PHPStan EO Rules"

# Install system dependencies and PHP extensions
SHELL ["/bin/bash", "-o", "pipefail", "-c"]
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    zip \
    curl \
    bash \
    fish \
    python3 \
    python3-pip \
    libzip-dev \
    libicu-dev \
    zlib1g-dev \
    libonig-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && docker-php-ext-install intl zip mbstring \
    && pip3 install --no-cache-dir --break-system-packages reuse \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Install Hadolint for Dockerfile linting
RUN curl -sL -o /usr/local/bin/hadolint \
    "https://github.com/hadolint/hadolint/releases/download/v2.12.0/hadolint-Linux-x86_64" \
    && chmod +x /usr/local/bin/hadolint

# Set timezone
ENV TZ=UTC
RUN ln -fs /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Set working directory
WORKDIR /app

# Default command
CMD ["bash"]