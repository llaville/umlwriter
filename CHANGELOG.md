# Change Log

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/),
using the [Keep a CHANGELOG](http://keepachangelog.com) principles.

## [Unreleased]

### Changed

* change case of options names
from [Kebab case](https://en.wikipedia.org/wiki/Letter_case#Special_case_styles) to [Snake case](https://en.wikipedia.org/wiki/Snake_case)

### Fixed

* usage of Symfony OptionsResolver Component in **ConfigurationHandler**

## [2.0.0-beta.3] - 2019-05-14

### Added

* introduces `ContainerService` class implement `psr/container` to handle all internal and runtime services.
* support of EditorConfig (https://editorconfig.org/)
* be able to personalize graph render (at least colors and orientation)
* add some new options to `diagram:class` command:
  - `--without-constants` to hide all class constants
  - `--without-properties` to hide all class properties
  - `--without-methods` to hide all class methods
  - `--hide-private` to hide private methods/properties
  - `--hide-protected` to hide protected methods/properties
* introduces support of external YAML config file that is loaded by `--configuration` option

### Changed

* `diagram:class` command accept multiple data sources (file or directory) at same time.
* console commands used now lazy loading (see https://symfony.com/doc/current/console/lazy_commands.html)

## [2.0.0-beta.2] - 2019-05-03

### Added

* UmlWriter 2.0 is now able to build UML Class diagrams in PlantUML format.
* provides `plantuml.jar` to draw images locally (with help of https://github.com/jawira/plantuml project)

## [2.0.0-beta.1] - 2019-04-24

Two years after [GH-8](https://github.com/llaville/umlwriter/issues/8) report was written,
PHP 7 compatibility is now up and ready with this first new major pre-release version.

UmlWriter 2.0 become a simple facade to [graph-uml](https://github.com/llaville/graph-uml) project
that is able to produce UML diagrams with GraphViz backend. More backends will come later !

Unit tests and documentation should be re-write, and will be available in next pre-release (2.0.0-beta.2)

## [1.3.1] - 2019-11-24

### Added

introduced this CHANGELOG file. See request [#10](https://github.com/llaville/umlwriter/issues/10) by Remi Collet

### Security

security alert [CVE-2019-10910](https://github.com/advisories/GHSA-pgwj-prpq-jpc2) fixed

## [1.3.0] - 2018-11-26

### Added

add support to PHP-Parser 3.1 for running on PHP >= 5.5 and for parsing PHP 5.2 to PHP 7.2

## [1.2.0] - 2017-02-28

### Changed

allow symfony components v3

## [1.1.0] - 2015-12-09

### Removed

drop support to PHP 5.3

## [1.0.0] - 2015-04-02

first stable release
