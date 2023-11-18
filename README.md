# skitricks

# env php 8.1
# env Symfony 5.5.8

# git clone https://github.com/PepinoFr/projet8-TodoList.git
# si pas composer
``` curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php```
``` php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer```
``` composer init```
# composer require symfony/http-foundation
# Il faut créer une base de données donc 
``` php bin/console doctrine:database:create```
## modifier la variable "DATABASE_URL" dans le fichier .env pour modifier "project9" par le nom donné

#Pour créer les tables
``` php bin/console make:migration```
``` php bin/console doctrine:migrations:migrate ```

#Pour ajouter le contenu 
``` php bin/console doctrine:fixtures:load --group=group1 ```
## Pour ajouter le user anonyme pour  les taches sans user 
```php bin/console doctrine:query:sql "UPDATE task SET user_id = 1 WHERE user_id is null"```

# Puis lancer le serveur
```symfony server:start  ```

# Pour les testes 
``  php bin/console d:d:d --force --if-exists --env=test ``
``` php bin/console d:d:c --env=test ```
``` php bin/console d:m:m --no-interaction --env=test ```
``` php bin/console doctrine:fixtures:load --group=group2 --env=test ```
``` symfony php bin/phpunit ```

 
