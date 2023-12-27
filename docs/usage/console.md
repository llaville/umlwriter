<!-- markdownlint-disable MD013 -->
# Console CLI

Generate UML class diagram from PHP source files should be as simple as running `umlwriter diagram:class`
with one or more source paths (zero configuration by default).

It will however assume some defaults that you might want to change.

You can then find more advanced configuration settings in [the configuration documentation](../01_Features/Configuration.md).
For more information on which options are available, you can run: `umlwriter diagram:class --help`

```text
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
      --executable=EXECUTABLE        Generator external binary resource
      --bootstrap=BOOTSTRAP          A PHP script that is included before graph run
  -c, --configuration=CONFIGURATION  Read configuration from YAML file
      --without-constants            Hide all class constants
      --without-properties           Hide all class properties
      --without-methods              Hide all class methods
      --hide-private                 Hide private methods/properties
      --hide-protected               Hide protected methods/properties
      --no-statement                 Do not show diagram statements
  -h, --help                         Display help for the given command. When no command is given display help for the list command
  -q, --quiet                        Do not output any message
  -V, --version                      Display this application version
      --ansi|--no-ansi               Force (or disable --no-ansi) ANSI output
  -n, --no-interaction               Do not ask any interactive question
  -v|vv|vvv, --verbose               Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```
