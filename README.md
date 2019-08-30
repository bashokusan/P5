#OC_P5
## A blog with a back office

[![Maintainability](https://api.codeclimate.com/v1/badges/2659a3b6abfa54f66486/maintainability)](https://codeclimate.com/github/bashokusan/P5/maintainability)

[![SymfonyInsight](https://insight.symfony.com/projects/094ac1ed-0246-4a8a-8518-d80e8a7bcafa/small.svg)](https://insight.symfony.com/projects/094ac1ed-0246-4a8a-8518-d80e8a7bcafa)

### Features

* For visitor :
  * See list of posts
  * See post
  * See list of comments
  * Drop comment
  * Pagination
  * Send message to admin
  * Request for admin role

* For admin :
  * All the above
  * Write new post
  * Update post
  * Delete post
  * Check and flag comments
  * Update infos
  * Change password
  * Reset password

### Libraries

* symfony/var-dumper
* phpstan/phpstan
* friendsofphp/php-cs-fixer
* swiftmailer/swiftmailer

## Install

* You have to write your own database infos in App/DBFactory.
* SQL functions are made with mysql.
* You need to have composer and install swiftmailer library and change $transport object of the SendMail class in App/Controllers/.
