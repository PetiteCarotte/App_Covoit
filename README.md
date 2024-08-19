# CovoiturageApp

##

Ce projet a été proposé par la **Base Aérienne 705 de Tours**. L'objectif de ce projet est de développer une application de covoiturage pour les trajets base-domicile des employés de la base. Il s'agit de la deuxième version du projet.

Vous pourrez retrouver dans le dossier DocumentationCovoit les documents suivants :
 - Le rapport du projet de groupe (V1 de l'application)
 - Le diagramme d'activité schématisant le fonctionnement de l'application (à retrouver ici aussi : https://www.figma.com/board/IM74029EZR6aAp68YyzLj9/Blabladef?node-id=4-164&t=KIdhhZ8iBpyKDt3M-1)
 - Le diagramme de classes du la base de données
 - L'arborescence détaillée du projet
 - Les scripts permettant de remplir la base de données

Voici également le lien vers le git de la V1 de l'application : 
https://github.com/ArthurCrochemore/Application-Covoiturage

# Pré-requis
Pour pour pouvoir lancer l'application, vous devez configurer sur votre machine les outils suivants :
- Pour le backend, **Php** (8.2.16) et **Composer** (2.7.2) : https://www.youtube.com/watch?v=pS0U-PsXUlg
- Pour la base de données, **PostgreSQL** (16.2) : https://www.postgresql.org/download/
- Pour le frontend, **Node** (21.6.0) : https://www.youtube.com/watch?v=tsDGFUiNZog

Lors de la configuration de PostgreSQL, faites bien attention à définir votre username comme postgres et votre mot de passe comme password. Si vous n’avez pas cela, vous devrez modifier les champs DB_USERNAME et DB_PASSWORD de votre fichier .env.

Une fois fait, vous devez saisir les commandes suivantes depuis une console ouverte dans le dossier _CovoiturageApp_ :
- ```composer install```
- ```npm install```
- ```php artisan key:generate```

Vous devez ensuite créer une base de données _covoiturage_ (depuis **pgAdmin** par exemple), ainsi qu'un schéma dans cette base de données nommé _covoiturage_ également.

Vous pouvez ensuite automatiser la création des tables de cette base de donnée, ainsi que la génération de données fictives en saisissant cette commande depuis la console précédemment ouverte :
- ```php artisan migrate```

Vous pouvez remplir les tables communes et bases militaires avec les scripts fournis dans le dossier ScriptBDD : 
- communes.csv : Communes
- bases_militaires.sql : Bases militaires

# Lancement de l'application
A partir de 2 consoles ouvertes dans le dossier _Application_, vous pouvez lancer l'application en saisissant les 2 commandes suivantes dans chacunes des 2 consoles :
- ```php artisan serve```
- ```npm run dev```

Vous accéder alors à l'interface de connexion, et pouvez vous créer un compte et naviguer dans l'application.

##

Cheffe de Projet, Caroline Petit
