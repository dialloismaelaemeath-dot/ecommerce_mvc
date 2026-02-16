# Cahier des Charges : Marketplace de Skins Custom (LoL) - Severum

## 1. Présentation du Projet

Severum est une plateforme "Creator-to-Consumer" dédiée au modding de League of Legends. Elle centralise le partage et la vente de contenus cosmétiques personnalisés tout en garantissant la sécurité des fichiers et l'accompagnement technique des utilisateurs.

## 2. Spécifications Fonctionnelles

A. Gestion des Utilisateurs

    Profil Acheteur : Historique des achats, gestion des skins favoris, accès aux téléchargements.
    Profil Vendeur : Biographie, portfolio des skins créés, statistiques de ventes/téléchargements, et bouton "Devenir Vendeur" (soumis à validation ou simple switch).
    Système de Rôles : Distinction claire entre ROLE_USER, ROLE_SELLER, et ROLE_ADMIN.

B. Marketplace & Catalogue

    Fiches Produits détaillées : Nom du skin, champion concerné, images/vidéos de démonstration, prix, et description.
    Système de Panier : Ajout de plusieurs skins, calcul du total, et tunnel de commande.
    Recherche et Filtres : Par champion, par thématique de skin (ex: Cyberpunk, Fantasy), par prix ou par popularité.

C. Contenu Pédagogique

    Guide d'installation : Page dédiée (CMS) expliquant l'utilisation des outils tiers (type LCS-Manager) pour installer les skins en jeu.

## 3. Architecture Technique

Stack Technologique

    Backend : API REST avec Symfony 7 (gestion de la sécurité, des transactions et de la base de données).
    Frontend : React.js (via Vite) pour une interface fluide et réactive (SPA).
    Base de données : PostgreSQL pour une gestion robuste des relations (Vendeurs <-> Produits <-> Commandes).
    Stockage : Utilisation d'un service cloud (type AWS S3 ou équivalent) pour héberger les fichiers de skins souvent volumineux. (fictif parce que on est pauvres.)

## 4. Maquette UI & Expérience Utilisateur (UX)

Page Éléments Clés

    Homepage	Hero banner, skins mis en avant, derniers ajouts, barre de recherche.
    Profil Vendeur	Bannière personnalisée, liste des skins du vendeur, avis clients.
    Détail Produit	Galerie d'images, bouton d'achat, instructions spécifiques au skin.
    Guide d'install	Étapes numérotées, captures d'écran d'aide, liens de téléchargement des outils.
    Panier	Récapitulatif, choix du mode de paiement, validation.

## 5. Modélisation des Données (Entités Symfony)

Pour le backend :

    User : Email, password, pseudo, avatar, roles.
    Skin : Title, description, price, champion_name, file_path, cover_image.
    Order : Reference, total_price, status, created_at.
    Category/Tag : Pour filtrer les types de skins.

## 6. Prochaines Étapes

    Initialisation : Setup du projet Symfony (API Platform recommandé) et de React avec Vite.
    Base de données : Création des migrations PostgreSQL.
    Sécurité : Mise en place de l'authentification JWT (JSON Web Token) entre React et Symfony.


# Étude de Marché : Marketplace de Skins Custom LoL

## 1. Analyse du Marché Global

    Le marché des cosmétiques dans le jeu vidéo (skins) représente plusieurs milliards de dollars. Pour League of Legends, bien que Riot Games vende ses propres skins, il existe une sous-culture massive de "Custom Skins" (modding).
    Taille de la communauté : Des millions de joueurs actifs quotidiennement. 
    Tendance : Les joueurs recherchent de plus en plus l'exclusivité ou des références culturelles que Riot ne peut pas exploiter pour des raisons de droits d'auteur (ex: un skin de Goku pour Lee Sin).

## 2. Analyse de la Concurrence

Il est important de savoir où se situent les futurs utilisateurs de la plateforme :


|Concurrent| 	Points Forts                                                                                                     | 	Points Faibles                                                                                                    |
|----------|-------------------------------------------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------------------------------|
|Runeforge / Killerskins| 	Références historiques, grosse base de données gratuite.                                                         | 	Interface parfois datée, aspect "forum", pas de réelle monétisation simplifiée pour les créateurs.                |
|Patreon / Discord| 	Permet aux créateurs de vendre directement.                                                                      | 	Pas de catalogue centralisé, difficile pour un acheteur de trouver un skin spécifique sans connaître le créateur. |
|Gumroad| 	Paiement sécurisé et professionnel.| 	Pas spécialisé dans le jeu vidéo, aucune prévisualisation adaptée aux skins.                                      |

## 3. Cible et Personas

Pour que le site fonctionne, il doit répondre aux besoins de deux types d'utilisateurs :

   A. Le Créateur (Vendeur)
   
      Profil : Artiste 3D, modeleur ou textureur.
      Besoin : Une plateforme pour centraliser ses créations, protéger ses fichiers et générer un revenu complémentaire sans avoir à gérer un site web complexe.

   B. Le Joueur (Acheteur)

      Profil : Joueur régulier (souvent entre 15 et 30 ans) cherchant à personnaliser son expérience de jeu.
      Besoin : Un site de confiance, un guide d'installation clair (pour éviter les virus ou les erreurs techniques) et un système de paiement simple.

## 4. Analyse des Risques (Légal & Technique)

C'est le point le plus sensible pour le cahier des charges :

      Propriété Intellectuelle : Riot Games tolère généralement les skins customs s'ils sont gratuits, mais la vente de contenu utilisant leurs assets est une zone grise (voire risquée).
      Stratégie : Il est conseillé de se positionner comme une plateforme de mise en relation pour des "services de modding" ou des "créations originales".
      Sécurité Anti-Cheat (Vanguard) : Les skins customs doivent être compatibles avec le système anti-triche de Riot. Ton guide d'installation doit être constamment à jour pour éviter le bannissement des utilisateurs.

## 5. Modèle Économique (Monétisation)

Pour rentabiliser la plateforme, tu peux envisager :

      Commission sur les ventes : Le site prélève 10 à 15% sur chaque transaction.
      Modèle Freemium : Skins basiques gratuits, skins "Premium" payants.
      Abonnement Créateur : Un forfait mensuel pour les vendeurs pour avoir une boutique mise en avant (Featured).