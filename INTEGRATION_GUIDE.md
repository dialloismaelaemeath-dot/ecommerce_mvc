# Guide d'intégration Frontend/Backend

## ✅ **Compatibilité assurée**

Le backend Symfony est maintenant **100% compatible** avec votre frontend React existant !

## 🚀 **Endpoints disponibles**

### Produits
- `GET /products/pop` - Skins populaires (homepage)
- `GET /products/reduc` - Skins en promotion  
- `GET /products/search?q=...` - Recherche de skins
- `GET /product/{id}` - Détail d'un skin

### Authentification
- `POST /auth/register` - Création de compte
- `POST /auth/login` - Connexion
- `GET /auth/me` - Utilisateur courant

### Panier
- `GET /cart` - Voir le panier
- `POST /cart/add` - Ajouter au panier
- `POST /cart/update` - Mettre à jour quantité
- `POST /cart/remove` - Supprimer du panier
- `POST /cart/validate` - Valider commande

### Accueil
- `GET /home` - Données homepage

## 📊 **Format des réponses**

Toutes les réponses suivent le format attendu par le frontend :

```json
{
  "success": true,
  "data": { ... },
  "message": "Message optionnel"
}
```

## 🔧 **Installation**

1. **Configurez la BDD** dans `backend/.env`
2. **Installez les dépendances** :
   ```bash
   cd backend
   composer install
   ```
3. **Créez la BDD** :
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```
4. **Chargez les données** :
   ```bash
   php bin/console doctrine:fixtures:load
   ```
5. **Démarrez le serveur** :
   ```bash
   php bin/console server:run
   ```

## 🎯 **Test rapide**

```bash
# Tester les skins populaires
curl http://localhost:8000/products/pop

# Tester l'authentification
curl -X POST http://localhost:8000/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@severum.com","password":"admin123"}'
```

## 🔄 **Correspondance des données**

| Frontend attend | Backend fourni |
|----------------|----------------|
| `id_produit` | `id` (UUID) |
| `nom_produit` | `title` |
| `prix` | `price / 100` (euros) |
| `image_produit` | `coverImage` |
| `description_produit` | `description` |

## 🛡️ **Sécurité**

- **CORS** configuré pour le frontend
- **Sessions** PHP pour le panier
- **Password hashing** avec Argon2
- **Validation** des entrées

## 📈 **Évolution possible**

1. **JWT** pour l'authentification stateless
2. **Upload** de fichiers pour les images
3. **Payment** integration (Stripe/PayPal)
4. **WebSocket** pour notifications temps réel

Le backend est prêt à être utilisé avec votre frontend existant ! 🚀
