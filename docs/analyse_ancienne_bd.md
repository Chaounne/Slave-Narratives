# Analyse base de données pour refactoring

## Contexte

La base de données actuelle comporte de nombreuses incohérences, comme des attributs et tables non-utilisés, ou encore des noms de tables et d'attributs non-explicites et incohérents. Nous devons également déplorer un manque de documentation, et notamment l'absence de dictionnaire des données.

## Objectifs

Ce document a pour but de décrire les tables et attributs de la base de données actuelle, et de proposer une nouvelle structure plus cohérente.

## Sommaire

- [Remarques générales](#remarques-générales)
- [Table ADMIN](#table-admin)
  - [Description](#description-)
  - [Actuellement](#actuellement-)
  - [Proposition](#proposition-)
- [Table AUTOCH2](#table-autoch2)
  - [Description](#description--1)
  - [Actuellement](#actuellement--1)
  - [Proposition](#proposition--1)
- [Table FULLPT_1](#table-fullpt1)
  - [Description](#description--2)
  - [Actuellement](#actuellement--2)
  - [Proposition](#proposition--2)
- [Table MAP3](#table-map3)
  - [Description](#description--3)
  - [Actuellement](#actuellement--3)
  - [Proposition](#proposition--3)
- [Table POINTS](#table-points)
  - [Description](#description--4)
  - [Actuellement](#actuellement--4)
  - [Proposition](#proposition--4)
- [Table POLY](#table-poly)
  - [Description](#description--5)
  - [Actuellement](#actuellement--5)
  - [Proposition](#proposition--5)
- [Table PTS_PUBLICATION](#table-ptspublication)
  - [Description](#description--6)
  - [Actuellement](#actuellement--6)
  - [Proposition](#proposition--6)
- [Table ROY_AFR](#table-royafr)
  - [Description](#description--7)
  - [Actuellement](#actuellement--7)
  - [Proposition](#proposition--7)
- [Table TAB_narrateurS](#table-tabnarrateurs)
  - [Description](#description--8)
  - [Actuellement](#actuellement--8)
  - [Proposition](#proposition--8)
- [Table TAB_RECITS_V3](#table-tabrecitsv3)
  - [Description](#description--9)
  - [Actuellement](#actuellement--9)
  - [Proposition](#proposition--9)
- [Table TOKEN](#table-token)
  - [Description](#description--10)
  - [Actuellement](#actuellement--10)
  - [Proposition](#proposition--10)
- [Table VISITEURS](#table-visiteurs)
  - [Description](#description--11)
  - [Actuellement](#actuellement--11)
  - [Proposition](#proposition--11)

## Remarques générales

L'attribut wkt n'est jamais utilisé, car remplacé par geoj.

## Table ADMIN

### Description :
Table contenant les informations de connexion des administrateurs.

### Actuellement :

| Nom           | Type         | Description                           |
|---------------|--------------|---------------------------------------|
| ID            | int(11)      | Identifiant de l'administrateur       |
| MDP           | varchar(128) | Mot de passe de l'administrateur      |
| MAIL          | varchar(128) | Adresse mail de l'administrateur      |
| TOKENRECUPMDP | varchar(128) | Token de récupération de mot de passe |

### Proposition :

| Nom                     | Type         | Description                           |
|-------------------------|--------------|---------------------------------------|
| id                      | int(11)      | Identifiant de l'administrateur       |
| password                | varchar(128) | Mot de passe de l'administrateur      |
| email                   | varchar(128) | Adresse mail de l'administrateur      |
| password_recovery_token | varchar(128) | Token de récupération de mot de passe |

## Table AUTOCH2

### Description :
Table contenant les informations des aires autochtones.

### Actuellement :

| Nom      | Type          | Description                        |
|----------|---------------|------------------------------------|
| WKT      | varchar(2622) | Polygone de la zone                |
| id       | int(11)       | Identifiant de la zone autochtone  |
| id_style | int(11)       | Identifiant de style               |
| geoj     | text          | Polygone de la zone                |

### Proposition :

Revoir le nom de la table → INDIGENOUS_AREA

| Nom       | Type         | Description            |
|-----------|--------------|------------------------|
| id        | int(11)      | Identifiant de la zone |
| id_style  | int(11)      | Identifiant de style   |
| geoj      | text         | Polygone de la zone    |

## Table FULLPT_1

### Description :
?

### Actuellement :

| Nom      | Type          | Description                           |
|----------|---------------|---------------------------------------|
| WKT      | varchar(43)   | Coordonnées du Point                  |
| ville    | varchar(22)   | Nom de la ville                       |
| layer    | varchar(27)   | ?                                     |
| id       | int(11)       | Identifiant du Point                  |
| id_recit | int(11)       | Identifiant de récit                  |
| type     | varchar(100)  | Type de point (naissance, décès, ...) |
| geoj     | text          | Coordonnées du Point                  |

### Proposition :

Supprimer la table (inutilisée)

## Table MAP3

### Description :
Frontières états-uniennes.

### Actuellement :

| Nom      | Type          | Description                 |
|----------|---------------|-----------------------------|
| id       | int(11)       | Identifiant de la frontière |
| label    | varchar(62)   | Nom de la frontière         |
| category | varchar(32)   | Catégorie de la frontière   |
| state    | varchar(5)    | État de la frontière        |
| layer    | varchar(10)   | ?                           |
| id_recit | int(11)       | Identifiant de récit        |
| id_1     | int(11)       | ?                           |
| geoj     | varchar(9886) | Coordonnées de la frontière |
| country  | varchar(20)   | Pays de la frontière        |

### Proposition :

Revoir le nom de la table → US_BORDER

| Nom           | Type             | Description                 |
|---------------|------------------|-----------------------------|
| id            | int(11)          | Identifiant de la frontière |
| label         | varchar(62)      | Nom de la frontière         |
| category      | varchar(14)      | Catégorie de la frontière   |
| state         | varchar(5)       | État de la frontière        |
| ~~layer~~     | ~~varchar(10)~~  | ~~?~~                       |
| id_narrative  | int(11)          | Identifiant de récit        |
| ~~id_1~~      | ~~int(11)~~      | ~~?~~                       |
| geoj          | text             | Coordonnées de la frontière |

## Table POINTS

### Description :
Points de récits.

### Actuellement :

| Nom      | Type          | Description                           |
|----------|---------------|---------------------------------------|
| WKT      | varchar(43)   | Coordonnées du Point                  |
| ville    | varchar(22)   | Nom de la ville                       |
| layer    | varchar(27)   | ?                                     |
| id       | int(11)       | Identifiant du Point                  |
| id_recit | int(11)       | Identifiant de récit                  |
| type     | varchar(100)  | Type de point (naissance, décès, ...) |
| geoj     | text          | Aussi les coordonnées du Point        |

### Proposition :

Revoir le nom de la table → POINT

| Nom           | Type            | Description                           |
|---------------|-----------------|---------------------------------------|
| city          | varchar(32)     | Nom de la ville                       |
| ~~layer~~     | ~~varchar(27)~~ | ?                                     |
| id            | int(11)         | Identifiant du Point                  |
| id_narrative  | int(11)         | Identifiant de récit                  |
| type          | varchar(100)    | Type de point (naissance, décès, ...) |
| geoj          | text            | Coordonnées du Point                  |

## Table POLY

### Description :
Indication lieu par récit

### Actuellement :

| Nom      | Type          | Description          |
|----------|---------------|----------------------|
| name_1   | varchar(70)   | ?                    |
| id_recit | int(11)       | Identifiant de récit |
| type     | varchar(100)  | Type du lieu         |
| name     | varchar(110)  | Nom du lieu          |
| label    | varchar(80)   | Deuxième nom du lieu |
| category | varchar(100)  | Catégorie du lieu    |
| state    | varchar(50)   | État du lieu         |
| geoj     | mediumtext    | Coordonnées du lieu  |
| id       | int(11)       | Identifiant du lieu  |

### Proposition :

Revoir le nom de la table → CUSTOM_LOCATION

| Nom          | Type          | Description           |
|--------------|---------------|-----------------------|
| id           | int(11)       | Identifiant du lieu   |
| id_narrative | int(11)       | Identifiant de récit  |
| type         | varchar(100)  | Type du lieu          |
| name         | varchar(110)  | Nom du lieu           |
| label        | varchar(80)   | Deuxième nom du lieu  |
| category     | varchar(100)  | Catégorie du lieu     |
| state        | varchar(50)   | État du lieu          |
| geoj         | text          | Coordonnées du lieu   |

## Table PTS_PUBLICATION

### Description :
?

### Actuellement :

| Nom      | Type          | Description           |
|----------|---------------|-----------------------|
| WKT      | varchar(42)   | Coordonnées du Point  |
| id       | int(11)       | Identifiant du Point  |
| ville    | varchar(18)   | Nom de la ville       |
| layer    | varchar(52)   | ?                     |
| id_recit | int(11)       | Identifiant de récit  |
| geoj     | text          | Coordonnées du Point  |
| fid      | int(11)       | ?                     |

### Proposition :

Supprimer la table (inutilisée)


## Table ROY_AFR

### Description :
Royaumes africains.

### Actuellement :

| Nom      | Type          | Description                     |
|----------|---------------|---------------------------------|
| wkt      | text          | Polygone du royaume africain    |
| id       | int(11)       | Identifiant de royaume africain |
| noms     | varchar(100)  | Nom du royaume africain         |
| geoj     | text          | Polygone du royaume africain    |

### Proposition :

Revoir le nom de la table → AFRICAN_KINGDOM

| Nom   | Type         | Description                      |
|-------|--------------|----------------------------------|
| id    | int(11)      | Identifiant du royaume africain  |
| name  | varchar(100) | Nom du royaume africain          |
| geoj  | text         | Polygone du royaume africain     |

## Table TAB_narrateurS

### Description :

Table contenant les informations sur les narrateurs.

### Actuellement :

| Nom                     | Type         | Description                       |
|-------------------------|--------------|-----------------------------------|
| nom                     | varchar(58)  | Nom narrateur                     |
| naissance               | varchar(27)  | Année de naissance                |
| lieu_naissance          | varchar(38)  | Lieu naissance                    |
| deces                   | varchar(10)  | Année de mort                     |
| lieu_deces              | varchar(29)  | Lieu de mort                      |
| lieu_esclavage          | varchar(53)  | Lieu d'esclavage                  |
| moyen_lib               | varchar(117) | Moyen de libération               |
| lieuvie_ap_lib          | varchar(72)  | Lieu de vie après libération      |
| origine_parents         | varchar(164) | Origines des parents de l'esclave |
| militant_abolitionniste | varchar(37)  | Est un abolitioniste              |
| particularites          | varchar(113) | Particularités                    |
| plrs_recits             | varchar(3)   | Si il a écrit plusieurs récits    |
| id_narrateur            | varchar(3)   | ID narrateur                      |
| op_source               | varchar(164) | ?                                 |

### Proposition :

Revoir le nom de la table → NARRATOR

| Nom                          | Type             | Description                       |
|------------------------------|------------------|-----------------------------------|
| id_narrator                  | int(11)          | ID narrateur                      |
| name                         | varchar(58)      | Nom narrateur                     |
| birth                        | varchar(27)      | Année naissance esclave           |
| birth_place                  | varchar(38)      | Lieu de naissance esclave         |
| death                        | varchar(10)      | Année de mort esclave             |
| death_place                  | varchar(29)      | Lieu de mort esclave              |
| enslavement_place            | varchar(53)      | Lieu d'esclavage                  |
| freeing_ways                 | varchar(117)     | Moyen de libération               |
| living_place_after_freeing   | varchar(72)      | Lieu de vie après libération      |
| parents_origin               | varchar(164)     | Origines des parents de l'esclave |
| abolitionist                 | varchar(37)      | Est un abolitioniste              |
| particularities              | varchar(113)     | Particularités                    |
| has_wrote_several_narratives | varchar(3)       | Si il a écrit plusieurs récits    |
| ~~op_source~~                | ~~varchar(164)~~ | ?                                 |


## Table TAB_RECITS_V3

### Description :

Table contenant les informations des récits.

### Actuellement :

| Nom             | Type         | Description             |
|-----------------|--------------|-------------------------|
| nom_esc         | varchar(47)  | Nom esclave             |
| titre           | varchar(431) | Titre du récit          |
| date_publi      | int(4)       | Année de publication    |
| lieu_publi      | varchar(25)  | Lieu de publication     |
| mode_publi      | varchar(75)  | Mode de publication     |
| type_recit      | varchar(5)   | Type de récit           |
| historiographie | varchar(833) | Historiographie         |
| preface_blanc   | varchar(4)   | Préface blanche         |
| details_preface | varchar(76)  | Détails de la préface   |
| id_narrateur    | varchar(3)   | ID narrateur            |
| id_recit        | int(11)      | ID récit                |
| scribe_editeur  | varchar(125) | Scribe éditeur          |
| lien_recit      | varchar(224) | Lien du récit           |
| debut_titre     | varchar(431) | Début du titre du récit |

### Proposition :

Revoir le nom de la table → NARRATIVE

| Nom                 | Type              | Description               |
|---------------------|-------------------|---------------------------|
| id_narrative        | int(11)           | ID récit                  |
| slave_name          | varchar(47)       | Nom esclave               |
| title               | varchar(431)      | Titre du récit            |
| publication_date    | int(4)            | Année de publication      |
| publication_place   | varchar(25)       | Lieu de publication       |
| publication_mode    | varchar(75)       | Mode de publication       |
| narrative_type      | varchar(5)        | Type de récit             |
| historiography      | varchar(833)      | Historiographie           |
| ~~preface_blanc~~   | ~~varchar(4)~~    | ~~Préface blanche~~       |
| ~~details_preface~~ | ~~varchar(76)~~   | ~~Détails de la préface~~ |
| id_narrator         | varchar(3)        | ID narrateur              |
| scribe_editor       | varchar(125)      | Scribe éditeur            |
| narrative_link      | varchar(224)      | Lien du récit             |
| title_beginning     | varchar(431)      | Début du titre du récit   |


## Table TOKEN

### Description :

Table contenant les tokens de connexion des utilisateurs.

### Actuellement :

| Nom           | Type         | Description                           |
|---------------|--------------|---------------------------------------|
| token         | varchar(128) | Token de connexion                    |
| id_admin      | int(11)      | Identifiant de l'administrateur       |
| validuntil    | datetime     | Date d'expiration du token de session |

### Proposition :

| Nom         | Type         | Description                           |
|-------------|--------------|---------------------------------------|
| token       | varchar(128) | Token de connexion                    |
| id_admin    | int(11)      | Identifiant de l'administrateur       |
| valid_until | datetime     | Date d'expiration du token de session |

## Table VISITEURS

### Description :

Table comptant le nombre de visiteurs par page chaque jour.

### Actuellement :

| Nom            | Type         | Description       |
|----------------|--------------|-------------------|
| route          | varchar(128) | Page visitée      |
| nombre_visites | int(11)      | Nombre de visites |
| date           | datetime     | Date de la visite |

### Proposition :

Revoir le nom de la table → VISITOR

| Nom         | Type         | Description       |
|-------------|--------------|-------------------|
| route       | varchar(128) | Page visitée      |
| visit_count | int(11)      | Nombre de visites |
| date        | datetime     | Date de la visite |