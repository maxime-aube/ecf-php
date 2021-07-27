# Installation du projet Skillhub

Le projet n'est pas prêt à être déployé en production.
Les instructions ci -dessous sont pour une démonstration dans un environnement de développement local.

## Démarrage

1) cloner le projet sur votre machine
2) définir un fichier de configuration .env.local avec au moins :
- MAILER_DSN=smtp://localhost
- DATABASE_URL="mysql://username:password@127.0.0.1:3306/dbname" -> remplacer username, password, dbname - et éventuellent 127.0.0.1:3306 - par vos informations respectives pour l'accès à votre SGBD

## Installation
    
    composer update && composer install //met à jour et installe les dépendances du projet
    symfony console doctrine:database:creat //création de la base de données
    symfony console doctrine:migrations:migrate //exécutions des migrations nécessaires pour charger le modèle de données
    symfony console doctrine:fixtures:load //charge les fixtures dans la db (jeu de données nécessaire pour tester le projet)
    symfony serve //lance le serveur local sur un port disponible (localhost:8000 par défaut)
  
## Pour purger la base de données et recharger les fixtures

    symfony console doctrine:database:drop --force
    symfony console doctrine:database:create
    symfony console doctrine:migrations:migrate
    symfony console doctrine:fixtures:load

## Test users

Charger les fixtures permet de tester le projet avec ces trois comptes

ID:pasword (role)

1) admin@skillhub.com:verySecure_1234 (admin)
2) micron.commercial@skillhub.com:laBaffe100% (commercial)
3) aube.collaborateur@skillhub.com:keepCalm&h8 (collaborateur)

## Projet

Toutes les pages sont accessibles seulement après login (sauf login page évidemment)
Le système d'inscription fonctionne (RegistrationController), mais l'envoi de mails n'est pas pris en charge

les entités User et Profile sont différentiées :
Rôles : ADMIN, COMMERCIAL, COLLABORATEUR -> peuvent avoir un compte utilisateur

les candidats ne sont pas des utilisateurs, mais un ADMIN ou un COMMERCIAL peuvent créer une fiche profil candidat.

Un profil candidat peut être transformé en collaborateur en créant un User avec ROLE_COLLABORATEUR,
et en lui attribuant le profil candidat (la catégorie du profil se retrouve aussi modifiée à collaborateur)

Les catégories (utilisateurs, compétences, etc... sont toutes regroupées dans la même entité Category)

Les profils sont administrés via un système de vues et de formulaires indépendant du easy admin, qui n'a été installé qu'à la fin pour un affichage Dashboard
Le système d'upload de documents fonctionne, mais il n'est pas encore possible de les supprimer (implémenter filesystem pour ça)de 
