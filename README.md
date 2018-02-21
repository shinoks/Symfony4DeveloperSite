# EliteInvestments

Mainly project for education in SF4.

Symfony4 site with:

- user account
- admin back (site/admin)
- public folder in public_html (for shared hosting)

# Admin

- Little cms
- Config site variable
- Contact form manage

# Tech

- php
- js
- bootstrap 3
- many charts generator for admin site

# Start

```sh
$ git clone https://github.com/shinoks/eliteInvestments.git
$ bin/console doctrine:schema:update --force
$ bin/console cache:clear
$ bin/console cache:warmup
```
# TODO
Fixtures for admin account
Fixtures for config
