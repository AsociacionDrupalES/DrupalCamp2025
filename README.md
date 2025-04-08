# DrupalCamp Spain 2025

## Initial setup

Get a copy of the database and files for a closer set up to production, but it's not needed.

```shell
# Get started.
ddev start
ddev composer install

# Import the DB:
ddev import-db --file=database-file.sql.gz

# No database, no problem:
ddev drush -y site:install --existing-config -v

# Run possible pending updates and import the configuration from code.
ddev drush deploy

# Access to the site
ddev drush uli

# Bring images from the production site.
ddev drush -y en stage_file_proxy
```

From now on you'd be able to access to https://dcamp2025.ddev.site

## Translations

If the folder `web/sites/default/files/translations` is not created,
then run the command:
```
mkdir web/sites/default/files/translations
```

## How to contribute

 - Git workflow information: https://docs.github.com/en/get-started/using-github/github-flow
 - Development branch: ```dev```
 - Production branch: ```main```

### Branches

- `main` is the source of truth, the branch with the production code, always.
- `dev` is the development branch, any new functionality goes there.
- `dev` is then merged to `main` via PR when the changes are accepted.
