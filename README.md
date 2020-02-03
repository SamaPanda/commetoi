# Commetoi shop

Exercice Symfony


## Installation

 Sont requis:
  
```
  - apache + php 7.2+
  - postgresql
```

  Modifier le fichier .env pour renseigner les informations de connexions postgre

  ```
    DATABASE_URL=postgresql://postgres:postgres@cwpgsql:5432/commetoi
    DATABASE_URL=postgresql://[user]:[pwd]@[ip_postgre]:[port]/[nom_db]
  ```

    
 
 via docker :
 
 ```
 docker-compose up --build
```

via composer:

copier les sources sur le serveur.

Dans un terminal à la racine des sources, tapez:
 ```
 composer install
composer doctrine:migrations:migrate
composer doctrine:fixtures:load
```

## Admin

Url pour accéder à EasyAdmin : /admin 
username : admin / mot de passe : admin
