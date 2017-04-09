QA Test
=====

# 0. Provision system locally
- Clone this project
- [Install php 7.1](http://php.net/manual/en/install.php). Make sure php related packages exists in your system (php7.1-bcmath, php7.1-cli, php7.1-common, php7.1-json, php7.1-mbstring, php7.1-opcache, php7.1-readline, php7.1-sqlite3, php7.1-xml)
- [Install composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx), Install pgroject dependencies (`composer install` insede project root)
- [Execute database migrations](http://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html)
- [Run php build in web server](http://symfony.com/doc/current/setup/built_in_web_server.html)
- Visit [http://localhost:8000/app_dev.php/api/v1/doc](http://localhost:8000/app_dev.php/api/v1/doc). You should see online api documentation with sandobx option. Figure out what going on there, read [documentation](https://github.com/nelmio/NelmioApiDocBundle) if required

# 1. Provide api tests for the system
- There are 2 types of users in the system (regular one and administrator). Authentication based on API token. Use `YECRSbpLDCXrJXCrVKOU` for authentication as regular user and `tR6TI49mh4fbKAuSjm9L` for administration access. See right upper corner in api doc page.
- There are few endpoints groups in the system: **Currency** (currency management in [REST](https://en.wikipedia.org/wiki/Representational_state_transfer) style), **Exchange** (with only one endpoint: __POST__[/api/v1/exchange/]())
- Only user with administration access should have access to __POST__[/api/v1/currencies/]() and __DELETE__[/api/v1/currencies/{id}]()
- The calculation in __POST__[/api/v1/exchange/]() uses formula: request.amount * currencyFrom.value / currencyTo.value
 
