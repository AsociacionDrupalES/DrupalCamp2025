# Drupal Iberia 2025

## Initial setup

Get a copy of the database and files and put them in
```
ddev start
ddev composer install
ddev import-db --file=database-file.sql.gz
ddev drush uli
```

From now on you'd be able to access to https://drupaliberia.ddev.site

## How to contribute

 - Git workflow information: https://docs.github.com/en/get-started/using-github/github-flow
 - Development branch: ```dev```
 - Production branch: ```main```
