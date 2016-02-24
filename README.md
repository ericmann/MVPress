MVPress
===========

MVC-style template loader for WordPress

## Installation

This module can be easily installed by adding `ericmann/mvpress` to your `composer.json` file. Then, either autoload your Composer dependencies or manually `include()` the `mvpress.php` bootstrap file.

## Usage

The namespaced `\MVPress\get_template_part()` function is a fully backwards-compatible replacement for WordPress' default `get_template_part()`. At a minimum, you can use the new version as a 1:1 alternative.

However, once using the new version, you can:

- Pass an optional 3rd parameter to define a model object in the scope of the template.
- Pass an optional 4th parameter to define an array of dynamic user data in the scope of the template.
- Reference `$this->model` in the template directly (no globals!).
- Reference `$this->context->query` in the template to access the global `WP_Query` object in-scope.
- Reference `$this->context->request` in the template to access the global `$_REQUEST` object in-scope.
- Reference `$this->context->userData` in the template to access the passed-in dynamic array in-scope.

## Changelog

02-23-16 - 1.0.0 - Refactored as Composer module
12-13-13 - 0.1.0 - First release