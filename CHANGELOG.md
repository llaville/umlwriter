<!-- markdownlint-disable MD013 MD024 -->
# Change Log

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/),
using the [Keep a CHANGELOG](http://keepachangelog.com) principles.

## [Unreleased]

### Changed

- Support **Typed properties** features, now minimum PHP requirement is 8.0

  Read more about this feature at :

  - <https://stitcher.io/blog/typed-properties-in-php-74>
  - <https://php.watch/versions/7.4/typed-properties>

## [2.1.0] - 2021-12-25

### Added

- `no-statement` option to `diagram:class` command to hide diagram statements (displayed by default)
- more examples, used to generate dynamically diagrams for documentation

### Changed

- update all examples to generate image in target folder, if provided as first argument
- CI generated svg images dynamically to be sure to have the latest version
- raise `bartlett/graph-uml` and `bartlett/graph-plantuml-generator` minimum version

## [2.0.0] - 2021-12-02

### Changed

- switch LICENSE from BSD 3-Clause "New" or "Revised" License to MIT
- migrate from `goaop/parser-reflection` v2 to `roave/better-reflection` v4 (PHP 8 not yet compatible)
- only PHP 7 compatible

## [2.0.0-rc.3] - 2021-11-20

### Changed

- Allow installation with PHP 8
- Remove `graphp/graphviz` fork usage since `bartlett/graph-uml` 1.0.0-rc.3
- Patch `graphp/graphviz` package with <https://github.com/cweagans/composer-patches> rather than using forks with branches

If you need a good introduction about vendor patches,
read this excellent article <https://tomasvotruba.com/blog/2020/07/02/how-to-patch-package-in-vendor-yet-allow-its-updates/>

## [2.0.0-rc.2] - 2019-09-10

### Changed

- raise `bartlett/graph-uml` and `bartlett/graph-plantuml-generator` dependencies to version `1.0.0-rc.2`

## [2.0.0-rc.1] - 2019-05-31

### Added

- add `--output` option to save image in a file.
- add `--format` option to specify what is the format of image to build.

### Changed

- change case of options names
from [Kebab case](https://en.wikipedia.org/wiki/Letter_case#Special_case_styles) to [Snake case](https://en.wikipedia.org/wiki/Snake_case)

### Fixed

- usage of Symfony OptionsResolver Component in **ConfigurationHandler**
- usage of Symfony Finder allows now to parse a combination of folder and file at same times.
 See `docs/01_Features/umlwriter_config.svg` for example.

## [2.0.0-beta.3] - 2019-05-14

### Added

- introduces `ContainerService` class implement `psr/container` to handle all internal and runtime services.
- support of EditorConfig (<https://editorconfig.org/>)
- be able to personalize graph render (at least colors and orientation)
- add some new options to `diagram:class` command:
  - `--without-constants` to hide all class constants
  - `--without-properties` to hide all class properties
  - `--without-methods` to hide all class methods
  - `--hide-private` to hide private methods/properties
  - `--hide-protected` to hide protected methods/properties
- introduces support of external YAML config file that is loaded by `--configuration` option

### Changed

- `diagram:class` command accept multiple data sources (file or directory) at same time.
- console commands used now lazy loading (see <https://symfony.com/doc/current/console/lazy_commands.html>)

## [2.0.0-beta.2] - 2019-05-03

### Added

- UmlWriter 2.0 is now able to build UML Class diagrams in PlantUML format.
- provides `plantuml.jar` to draw images locally (with help of <https://github.com/jawira/plantuml> project)

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
