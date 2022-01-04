<!-- markdownlint-disable MD013 -->
# UmlWriter

| Stable v2 | Stable v3 |
|:---------:|:---------:|
|           | [![Branch Master](https://img.shields.io/badge/branch-master-orange)](https://github.com/llaville/umlwriter) |
| [![Latest Stable Version](https://img.shields.io/badge/packagist-v2.1.1-blue)](https://packagist.org/packages/bartlett/umlwriter) | [![Latest Stable Version](https://img.shields.io/packagist/v/bartlett/umlwriter)](https://packagist.org/packages/bartlett/umlwriter)
| [![Minimum PHP Version)](https://img.shields.io/packagist/php-v/bartlett/umlwriter/2.x-dev)](https://php.net/supported-versions.php) | [![Minimum PHP Version)](https://img.shields.io/packagist/php-v/bartlett/umlwriter/3.x-dev)](https://php.net/supported-versions.php) |
| [![License](https://img.shields.io/packagist/l/bartlett/umlwriter)](https://github.com/llaville/umlwriter/blob/master/LICENSE) | [![License](https://img.shields.io/packagist/l/bartlett/umlwriter)](https://github.com/llaville/umlwriter/blob/master/LICENSE) |

[![GitHub Discussions](https://img.shields.io/github/discussions/llaville/umlwriter)](https://github.com/llaville/umlwriter/discussions)
[![Mega-Linter](https://github.com/llaville/umlwriter/actions/workflows/mega-linter.yml/badge.svg)](https://github.com/llaville/umlwriter/actions/workflows/mega-linter.yml)
[![GitHub-Pages](https://github.com/llaville/umlwriter/actions/workflows/gh-pages.yml/badge.svg)](https://github.com/llaville/umlwriter/actions/workflows/gh-pages.yml)

**UmlWriter** is a library that adds the ability to generate UML class diagrams.

## Documentation

| GH Pages v2 | GH Pages v3 |
|:-----------:|:-----------:|
| [![Documentation](https://img.shields.io/badge/documentation-v2.x-green)](https://github.com/llaville/umlwriter/tree/2.x/docs) | [![Documentation](https://img.shields.io/badge/documentation-v3.x-green)](https://github.com/llaville/umlwriter/tree/3.x/docs) |

All the documentation is available on following websites generated from the docs folder.

- <http://llaville.github.io/umlwriter/2.x/>
- <http://llaville.github.io/umlwriter/3.x/>

For users that still used the unmaintained version 1.3, please visit <http://php5.laurent-laville.org/umlwriter/> for documentation

## PHAR distribution

You can build yourself a PHAR version of this library. Use the [Box](https://github.com/box-project/box) project.

Invoke the following command

```bash
php box.phar compile --config=box.json.dist

// or simply

php box.phar compile
```

And find the `umlwriter.phar` file in `bin` directory.

## Usage

This library includes a console CLI version with only one command: `diagram:class`

```bash
bin/umlwriter diagram:class src/ --generator graphviz
```

**NOTE** use verbose level 1 or 2 for more details.

## Contributors

* Laurent Laville (Lead Developer)

## Credits

[bartlett/graph-uml](https://github.com/llaville/graph-uml) is a refactored version (with more features) of [clue/graph-uml](https://github.com/clue/graph-uml) project, licensed under MIT.
