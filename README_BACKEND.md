# Backend Symfony - Marketplace Severum

## Installation

1. **Configuration de la base de données**
   
   Éditez le fichier `backend/.env` et configurez votre connexion PostgreSQL :
   ```env
   DATABASE_URL="postgresql://postgres:Tokorico360@127.0.0.1:5432/Severum?serverVersion=16&charset=utf8"
   ```

2. **Installation des dépendances**
   ```bash
   cd backend
   composer install
   ```

3. **Création de la base de données**
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

4. **Chargement des données de test**
   ```bash
   php bin/console doctrine:fixtures:load
   ```

5. **Démarrage du serveur**
   ```bash
   php bin/console server:run
   ```

## API Endpoints

Une fois le serveur démarré, vous pouvez accéder à :
- **API Documentation** : http://127.0.0.1:8000/api
- **Admin Interface** : http://127.0.0.1:8000/admin

## Entités créées

### User
- Gestion des utilisateurs avec rôles (USER, SELLER, ADMIN)
- Authentification via password hash
- Profil avec bio et avatar

### Champion
- Liste des champions League of Legends
- Relation avec les skins

### Category
- Catégories de skins (Cyberpunk, Anime, Fantasy, etc.)
- Relation many-to-many avec les skins

### Skin
- Produits principaux de la marketplace
- Prix en centimes (ex: 500 = 5.00€)
- Statuts (draft, published, under_review)
- Relations avec vendeur, champion et catégories

### Order
- Commandes des utilisateurs
- Référence unique automatique
- Statuts de paiement

### OrderItem
- Détails des commandes
- Historique des prix au moment de l'achat

## Utilisateurs de test

- **Admin** : admin@severum.com / admin123
- **Vendeur 1** : seller1@severum.com / seller123
- **Vendeur 2** : seller2@severum.com / seller123
- **Acheteur** : buyer@severum.com / buyer123

## Prochaines étapes

1. **Configuration JWT** : Pour l'authentification entre frontend et backend
2. **Validation des données** : Ajouter des contraintes de validation
3. **Upload de fichiers** : Gérer l'upload des images et fichiers de skins
4. **Système de paiement** : Intégrer une solution de paiement
5. **Notifications** : Emails de confirmation de commande

## Structure des fichiers

```
backend/
├── src/
│   ├── Entity/          # Entités Doctrine
│   ├── Repository/      # Repositories personnalisés
│   └── Controller/      # Contrôleurs API
├── config/              # Configuration Symfony
├── migrations/          # Migrations de base de données
├── fixtures/            # Données de test
└── public/              # Fichiers publics
```
