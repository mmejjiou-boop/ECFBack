# Projet ECF Backend

Application Symfony 7.4 pour la gestion d'un système de prêt de matériel.

## Présentation

Ce projet est une application backend Symfony qui permet de gérer :

- les adhérents
- le matériel
- les prêts
- l'authentification et les droits d'accès

L'application utilise Doctrine ORM, Twig, les formulaires Symfony et un firewall sécurisé avec authentification par formulaire.

## Fonctionnalités

- CRUD pour `Adherent`, `Materiel` et `Pret`
- Authentification des utilisateurs via `App\Security\LoginFormAuthenticator`
- Rôles et autorisations :
  - `ROLE_GESTIONNAIRE` pour l'accès aux listes, création et modification
  - `ROLE_ADMIN` pour la suppression
- Interface Twig côté serveur
- Gestion des migrations de base de données

## Structure du projet

- `src/Controller/` : contrôleurs métier et sécurité
- `src/Entity/` : entités Doctrine
- `src/Form/` : formulaires Symfony
- `templates/` : templates Twig
- `config/` : configuration de l'application
- `migrations/` : migrations de base de données
- `public/` : point d'entrée web

## Installation

1. Installer les dépendances :
   ```bash
   composer install
   ```
2. Configurer la connexion à la base de données dans `.env` ou `.env.local` :
   ```bash
   DATABASE_URL="mysql://user:password@127.0.0.1:3306/ecfback"
   ```
3. Créer la base de données :
   ```bash
   php bin/console doctrine:database:create
   ```
4. Exécuter les migrations :
   ```bash
   php bin/console doctrine:migrations:migrate
   ```
5. Lancer le serveur :
   ```bash
   symfony server:start
   ```

## Commandes utiles

- `php bin/console doctrine:migrations:migrate`
- `php bin/console doctrine:schema:update --force`
- `php bin/console make:auth`
- `php bin/console make:crud`
- `php bin/console debug:router`
- `php bin/console debug:container`

## Routes principales

- `/login` : page de connexion
- `/logout` : déconnexion
- `/materiel` : gestion du matériel
- `/adherent` : gestion des adhérents
- `/pret` : gestion des prêts

## Notes

- La suppression est limitée aux utilisateurs avec `ROLE_ADMIN`.
- La consultation, création et modification sont réservées aux utilisateurs avec `ROLE_GESTIONNAIRE`.
- Le projet est basé sur Symfony 7.4 et PHP 8.2.

## Historique des commandes utilisées

1. `symfony new ECFBackend --webapp`
2. `git init`
3. `git remote add origin git@github.com:mmejjiou-boop/ECFBack.git`
4. `git branch -M main`
5. `git push -u origin main`
6. `php bin/console make:entity Materiel Pret Adherent`
7. `php bin/console make:migration`
8. `php bin/console doctrine:migrations:migrate`
9. `php bin/console make:crud Materiel Pret Adherent`
10. `php bin/console make:migration`
11. `php bin/console doctrine:migrations:migrate`
12. `symfony server:start`
13. `php bin/console make:auth`

