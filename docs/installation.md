<!-- markdownlint-disable MD013 -->
# Installation

1. [Requirements](#requirements)
1. [PHAR](#phar)
1. [Docker](#docker)
1. [Phive](#phive)
1. [Composer](#composer)

## Requirements

| Version | Status                 | Requirements   |
|:--------|:-----------------------|:---------------|
| **4.0** | **Active development** | **PHP >= 8.1** |
| 3.4     | Active support         | PHP >= 8.0     |
| 2.x     | End Of Life            | PHP >= 7.1     |

## PHAR

The preferred method of installation is to use the UmlWriter PHAR which can be downloaded from the most recent
[Github Release][releases]. This method ensures you will not have any dependency conflict issue.

## Docker

You can install `umlwriter` with [Docker][docker]

```shell
docker pull ghcr.io/llaville/umlwriter:v4
or
docker pull ghcr.io/llaville/umlwriter:latest
```

## Phive

You can install `umlwriter` with [Phive][phive]

```shell
phive install llaville/umlwriter --force-accept-unsigned
```

To upgrade `umlwriter` use the following command:

```shell
phive update llaville/umlwriter --force-accept-unsigned
```

## Composer

You can install `umlwriter` with [Composer][composer]

```shell
composer global require bartlett/umlwriter ^4
```

If you cannot install it because of a dependency conflict, or you prefer to install it for your project, we recommend
you to take a look at [bamarni/composer-bin-plugin][bamarni/composer-bin-plugin]. Example:

```shell
composer require --dev bamarni/composer-bin-plugin
composer bin umlwriter require --dev bartlett/umlwriter

vendor/bin/umlwriter
```

[releases]: https://github.com/llaville/umlwriter/releases
[composer]: https://getcomposer.org
[bamarni/composer-bin-plugin]: https://github.com/bamarni/composer-bin-plugin
[phive]: https://github.com/phar-io/phive
[docker]: https://docs.docker.com/get-docker/
