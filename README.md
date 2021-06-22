# ecf-php

Installation du projet :

Le projet n'est pas prêt à être déployé en production.
Les instructions ci -dessous sont pour une démonstration dans un environnement de développement local.

1) cloner le projet sur votre machine
2) composer update && composer install -> met à jour et installe les dépendances du projet
3) définir un fichier de configuration .env.local avec au moins :
- MAILER_DSN=smtp://localhost
- DATABASE_URL="mysql://username:password@127.0.0.1:3306/dbname" -> remplacer username, password, dbname - et éventuellent 127.0.0.1:3306 - par vos informations respectives pour l'accès à votre SGBD
4) php bin/console doctrine:database:create -> création de la base de données
5) php bin/console doctrine:migrations:migrate -> exécutions des migrations nécessaires pour charger le modèle de données
6) php bin/console doctrine:fixtures:load -> charge les fixtures dans la db (jeu de données nécessaire pour tester le projet)

