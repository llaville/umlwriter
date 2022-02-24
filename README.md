<!-- markdownlint-disable MD013 -->
# UmlWriter

**UmlWriter** is a library that adds the ability to generate UML class diagrams.

## Documentation

All the documentation is available on [website](https://llaville.github.io/umlwriter/3.x),
generated from the [docs](https://github.com/llaville/umlwriter/tree/3.x/docs) folder.

For users that still used the unmaintained version 1.3, please visit <http://php5.laurent-laville.org/umlwriter/> for documentation

## PHAR distribution

You can build yourself a PHAR version of this library. Use the [Box Manifest](https://github.com/llaville/box-manifest/) project.

Invoke the following command

```bash
php box-manifest.phar compile --config=box.json.dist

// or simply

php box-manifest.phar compile
```

And find the `umlwriter.phar` file in `bin` directory.

**CAUTION**: It's NOT recommended requiring it as a dependency in `composer.json` of your project,
to avoid including into manifest all components of BoxManifest.

Use instead, either :

- the phar version of `bartlett/box-manifest`
- the docker image of `bartlett/box-manifest`. Available at <https://github.com/llaville/box-manifest/pkgs/container/box-manifest>

Invoke the following command

```bash
docker run --rm -it -v $(pwd):/usr/src ghcr.io/llaville/box-manifest:latest compile --config=box.json.dist

// or simply

docker run --rm -it -v $(pwd):/usr/src ghcr.io/llaville/box-manifest:latest compile
```

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
