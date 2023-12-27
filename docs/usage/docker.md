<!-- markdownlint-disable MD013 -->
# Docker CLI

**IMPORTANT** : Docker image with `latest` tag use the PHP 8.1 runtime !

> Please mount your source code to `/workdir` in the container.

If you want to analyse a `src/` folder in your source code, after mounting it, please don't forget to specify a full path
based on `/workdir`, i.e: `/workdir/src`

```shell
docker run --rm -t -v "${PWD}":/workdir ghcr.io/llaville/umlwriter:latest diagram:class /workdir/src
```

And same way if you want to generate an image (whatever format: svg, png, ...), and be able to retrieve it,
run following command :

```shell
docker run --rm -t -v "${PWD}":/workdir ghcr.io/llaville/umlwriter:latest diagram:class /workdir/src --output /workdir/diagram.svg
```
