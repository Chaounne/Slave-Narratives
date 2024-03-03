# SAÉ-S5-Slave-Narratives

## Introduction

Ce projet est un projet scolaire réalisé dans le cadre d'une SAÉ (Situation d'Apprentissage et d'Évaluation). Il a pour but d'améliorer un site web déjà existant, qui recense de manière exhaustive de nombreux récits d'esclaves.

Il est actuellement possible de consulter les différents récits de plusieurs manières différentes:

- Localiser sur une carte interactive du monde
- Les découvrir tout au long d'une liste
- Les cibler à l'aide de filtres

L'amélioration désirée consiste à l'installation d'un [back-office](https://infonet.fr/lexique/definitions/back-office/), plus de précisions dans la partie [Objectifs](#objectifs).

> Retrouvez le site existant ci-dessous

[LinkOriginalSite]: https://slave-narratives.univ-tlse2.fr/ 'Existant'
[<kbd> <br> Lien vers l'existant <br> </kbd>][LinkOriginalSite]

[LinkRelease]: https://github.com/EstebanBiret/SAE-S5-Slave-Narratives/releases/tag/sprint-3 'Release'
> Retrouvez la dernière release du projet ci-dessous

[<kbd> <br> Lien vers la dernière Release  <br> </kbd>][LinkRelease]

[LinkDev]: http://saes5.chaounne.xyz/ 'Dev'
> Retrouvez le site en cours de développement ci-dessous

[<kbd> <br> Lien vers le site en cours de développement <br> </kbd>][LinkDev]

<div>
    <button href="https://slave-narratives.univ-tlse2.fr/" style="border-radius: 9px; width:70%">
        <img src="./readme_assets/screenshot.png">
    </button>
</div>

## Sommaire

- [SAÉ-S5-Slave-Narratives](#saé-s5-slave-narratives)
  - [Introduction](#introduction)
  - [Sommaire](#sommaire)
  - [Personnes impliquées](#personnes-impliquées)
    - [Équipe de développement](#équipe-de-développement)
    - [Coachs de la SAÉ](#coachs-de-la-saé)
    - [Cliente](#cliente)
  - [Méthodes](#méthodes)
    - [Méthode Agile](#méthode-agile)
    - [Répartition des Sprints](#répartition-des-sprints)
    - [Issues](#issues)
    - [Backlog](#backlog)
  - [Objectifs](#objectifs)
  - [Documentation](#documentation)
  - [Technologies utilisées](#technologies-utilisées)
  - [Guide d'installation](#guide-dinstallation)
    - [Windows >= 10](#windows--10)

## Personnes impliquées

### Équipe de développement

*Chaque personne est associée à son compte GitHub*

#### Initiaux

- [Esteban BIRET-TOSCANO](https://github.com/EstebanBiret)
- [Mickaël FERNANDEZ](https://github.com/Mazlai)
- [Rémy GUIBERT](https://github.com/PattateDouce)
- [Cédric-Alexandre PASCAL](https://github.com/Chaounne)

#### Alternants

- [Éric PHILIPPE](https://github.com/Eric-Philippe)
- [Nolan JACQUEMONT](https://github.com/nolanjacquemont)
- [Mathis MERCKEL](https://github.com/Cashmts)
- [Léonidas KOSMIDIS](https://github.com/Leo0K)

### Coachs de la SAÉ

- [Pascal SOTIN](https://)
- [Jean-Michel BRUEL](https://github.com/jmbruel)
- [Pablo SEBAN](https://framagit.org/PSE)
- [Esther PENDARIES](https://)

### Cliente

Marie-Pierre BADUEL (Université Toulouse Jean Jaurès)

## Méthodes

### Méthode Agile

Dans le cadre de ce projet, nous avons utilisé la méthode agile, qui consiste à découper le projet en plusieurs itérations, appelées sprints. Chaque sprint a une durée définie, et à la fin de chaque sprint, une démonstration est effectuée, afin de montrer l'avancement du projet.
Ces méthodes sont orchestrées par un Scrum Master ici représenté par [Mickaël FERNANDEZ](https://github.com/Mazlai).

[Documentation de la méthode Agile](https://www.agilealliance.org/agile101/) (en anglais)

### Répartition des Sprints

Chaque sprint a une durée d'une semaine.

<h3 style="color:orange">Sprint Actuel : dernier sprint</h3>

### Issues

Les issues sont des tâches à effectuer, elles sont créées par les membres de l'équipe de développement, et sont assignées à un ou plusieurs membre.s de l'équipe. Elles sont ensuite déplacées dans les colonnes correspondant à leur état d'avancement.
On retrouve une template type dans le dossier ``.github/ISSUE_TEMPLATE/us.yml``

### Backlog

Le backlog est une liste de toutes les issues, triées par ordre de priorité. Il est utilisé pour définir les issues à effectuer pour le prochain sprint. Il détermine également si des issues doivent être portées d'un sprint à un autre.

Pour connaître en détails le Backlog, merci de vous rendre [ici](https://github.com/users/EstebanBiret/projects/2/views/4).

## Objectifs

### Objectif principal

L'objectif principal de ce projet est l'installation d'un Back Office, qui permettra à l'administrateur du site de modifier les données du site, sans avoir à modifier le code source.

### Objectifs secondaires

D'autres objectifs mineurs ont été définis, afin de rendre le site plus agréable à utiliser. Voici une liste non exhaustive de ces objectifs :

| Objectif | Description |
| --- | --- |
| **Langue** | Pouvoir basculer entre les langues Français et Anglais |
| **Contact** | Pouvoir contacter l'administrateur par mail directement depuis le site |
| **Session** | Pouvoir se connecter, et se souvenir de la session |
| **Export** | Pouvoir exporter des récits en PDF |

## Documentation

### Documents de conception fournis par la cliente

- [Cahier des charges](./docs/Cahier_des_charges.pdf)
- [Excel Auteurs](./docs/tableau_auteurs.xlsx)
- [Excel Récits](./docs/tableau_recits.xlsx)
- [Guide de développement](./docs/Guide_de_developpement.pdf)
- [Guide d'utilisation](./docs/Guide_utilisation.pdf)
- [Rapport de projet](./docs/Rapport_de_projet%20-%20Florent%20LAIDIN.pdf)

### Documentation ajoutée par l'équipe de développement

- [Documentation utilisateur](./docs/Documentation_utilisateur.md)
- [Documentation technique](./docs/Documentation_technique.md)
- [Analyse de la base de données initiale, et changements appliqués](./docs/analyse_ancienne_bd.md)
- [Dictionnaire des données de la base de données mise à jour](./docs/dictionnaire_donnees_bd.md)

## Technologies utilisées

| Nom                                     | Version |
|-----------------------------------------|---------|
| [PHP](https://www.php.net/)             | 8.1.2   |
| [MariaDB](https://mariadb.org/)         | 10.6.12 |
| [CodeIgniter](https://codeigniter.com/) | 4.3.1   |

## Guide d'installation

> Toutes les actions ci-dessous ont été testées, il existe d'autres façons de procéder, mais elles ne sont pas garanties de fonctionner.

## Windows >= 10

### Prérequis

- Avoir [XAMPP](https://www.apachefriends.org/fr/index.html) installé
  - L'installation doit comprendre [Apache](https://www.apachefriends.org/fr/index.html), [PHP](https://www.php.net/) et [MySQL](https://www.mysql.com/fr/)

### Installation

#### **1.** Téléchargement du projet

```bash
# Cloner l'entièreté du projet
git clone https://github.com/EstebanBiret/SAE-S5-Slave-Narratives.git

> Dossier SAE-S5-Slave-Narratives créé avec succès !
```

#### **2.** Configuration de XAMPP

##### 2.1. Copier le dossier de ``SAE-S5-Slave-Narratives/slaves_narratives`` et le placer dans le dossier ``htdocs`` de XAMPP (Trouvable généralement sous ``C:/XAMPP/htdocs/``)

> Laisser le reste du contenu du dossier ne posera aucun problème

##### 2.2. Lancer XAMPP

##### 2.3. Se rendre dans php.ini (Généralement trouvable en cliquant dans ``Config`` sur la ligne - *Apache*)

```ini
; Décommenter la ligne suivante

; extension=intl
; vers
extension=intl
```

##### 2.4 Se rendre dans le dossier ``SAE-S5-Slave-Narratives/slaves_narratives/`` et valoriser le fichier .env en se basant sur le fichier .env.example

```env
ENV = development

<...>

MAIL_HOST="Your mail host"
```

##### 2.5. Lancer **Apache** et **MySQL** depuis le menu principal de XAMPP

#### **3.** Configuration de la base de données

##### 3.1. Se rendre sur [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/) (Également trouvable sur le bouton ``Admin`` de la ligne - *MySQL*)

##### 3.2. Importer la base de données depuis le bouton importer en haut de la page et séléctionner le fichier se trouvant sous ``SAE-S5-Slave-Narratives/sql/dump_mysql.sql``

##### 3.3. Mettre en place un accès utilisateur à la base de données en séléctionnant depuis la page d'accueil de phpMyAdmin dans le menu ``Comptes et utilisateurs`` puis ``Ajouter un compte utilisateur``

##### 3.4. Créer un utilisateur avec le nom d'utilisateur et mot de passe écrit dans le fihcier `.env` et remplacer le nom d'hôte de % vers localhost
