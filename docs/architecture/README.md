# Architecture

This guide is dedicated to all PHP developers that want to learn more about each UMLWriter components.

## Command Line Runner

`UmlWriter` is a basic Symfony Console Application.

![Command Line Runner UML](../assets/images/archi-console.graphviz.svg)

## Configuration

`UmlWriter` assume a zero configuration by default, that you can change to whatever you want.

![Configuration UML](../assets/images/archi-config.graphviz.svg)

## Generator

`UmlWriter` provides a factory that is able to build `graphviz` and `plantuml` graph format.

![Generator UML](../assets/images/archi-generator.graphviz.svg)

## Service

`UmlWriter` provides a basic and light container service for dependency injection.

![Service UML](../assets/images/archi-service.graphviz.svg)
