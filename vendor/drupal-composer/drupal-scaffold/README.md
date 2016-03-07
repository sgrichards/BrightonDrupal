# drupal-scaffold

Composer plugin for automatically downloading Drupal scaffold files (like
`index.php`, `update.php`, …) when using `drupal/core` via Composer.

It is recommended that the vendor directory be placed in its standard location
at the project root, outside of the Drupal root; however, the location of the
vendor directory and the name of the Drupal root may be placed in whatever
location suits the project.  Drupal-scaffold will generate the autoload.php 
file at the Drupal root to require the Composer-generated autoload file in the 
vendor directory.

## Usage

Run `composer require drupal-composer/drupal-scaffold:dev-master` in your composer
project before installing or updating `drupal/core`.

Once drupal-scaffold is required by your project, it will automatically update
your scaffold files whenever `composer update` changes the version of
`drupal/core` installed.

## Configuration

You can configure the plugin with providing some settings in the `extra` section
of your root `composer.json`.

```json
{
  "extra": {
    "drupal-scaffold": {
      "source": "https://ftp.drupal.org/files/projects/drupal-{version}.tar.gz",
      "excludes": [
        "google123.html",
        "robots.txt"
      ],
      "includes": [
        "sites/default/example.settings.my.php"
      ],
      "omit-defaults": false
    }
  }
}
```
The `source` option may be used to specify the URL to download the
scaffold files from; the default source is drupal.org. The literal string
`{version}` in the `source` option is replaced with the current version of
Drupal core being updated prior to download.

With the `drupal-scaffold` option `excludes`, you can provide additional paths
that should not be copied or overwritten. Default excludes are provided by the
plugin:
```
.gitkeep
autoload.php
composer.json
composer.lock
core
drush
example.gitignore
LICENSE.txt
README.txt
vendor
themes
profiles
modules
sites/*
sites/default/*
```

If there are some files inside of an excluded location that should be
copied over, they can be individually selected for inclusion via the
`includes` option. Default includes are provided by the plugin:
```
sites
sites/default
sites/default/default.settings.php
sites/default/default.services.yml
sites/development.services.yml
sites/example.settings.local.php
sites/example.sites.php
```

When setting `omit-defaults` to `true`, neither the default excludes nor the
default includes will be provided; in this instance, only those files explicitly
listed in the `excludes` and `includes` options will be considered. If
`omit-defaults` is `false` (the default), then any items listed in `excludes`
or `includes` will be in addition to the usual defaults.

## Limitation

When using Composer to install or update the Drupal development branch, the
scaffold files are always taken from the HEAD of the branch (or, more
specifically, from the most recent development .tar.gz archive). This might
not be what you want when using an old development version (e.g. when the
version is fixed via composer.lock). To avoid problems, always commit your
scaffold files to the repository any time that composer.lock is committed.
Note that the correct scaffold files are retrieved when using a tagged release
of `drupal/core` (recommended).

## Custom command

The plugin by default is only downloading the scaffold files when installing or
updating `drupal/core`. If you want to call it manually, you have to add the
command callback to the `scripts`-section of your root `composer.json`, like this:

```json
{
  "scripts": {
    "drupal-scaffold": "DrupalComposer\\DrupalScaffold\\Plugin::scaffold"
  }
}
```

After that you can manually download the scaffold files according to your
configuration by using `composer drupal-scaffold`.

Note that drupal-scaffold does not automatically run after `composer install`.
It is assumed that the scaffold files will be committed to the repository, to
ensure that the correct files are used on the CI server (see **Limitation**,
above).  After running `composer install` for the first time, also run
`composer drupal-scaffold`, and commit the scaffold files to your repository.
