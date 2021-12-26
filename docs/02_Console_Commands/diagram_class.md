<!-- markdownlint-disable MD013 -->
# Class Diagrams

UmlWriter 2.0 includes only one command `diagram:class` to print UML class diagram statements.

## Features

* Parse one to many data source (file or directory) at same times with `paths` argument.
* Show (default) or hide all class constants by `--without-constants` option.
* Show (default) or hide all class properties by `--without-properties` option.
* Show (default) or hide all class methods by `--without-methods` option.
* Show (default) or hide private methods and private properties by `--hide-private` options.
* Show (default) or hide protected methods and protected properties by `--hide-protected` options.
* Can be use your own autoloader and initialize what ever you want by `--bootstrap` option.
* Use either `GraphViz`, `PlantUml` or your own generator by `--generator` option.
* Can be able to configure all graph render options and more by `--configuration` option.

## Synoptic

```bash
Description:
  Generate class diagram statements of a given data source

Usage:
  diagram:class [options] [--] [<paths>...]

Arguments:
  paths                              Data source (file or directory)

Options:
  -o, --output=OUTPUT                Path to output image file
      --format=FORMAT                Set output format (depending of each generator)
      --generator=GENERATOR          Graph generator
      --bootstrap=BOOTSTRAP          A PHP script that is included before graph run
  -c, --configuration=CONFIGURATION  Read configuration from YAML file
      --without-constants            Hide all class constants
      --without-properties           Hide all class properties
      --without-methods              Hide all class methods
      --hide-private                 Hide private methods/properties
      --hide-protected               Hide protected methods/properties
  -h, --help                         Display this help message
  -q, --quiet                        Do not output any message
  -V, --version                      Display this application version
      --ansi                         Force ANSI output
      --no-ansi                      Disable ANSI output
  -n, --no-interaction               Do not ask any interactive question
  -v|vv|vvv, --verbose               Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

```

## Examples

Here are a list of concrete examples you can find in **Cookbook**

* Show only public elements in [UmlWriter architecture](../03_Cookbook/01_UmlWriter_public_architecture.md)
* Show only public methods in [UmlWriter architecture](../03_Cookbook/02_UmlWriter_public_methods_only.md)
* Use a [custom autoloader](../03_Cookbook/03_Custom_autoloader.md)

## Architecture

![Console](./console_commands.graphviz.svg)
