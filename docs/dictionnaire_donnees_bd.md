# Dictionnaire des données de la base `slave_narratives`

## Sommaire

- [Table admin](#table-admin)
  - [Description](#description)
  - [Structure](#structure)
- [Table african_kingdom](#table-african_kingdom)
  - [Description](#description-1)
  - [Structure](#structure-1)
- [Table narrator](#table-narrator)
  - [Description](#description-2)
  - [Structure](#structure-2)
- [Table country](#table-country)
  - [Description](#description-3)
  - [Structure](#structure-3)
- [Table custom_location](#table-custom_location)
  - [Description](#description-4)
  - [Structure](#structure-4)
- [Table indigenous_area](#table-indigenous_area)
  - [Description](#description-5)
  - [Structure](#structure-5)
- [Table narrative](#table-narrative)
  - [Description](#description-6)
  - [Structure](#structure-6)
- [Table point](#table-point)
  - [Description](#description-7)
  - [Structure](#structure-7)
- [Table token](#table-token)
  - [Description](#description-8)
  - [Structure](#structure-8)
- [Table us_border](#table-us_border)
  - [Description](#description-9)
  - [Structure](#structure-9)
- [Table visitor](#table-visitor)
  - [Description](#description-10)
  - [Structure](#structure-10)

## Table `admin`

### Description

Table contenant les informations des administrateurs du site.

### Structure

| Nom                     | Type         | Description                           | Null |
|-------------------------|--------------|---------------------------------------|------|
| id                      | int(11)      | Identifiant de l'administrateur       | Non  |
| password                | varchar(128) | Mot de passe de l'administrateur      | Non  |
| email                   | varchar(128) | Adresse mail de l'administrateur      | Non  |
| password_recovery_token | varchar(128) | Token de récupération de mot de passe | Oui  |

## Table `african_kingdom`

### Description

Table contenant les informations des royaumes africains.
Ils sont affichés comme overlays sur la carte.

### Structure

| Nom   | Type          | Description                     | Null |
|-------|---------------|---------------------------------|------|
| id    | int(11)       | Identifiant du royaume africain | Non  |
| name  | varchar(64)   | Nom du royaume africain         | Non  |
| geoj  | text          | Polygone du royaume africain    | Non  |

## Table `country`

### Description

Table contenant les informations des pays.

### Structure

| Nom   | Type        | Description         | Null |
|-------|-------------|---------------------|------|
| id    | int(11)     | Identifiant du pays | Non  |
| name  | varchar(64) | Nom du pays         | Non  |
| geoj  | mediumtext  | Polygone(s) du pays | Non  |

## Table `custom_location`

### Description

Table contenant les informations de zones géographique personnalisées pour les récits.

### Structure

| Nom          | Type                                                                                                                                                | Description                      | Null |
|--------------|-----------------------------------------------------------------------------------------------------------------------------------------------------|----------------------------------|------|
| id           | int(11)                                                                                                                                             | Identifiant du lieu              | Non  |
| id_narrative | int(11)                                                                                                                                             | Identifiant de récit lié au lieu | Non  |
| id_country   | int(11)                                                                                                                                             | Identifiant du pays              | Oui  |
| type         | enum('deces','esclavage','esclavage_lieuvie_deces','lieuvie','lieuvie_deces','naissance','naissance_esclavage','naissance_esclavage_lieuvie_deces') | Type du lieu                     | Non  |
| name         | varchar(128)                                                                                                                                        | Nom du lieu                      | Non  |
| geoj         | mediumtext                                                                                                                                          | Polygone(s) du lieu              | Non  |

## Table `indigenous_area`

### Description

Table contenant les informations des zones autochtones d'Amérique.
Elles sont affichées comme overlays sur la carte.

### Structure

| Nom      | Type          | Description            | Null |
|----------|---------------|------------------------|------|
| id       | int(11)       | Identifiant de la zone | Non  |
| id_style | int(11)       | Identifiant de style   | Non  |
| geoj     | text          | Polygone de la zone    | Non  |

## Table `narrative`

### Description

Table contenant les informations des récits.

### Structure

| Nom                 | Type                                     | Description                            | Null |
|---------------------|------------------------------------------|----------------------------------------|------|
| id                  | int(11)                                  | Identifiant du récit                   | Non  |
| title               | varchar(512)                             | Titre du récit                         | Non  |
| publication_date    | varchar(32)                              | Année de publication                   | Non  |
| publication_mode_en | varchar(128)                             | Mode de publication EN                 | Non  |
| publication_mode_fr | varchar(128)                             | Mode de publication FR                 | Non  |
| type                | enum('dictated', 'written', 'biography') | Type de récit                          | Non  |
| historiography_en   | varchar(1024)                            | Historiographie EN                     | Oui  |
| historiography_fr   | varchar(1024)                            | Historiographie FR                     | Oui  |
| id_narrator         | int(11)                                  | Identifiant du narrateur lié           | Non  |
| white_preface_en    | varchar(32)                              | Si préfacé par une personne blanche EN | Non  |
| white_preface_fr    | varchar(32)                              | Si préfacé par une personne blanche FR | Non  |
| preface_details_en  | varchar(128)                             | Détails de la préface EN               | Oui  |
| preface_details_fr  | varchar(128)                             | Détails de la préface FR               | Oui  |
| scribe_editor_en    | varchar(128)                             | Scribe éditeur EN                      | Oui  |
| scribe_editor_fr    | varchar(128)                             | Scribe éditeur FR                      | Oui  |
| link                | varchar(256)                             | Lien vers la source du récit           | Non  |
| title_beginning     | varchar(32)                              | Début du titre du récit                | Non  |

## Table `narrator`

### Description

Table contenant les informations des narrateurs de récits.

### Structure

| Nom                          | Type         | Description              | Null |
|------------------------------|--------------|--------------------------|------|
| id                           | int(11)      | Identifiant du narrateur | Non  |
| name                         | varchar(64)  | Nom du narrateur         | Non  |
| birth                        | varchar(32)  | Année de naissance       | Non  |
| death                        | varchar(32)  | Année de mort            | Non  |
| freeing_ways_en              | varchar(128) | Moyen de libération EN   | Non  |
| freeing_ways_fr              | varchar(128) | Moyen de libération FR   | Non  |
| parents_origin_en            | varchar(256) | Origines des parents EN  | Non  |
| parents_origin_fr            | varchar(256) | Origines des parents FR  | Non  |
| abolitionist_en              | varchar(64)  | Est un abolitionniste EN | Non  |
| abolitionist_fr              | varchar(64)  | Est un abolitionniste FR | Non  |
| particularities_en           | varchar(128) | Particularités EN        | Oui  |
| particularities_fr           | varchar(128) | Particularités FR        | Oui  |
| has_wrote_several_narratives | tinyint(1)   | A écrit plusieurs récits | Non  |

## Table `point`

### Description

Table contenant les informations des points de récits.

### Structure

| Nom          | Type                                                 | Description                  | Null |
|--------------|------------------------------------------------------|------------------------------|------|
| id           | int(11)                                              | Identifiant du Point         | Non  |
| id_narrative | int(11)                                              | Identifiant de récit lié     | Oui  |
| id_narrator  | int(11)                                              | Identifiant du narrateur lié | Oui  |
| type         | enum('birth','publication','death','slavery','life') | Type de point                | Non  |
| latitude     | double                                               | Latitude du point            | Non  |
| longitude    | double                                               | Longitude du point           | Non  |
| place_en     | varchar(128)                                         | Nom du lieu EN               | Non  |
| place_fr     | varchar(128)                                         | Nom du lieu FR               | Non  |

## Table `token`

### Description

Table contenant les informations des tokens de connexion des administrateurs.

### Structure

| Nom         | Type         | Description                         | Null |
|-------------|--------------|-------------------------------------|------|
| token       | varchar(128) | Token de connexion                  | Non  |
| id_admin    | int(11)      | Identifiant de l'administrateur lié | Non  |
| valid_until | date         | Date d'expiration du token          | Non  |

## Table `us_border`

### Description

Table contenant les informations des frontières états-uniennes.
Elles sont affichées comme overlays sur la carte.

### Structure

| Nom          | Type        | Description                  | Null |
|--------------|-------------|------------------------------|------|
| id           | int(11)     | Identifiant de la frontière  | Non  |
| label        | varchar(64) | Nom de la frontière          | Non  |
| category     | varchar(16) | Catégorie de la frontière    | Non  |
| state        | varchar(8)  | État de la frontière         | Oui  |
| id_narrative | int(11)     | Identifiant du récit lié     | Non  |
| geoj         | text        | Polygones(s) de la frontière | Non  |
| country      | varchar(32) | Pays de la frontière         | Oui  |

## Table `visitor`

### Description

Table comptant le nombre de visiteurs par page chaque jour.

### Structure

| Nom         | Type         | Description       | Null |
|-------------|--------------|-------------------|------|
| route       | varchar(128) | Page visitée      | Non  |
| visit_count | int(11)      | Nombre de visites | Non  |
| date        | date         | Date des visites  | Non  |
