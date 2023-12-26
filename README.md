<!-- markdownlint-disable MD013 -->
# UmlWriter
[![StandWithUkraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/badges/StandWithUkraine.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)
[![GitHub Discussions](https://img.shields.io/github/discussions/llaville/umlwriter)](https://github.com/llaville/umlwriter/discussions)

| Releases      |                   Branch                    |                              PHP                              |                         Packagist                         |                    License                     |                          Documentation                           |
|:--------------|:-------------------------------------------:|:-------------------------------------------------------------:|:---------------------------------------------------------:|:----------------------------------------------:|:----------------------------------------------------------------:|
| Stable v3.4.x | [![Branch 3.4][Branch_34x-img]][Branch_34x] | [![Minimum PHP Version)][PHPVersion_34x-img]][PHPVersion_34x] | [![Stable Version 3.4][Packagist_34x-img]][Packagist_34x] | [![License 3.4][License_34x-img]][License_34x] | [![Documentation 3.4][Documentation_34x-img]][Documentation_34x] |
| Stable v4.0.x | [![Branch 4.0][Branch_40x-img]][Branch_40x] | [![Minimum PHP Version)][PHPVersion_40x-img]][PHPVersion_40x] | [![Stable Version 4.0][Packagist_40x-img]][Packagist_40x] | [![License 4.0][License_40x-img]][License_40x] | [![Documentation 4.0][Documentation_40x-img]][Documentation_40x] |

[Branch_34x-img]: https://img.shields.io/badge/branch-3.4-orange
[Branch_34x]: https://github.com/llaville/umlwriter/tree/3.4
[PHPVersion_34x-img]: https://img.shields.io/packagist/php-v/bartlett/umlwriter/3.4.0
[PHPVersion_34x]: https://www.php.net/supported-versions.php
[Packagist_34x-img]: https://img.shields.io/badge/packagist-v3.4.0-blue
[Packagist_34x]: https://packagist.org/packages/bartlett/umlwriter
[License_34x-img]: https://img.shields.io/packagist/l/bartlett/umlwriter
[License_34x]: https://github.com/llaville/umlwriter/blob/3.4/LICENSE
[Documentation_34x-img]: https://img.shields.io/badge/documentation-v3.4-green
[Documentation_34x]: https://github.com/llaville/umlwriter/tree/3.4/docs

[Branch_40x-img]: https://img.shields.io/badge/branch-4.0-orange
[Branch_40x]: https://github.com/llaville/umlwriter/tree/4.0
[PHPVersion_40x-img]: https://img.shields.io/packagist/php-v/bartlett/umlwriter/4.0.0
[PHPVersion_40x]: https://www.php.net/supported-versions.php
[Packagist_40x-img]: https://img.shields.io/badge/packagist-v4.0.0-blue
[Packagist_40x]: https://packagist.org/packages/bartlett/umlwriter
[License_40x-img]: https://img.shields.io/packagist/l/bartlett/umlwriter
[License_40x]: https://github.com/llaville/umlwriter/blob/4.0/LICENSE
[Documentation_40x-img]: https://img.shields.io/badge/documentation-v4.0-green
[Documentation_40x]: https://github.com/llaville/umlwriter/tree/4.0/docs


**UmlWriter** is a library that adds the ability to generate UML class diagrams.

## Documentation

All the documentation is available on [website](https://llaville.github.io/umlwriter/4.0),
generated from the [docs](https://github.com/llaville/umlwriter/tree/4.0/docs) folder.

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
