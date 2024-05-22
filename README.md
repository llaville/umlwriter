<!-- markdownlint-disable MD013 -->
# UmlWriter

[![StandWithUkraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/badges/StandWithUkraine.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)
[![GitHub Discussions](https://img.shields.io/github/discussions/llaville/umlwriter)](https://github.com/llaville/umlwriter/discussions)

| Releases      |                   Branch                    |                              PHP                              |                         Packagist                         |                    License                     |                          Documentation                           |
|:--------------|:-------------------------------------------:|:-------------------------------------------------------------:|:---------------------------------------------------------:|:----------------------------------------------:|:----------------------------------------------------------------:|
| Stable v4.0.x | [![Branch 4.0][Branch_40x-img]][Branch_40x] | [![Minimum PHP Version)][PHPVersion_40x-img]][PHPVersion_40x] | [![Stable Version 4.0][Packagist_40x-img]][Packagist_40x] | [![License 4.0][License_40x-img]][License_40x] | [![Documentation 4.0][Documentation_40x-img]][Documentation_40x] |
| Stable v4.1.x | [![Branch 4.1][Branch_41x-img]][Branch_41x] | [![Minimum PHP Version)][PHPVersion_41x-img]][PHPVersion_41x] | [![Stable Version 4.1][Packagist_41x-img]][Packagist_41x] | [![License 4.1][License_41x-img]][License_41x] | [![Documentation 4.1][Documentation_41x-img]][Documentation_41x] |

[Branch_40x-img]: https://img.shields.io/badge/branch-4.0-orange
[Branch_40x]: https://github.com/llaville/umlwriter/tree/4.0
[PHPVersion_40x-img]: https://img.shields.io/packagist/php-v/bartlett/umlwriter/4.0.0
[PHPVersion_40x]: https://www.php.net/supported-versions.php
[Packagist_40x-img]: https://img.shields.io/badge/packagist-v4.0.1-blue
[Packagist_40x]: https://packagist.org/packages/bartlett/umlwriter
[License_40x-img]: https://img.shields.io/packagist/l/bartlett/umlwriter
[License_40x]: https://github.com/llaville/umlwriter/blob/4.0/LICENSE
[Documentation_40x-img]: https://img.shields.io/badge/documentation-v4.0-green
[Documentation_40x]: https://github.com/llaville/umlwriter/tree/4.0/docs

[Branch_41x-img]: https://img.shields.io/badge/branch-4.1-orange
[Branch_41x]: https://github.com/llaville/umlwriter/tree/4.1
[PHPVersion_41x-img]: https://img.shields.io/packagist/php-v/bartlett/umlwriter/4.1.0
[PHPVersion_41x]: https://www.php.net/supported-versions.php
[Packagist_41x-img]: https://img.shields.io/badge/packagist-v4.1.0-blue
[Packagist_41x]: https://packagist.org/packages/bartlett/umlwriter
[License_41x-img]: https://img.shields.io/packagist/l/bartlett/umlwriter
[License_41x]: https://github.com/llaville/umlwriter/blob/4.1/LICENSE
[Documentation_41x-img]: https://img.shields.io/badge/documentation-v4.1-green
[Documentation_41x]: https://github.com/llaville/umlwriter/tree/4.1/docs

**UmlWriter** is a library that adds the ability to generate UML class diagrams.

## Documentation

All the documentation is available on [website](https://llaville.github.io/umlwriter/4.1),
generated from the [docs](https://github.com/llaville/umlwriter/tree/4.1/docs) folder.

## Usage

This library includes a console CLI version with only one command: `diagram:class`

```bash
bin/umlwriter diagram:class src/
```

**NOTE** use verbose level 1 or 2 for more details.

## Contributors

- Laurent Laville (Lead Developer)

## Credits

[bartlett/graph-uml](https://github.com/llaville/graph-uml) is a refactored version (with more features) of [clue/graph-uml](https://github.com/clue/graph-uml) project, licensed under MIT.
