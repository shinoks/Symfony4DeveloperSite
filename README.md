# EliteInvestments

Mainly project for education in SF4.

Symfony4 site with:

- user account
- admin back (site/admin)
- public folder in public_html (for shared hosting)

# Admin

- Little cms:
    ``Menu, Category, Article, Module``
- Config site variable
- Contact form manage
- Social media

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
$ bin/console doctrine:fixtures:load
```
# TODO
- Info count module
- Comment system
