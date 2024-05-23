<!-- markdownlint-disable MD013 -->
# Installation

1. [Requirements](#requirements)
1. [PHAR](#phar)
1. [Docker](#docker)
1. [Phive](#phive)
1. [Composer](#composer)
1. [Git](#git)

## Requirements

* PHP 8.2 or greater
* [graphp/graph](https://github.com/graphp/graph) package from master branch (considered as future stable v1.0.0)
* [graphp/graphviz](https://github.com/graphp/graphviz) package from master branch (considered as future stable v1.0.0)
* [bartlett/graph-uml](https://github.com/llaville/graph-uml) Core engine to build UML diagrams in PHP
* [bartlett/graph-plantuml-generator](https://github.com/llaville/graph-plantuml-generator) A PlantUML generator for graph-uml.
* [roave/better-reflection](https://github.com/Roave/BetterReflection) the Reflection API

## PHAR

The preferred method of installation is to use the umlWriter PHAR version which can be downloaded from the most recent
[Github Release][releases]. This method ensures you will not have any dependency conflict issue.

## Docker

Retrieve official image with [Docker][docker]

```shell
docker pull ghcr.io/llaville/umlwriter:v4.2
or
docker pull ghcr.io/llaville/umlwriter:latest
```

## Phive

You can install application globally with [Phive][phive]

```shell
phive install llaville/umlwriter --force-accept-unsigned
```

To upgrade global installation of the application use the following command:

```shell
phive update llaville/umlwriter --force-accept-unsigned
```

You can also install application locally to your project with [Phive][phive] and configuration file `.phive/phars.xml`

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phive xmlns="https://phar.io/phive">
    <phar name="llaville/umlwriter" version="^4.2" copy="false" />
</phive>
```

```shell
phive install --force-accept-unsigned
```

## Composer

The recommended way to install this library is [through composer][composer].
If you don't know yet what is composer, have a look [on introduction][composer-intro].

```shell
composer require bartlett/umlwriter ^4.2
```

If you cannot install it because of a dependency conflict, or you prefer to install it for your project, we recommend
you to take a look at [bamarni/composer-bin-plugin][bamarni/composer-bin-plugin]. Example:

```shell
composer require --dev bamarni/composer-bin-plugin
composer bin umlwriter require --dev bartlett/umlwriter

vendor/bin/umlwriter
```

## Git

The UmlWriter can be directly used from [GitHub][github-repo] by cloning the repository into a directory of your choice.

```shell
git clone -b 4.2 https://github.com/llaville/umlwriter.git
```

## Extra resources

Additionally, you'll have to install GraphViz (`dot` executable) and/or PlantUML jar with Java Runtime (java executable).
Users of Debian/Ubuntu-based distributions may simply invoke:

```shell
sudo apt update
sudo apt-get install graphviz
sudo apt-get install openjdk-17-jre-headless
```

while remaining users should install from [GraphViz Download][graphviz-resources] page
and from [PlantUML Download][plantuml-resources] page.

[releases]: https://github.com/llaville/umlwriter/releases
[composer]: https://getcomposer.org
[composer-intro]: http://getcomposer.org/doc/00-intro.md
[bamarni/composer-bin-plugin]: https://github.com/bamarni/composer-bin-plugin
[github-repo]: https://github.com/llaville/umlwriter.git
[graphviz-resources]: http://www.graphviz.org/download/
[plantuml-resources]: https://plantuml.com/en/download
[phive]: https://github.com/phar-io/phive
[docker]: https://docs.docker.com/get-docker/
