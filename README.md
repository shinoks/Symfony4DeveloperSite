# Symfony4 Developer Crowdfunding

Symfony4 site with:

- cms
- user account
- admin back (site/admin)
- public folder in public_html (for shared hosting)
- auto generating agreement (stored in 'var/data') from template on selected Recruitment User Status
- recaptcha on register and contact

# Admin

- Little cms:
    ``Menu, Category, Article, Module``
- Config site variable
- Contact form manage
- Social media
- Recruitment:
    ``Recruitment, Status, Recruitment User, Recruitment User Status``

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
$ set .env
$ set phpunit.xml.dist database connection for tests
$ siteaddress.com/admin user admin pass admin
```
# TODO
- Comment system
- Newsletter system
- Logger system
- Tests
