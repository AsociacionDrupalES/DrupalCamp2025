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
  - Any new branch is created from `main`
- `dev` is a development branch, and it can be thrown away at any moment.
  - `dev` is never merged to `main`
- For new branches, create it from `main` and then:
  - Create PRs against `dev` when you want to demo the changes, and you can make as many PRs as needed until the changes are fully tested and approved.
  - When everything is approved, create a new PR from your branch to `main`.
