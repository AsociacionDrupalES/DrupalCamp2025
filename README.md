# DrupalCamp Spain 2025

## Initial setup

Get a copy of the database and files and put them in
```shell
ddev start
# Get dependencies:
ddev composer install

# Import a the base DB:
ddev import-db --file=database-file.sql.gz

# Run possible pending updates:
ddev drush updb -y

# Ensure you are up to date in terms of configration:
ddev drush cim -y

# Access to the site
ddev drush uli
```

From now on you'd be able to access to https://dcamp2025.ddev.site

## How to contribute

 - Git workflow information: https://docs.github.com/en/get-started/using-github/github-flow
 - Development branch: ```dev```
 - Production branch: ```main```
