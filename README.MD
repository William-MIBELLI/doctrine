# Template PHP & Docker

Un modèle de démarrage (template) minimaliste pour créer rapidement des applications PHP avec un environnement de développement local dockerisé (Nginx, PHP-FPM et PostgreSQL).

## 🚀 Comment utiliser ce template ?

Ce dépôt est configuré comme un Template GitHub. Pour démarrer un nouveau projet à partir d'ici :

1. Cliquez sur le bouton vert **"Use this template"** (Utiliser ce modèle) en haut à droite sur GitHub.
2. Choisissez **"Create a new repository"**, donnez un nom à votre projet et créez-le.
3. Clonez votre nouveau dépôt sur votre machine locale.
4. Mettez à jour le fichier `README.md` (celui-ci) pour décrire votre propre projet à la place !

---

## 📦 Stack Technique & Versions

- **PHP** : `8.5.5RC1-fpm` (Extensions pré-installées : `pdo`, `pdo_pgsql`)
- **PostgreSQL** : `16`
- **Serveur Web** : Nginx (`alpine`)
- **Outils** : Composer (`latest`)

## 🛠 Démarrer l'environnement local

Une fois votre projet cloné sur votre machine :

1. Assurez-vous d'avoir [Docker](https://www.docker.com/) et Docker Compose installés.
2. Positionnez-vous à la racine du projet et lancez la stack :

    ```bash
    docker compose up -d
    ```

3. Placez votre code source dans le dossier `src/`. Il est monté en tant que volume et directement synchronisé avec le conteneur, les changements sont en temps réel.

## 🌐 Mots de passe et accès par défaut

- **Application Web** : [http://localhost:8080](http://localhost:8080)
- **Base de données PostgreSQL** : `localhost:5432`
  - Base de données : `ma_base`
  - Utilisateur : `user`
  - Mot de passe : `password`

