Sf Dependency Injection Bridge
==============================

Zf2 module to use Symfony Dependency Injection
([symfony/dependency-injection](https://github.com/symfony/DependencyInjection)).

Requirements
------------

Please see the [composer.json](composer.json) file.

Installation
------------

You can install using:

```bash
curl -s https://getcomposer.org/installer | php
php composer.phar install
```

You can import the `sf-dependency-injection-bridge` module into an existing application
by adding `cdx/sf-dependency-injection-bridge` to
your `composer.json` "require" section. You should also add the module to your
application's configuration:

```php
'modules' => array (
    /* ... */
    'Cdx\SfDependencyInjectionBridge',
),
```

Configuration
-------------

This module load each module configuration files to search the `sf-dependency-injection-bridge` key.
To add an dependency you should set in the module configuration file:

```php
return array (
    'router' => /* ... */
    'service_manager' => /* ... */
    /* ... */
    'sf-dependency-injection-bridge' => [
        'config-files' => [
            __DIR__ . '/services.yml',
            /* ... */
        ],
        'service-locator' => [
            'Doctrine\\ORM\\EntityManager' => 'Doctrine\\ORM\\EntityManager',
            /* ... */
        ]
    ],
```
You can specify any service loaded in service locator to set them onto the ContainerBuilder of Symfony.
Moreover, you can load any file you want in Yaml format to load services onto it too.

See documentation of [Symfony Dependency Injection](http://symfony.com/fr/doc/current/components/dependency_injection/introduction.html).
