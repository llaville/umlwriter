# syntax=docker/dockerfile:1.4
ARG PHP_VERSION=8.2

FROM php:${PHP_VERSION}-cli-alpine

ARG PACKAGE_CONSTRAINT=4.3.x-dev

# https://github.com/opencontainers/image-spec/blob/main/annotations.md

LABEL org.opencontainers.image.title="llaville/umlwriter"
LABEL org.opencontainers.image.description="Docker image of bartlett/umlwriter Composer package"
LABEL org.opencontainers.image.source="https://github.com/llaville/umlwriter"
LABEL org.opencontainers.image.licenses="MIT"
LABEL org.opencontainers.image.authors="llaville"

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh \
  && cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# Install dependencies
RUN apk add --no-cache --update git bash graphviz ttf-dejavu

# Create a group and user
RUN addgroup appgroup && adduser appuser -D -G appgroup

# Tell docker that all future commands should run as the appuser user
USER appuser

# Install Composer v2 binary version
COPY --from=composer/composer:2-bin /composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_PREFER_STABLE 1
RUN composer global config allow-plugins.cweagans/composer-patches true && \
    composer global config minimum-stability dev && \
    composer global require --no-progress bartlett/umlwriter $PACKAGE_CONSTRAINT

# Following recommendation at https://docs.github.com/en/actions/creating-actions/dockerfile-support-for-github-actions#workdir

ENTRYPOINT ["/entrypoint.sh"]
