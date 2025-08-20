<!-- markdownlint-disable MD013 -->
# UmlWriter

[![StandWithUkraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/badges/StandWithUkraine.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)
[![GitHub Discussions](https://img.shields.io/github/discussions/llaville/umlwriter)](https://github.com/llaville/umlwriter/discussions)

| Releases      |                   Branch                    |                              PHP                              |                         Packagist                         |                    License                     |                          Documentation                           |
|:--------------|:-------------------------------------------:|:-------------------------------------------------------------:|:---------------------------------------------------------:|:----------------------------------------------:|:----------------------------------------------------------------:|
| Stable v4.1.x | [![Branch 4.1][Branch_41x-img]][Branch_41x] | [![Minimum PHP Version)][PHPVersion_41x-img]][PHPVersion_41x] | [![Stable Version 4.1][Packagist_41x-img]][Packagist_41x] | [![License 4.1][License_41x-img]][License_41x] | [![Documentation 4.1][Documentation_41x-img]][Documentation_41x] |
| Stable v4.2.x | [![Branch 4.2][Branch_42x-img]][Branch_42x] | [![Minimum PHP Version)][PHPVersion_42x-img]][PHPVersion_42x] | [![Stable Version 4.2][Packagist_42x-img]][Packagist_42x] | [![License 4.2][License_42x-img]][License_42x] | [![Documentation 4.2][Documentation_42x-img]][Documentation_42x] |
| Stable v4.3.x | [![Branch 4.3][Branch_43x-img]][Branch_43x] | [![Minimum PHP Version)][PHPVersion_43x-img]][PHPVersion_43x] | [![Stable Version 4.3][Packagist_43x-img]][Packagist_43x] | [![License 4.3][License_43x-img]][License_43x] | [![Documentation 4.3][Documentation_43x-img]][Documentation_43x] |
| Stable v4.4.x | [![Branch 4.4][Branch_44x-img]][Branch_44x] | [![Minimum PHP Version)][PHPVersion_44x-img]][PHPVersion_44x] | [![Stable Version 4.4][Packagist_44x-img]][Packagist_44x] | [![License 4.4][License_44x-img]][License_44x] | [![Documentation 4.4][Documentation_44x-img]][Documentation_44x] |

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

[Branch_42x-img]: https://img.shields.io/badge/branch-4.2-orange
[Branch_42x]: https://github.com/llaville/umlwriter/tree/4.2
[PHPVersion_42x-img]: https://img.shields.io/packagist/php-v/bartlett/umlwriter/4.2.2
[PHPVersion_42x]: https://www.php.net/supported-versions.php
[Packagist_42x-img]: https://img.shields.io/badge/packagist-v4.2.2-blue
[Packagist_42x]: https://packagist.org/packages/bartlett/umlwriter
[License_42x-img]: https://img.shields.io/packagist/l/bartlett/umlwriter
[License_42x]: https://github.com/llaville/umlwriter/blob/4.2/LICENSE
[Documentation_42x-img]: https://img.shields.io/badge/documentation-v4.2-green
[Documentation_42x]: https://github.com/llaville/umlwriter/tree/4.2/docs

[Branch_43x-img]: https://img.shields.io/badge/branch-4.3-orange
[Branch_43x]: https://github.com/llaville/umlwriter/tree/4.3
[PHPVersion_43x-img]: https://img.shields.io/packagist/php-v/bartlett/umlwriter/4.3.0
[PHPVersion_43x]: https://www.php.net/supported-versions.php
[Packagist_43x-img]: https://img.shields.io/badge/packagist-v4.3.0-blue
[Packagist_43x]: https://packagist.org/packages/bartlett/umlwriter
[License_43x-img]: https://img.shields.io/packagist/l/bartlett/umlwriter
[License_43x]: https://github.com/llaville/umlwriter/blob/4.3/LICENSE
[Documentation_43x-img]: https://img.shields.io/badge/documentation-v4.3-green
[Documentation_43x]: https://github.com/llaville/umlwriter/tree/4.3/docs

[Branch_44x-img]: https://img.shields.io/badge/branch-4.4-orange
[Branch_44x]: https://github.com/llaville/umlwriter/tree/4.4
[PHPVersion_44x-img]: https://img.shields.io/packagist/php-v/bartlett/umlwriter/4.4.0
[PHPVersion_44x]: https://www.php.net/supported-versions.php
[Packagist_44x-img]: https://img.shields.io/badge/packagist-v4.4.0-blue
[Packagist_44x]: https://packagist.org/packages/bartlett/umlwriter
[License_44x-img]: https://img.shields.io/packagist/l/bartlett/umlwriter
[License_44x]: https://github.com/llaville/umlwriter/blob/4.4/LICENSE
[Documentation_44x-img]: https://img.shields.io/badge/documentation-v4.4-green
[Documentation_44x]: https://github.com/llaville/umlwriter/tree/4.4/docs

**UmlWriter** is a library that adds the ability to generate UML class diagrams.

## Documentation

All the documentation is available on [website](https://llaville.github.io/umlwriter/4.4),
generated from the [docs](https://github.com/llaville/umlwriter/tree/4.4/docs) folder.

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
