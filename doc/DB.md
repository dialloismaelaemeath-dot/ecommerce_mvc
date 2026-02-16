# Organisation de la base de données.

## Choix du MGBD : PostgreSQL

## Organisation des tables : 

### Gérer les utilisateurs : 

User : 

| Table | Colonne    | Type     | Description                   |
|-------|------------|----------|-------------------------------|
| User  | id         | UUID     | Clé primaire                  |
|       | email      | VARCHAR  | Unique, login                 |
|       | password   | VARCHAR  | Hashé (BCrypt/Argon2)         |
|       | pseudo     | VARCHAR  | Nom d'affichage               |
|       | role       | JSONB    | ex: ["ROLE_SELLER"]           |
|       | bio        | TEXT     | Pour le profil vendeur        |
|       | avatar_url | VARCHAR  | Lien vers l'image de l'avatar |
|       | created_at | DateTime | Date d'inscription            |

 ### Gérer les skins en eux mêmes : 

Skins : 

| Table | Colonne     | Type         | Description                              |
|-------|-------------|--------------|------------------------------------------|
| Skins | id          | UUID         | Clé primaire                             |
|       | seller_id   | UUID         | FK vers User(id)                         |
|       | champion_id | INTEGER      | FK vers Champion(id)                     |
|       | title       | VARCHAR(255) | Nom du skin                              |
|       | description | TEXT         | Détails et instructions                  |
|       | price       | INTEGER      | Prix en centimes (ex: 500 pour 5.00€)    |
|       | file_path   | VARCHAR(255) | Chemin du fichier sur le stockage cloud  |
|       | cover_image | VARCHAR(255) | URL de l'image principale                |
|       | status      | VARCHAR(50)  | ex: 'draft', 'published', 'under_review' |
|       | created_at  | DateTime     | Date de création du skin                 |


### Gérer les champions : 

Champion : 

| Table     | Colonne | Type         | Description                     |
|-----------|---------|--------------|---------------------------------|
| Champions | id      | SERIAL       | Clé primaire                    |
|           | name    | VARCHAR(100) | Nom du champion (ex: "Lee Sin") |
|           | slug    | VARCHAR(100) | Identifiant URL unique          |


### Gérer les catégories pour les skins : 

Category : 

| Table    | Colonne | Type         | Description                     |
|----------|---------|--------------|---------------------------------|
| Category | id      | SERIAL       | Clé primaire                    |
|          | name    | VARCHAR(100) | Nom (ex: "Cyberpunk", "Anime")  |
|          | slug    | VARCHAR(100) | Identifiant URL unique          |


### Table de liaison entre Skins et Category : 

| Table         | Colonne     | Type    | Description           |
|---------------|-------------|---------|-----------------------|
| Skin_Category | skin_id     | UUID    | FK vers Skin(id)      |
|               | category_id | INTEGER | FK vers Category(id)  |


### Gérer les ventes et les commandes : 

Order : 

| Table | Colonne     | Type        | Description                          |
|-------|-------------|-------------|--------------------------------------|
| Order | id          | UUID        | Clé primaire                         |
|       | buyer_id    | UUID        | FK vers User(id)                     |
|       | reference   | VARCHAR(20) | Référence unique (ex: CMD-2026-XXXX) |
|       | total_price | INTEGER     | Montant total payé en centimes       |
|       | status      | VARCHAR(50) | ex: 'pending', 'paid', 'cancelled'   |
|       | created_at  | TIMESTAMP   | Date et heure de la transaction      |


### Table de relation entre Order et Skin : 


| Table      | Colonne           | Type      | Description                              |
|------------|-------------------|-----------|------------------------------------------|
| Order_Item | id                | SERIAL    | Clé primaire                             |
|            | order_id          | UUID      | FK vers Order(id)                        |
|            | skin_id           | UUID      | FK vers Skin(id)                         |
|            | price_at_purchase | INTEGER   | Prix au moment de l'achat (historique)   |











