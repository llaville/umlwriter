<!-- markdownlint-disable MD013 -->
# UmlWriter

| Stable | Upcoming |
|:------:|:--------:|
| [![Latest Stable Version](https://img.shields.io/packagist/v/bartlett/umlwriter)](https://packagist.org/packages/bartlett/umlwriter) | [![Unstable Version](https://img.shields.io/packagist/vpre/bartlett/umlwriter)](https://packagist.org/packages/bartlett/umlwriter) |
| [![Minimum PHP Version)](https://img.shields.io/packagist/php-v/bartlett/umlwriter)](https://php.net/) | [![Minimum PHP Version)](https://img.shields.io/packagist/php-v/bartlett/umlwriter/2.x-dev?color=orange)](https://php.net/) |

**CAUTION** Major rewrite 2.0 is still in beta stage. For a stable version, check [branch 1.3](https://github.com/llaville/umlwriter/tree/1.3)

**UmlWriter** is a library that adds the ability to generate UML class diagrams.

Source code analysed by this [parser Reflection API](https://github.com/goaop/parser-reflection)

## Documentation

All the documentation is available on [website](https://llaville.github.io/umlwriter),
generated from the [docs](https://github.com/llaville/umlwriter/tree/master/docs) folder.

Visit <http://php5.laurent-laville.org/umlwriter/> for documentation of v1.x

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

## License

This library is licensed under the MIT License - see the `LICENSE` file for details
