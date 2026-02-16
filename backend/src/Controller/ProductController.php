<?php

namespace App\Controller;

use App\Entity\Skin;
use App\Repository\SkinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products')]
class ProductController extends AbstractController
{
    private SkinRepository $skinRepository;

    public function __construct(SkinRepository $skinRepository)
    {
        $this->skinRepository = $skinRepository;
    }

    #[Route('/pop', name: 'products_popular', methods: ['GET'])]
    public function getPopularProducts(): JsonResponse
    {
        $popularSkins = $this->skinRepository->findFeaturedSkins(6);
        
        $products = array_map(function ($skin) {
            return [
                'id_produit' => $skin->getId(),
                'nom_produit' => $skin->getTitle(),
                'prix' => $skin->getPrice() / 100, // Convertir centimes en euros
                'image_produit' => $skin->getCoverImage() ?: '/images/default-skin.jpg',
                'description_produit' => $skin->getDescription(),
                'champion' => $skin->getChampion()->getName(),
                'seller' => $skin->getSeller()->getPseudo()
            ];
        }, $popularSkins);

        return $this->json([
            'success' => true,
            'data' => $products
        ]);
    }

    #[Route('/reduc', name: 'products_promo', methods: ['GET'])]
    public function getPromoProducts(): JsonResponse
    {
        // Pour l'instant, on retourne les mêmes produits que les populaires
        // Vous pourrez ajouter une logique de promo plus tard
        $promoSkins = $this->skinRepository->findFeaturedSkins(4);
        
        $products = array_map(function ($skin) {
            $originalPrice = $skin->getPrice() / 100;
            $promoPrice = $originalPrice * 0.8; // 20% de réduction
            
            return [
                'id_produit' => $skin->getId(),
                'nom_produit' => $skin->getTitle(),
                'prix' => $promoPrice,
                'original_price' => $originalPrice,
                'image_produit' => $skin->getCoverImage() ?: '/images/default-skin.jpg',
                'description_produit' => $skin->getDescription(),
                'champion' => $skin->getChampion()->getName(),
                'seller' => $skin->getSeller()->getPseudo()
            ];
        }, $promoSkins);

        return $this->json([
            'success' => true,
            'data' => $products
        ]);
    }

    #[Route('/search', name: 'products_search', methods: ['GET'])]
    public function searchProducts(Request $request): JsonResponse
    {
        $query = $request->query->get('q', '');
        $champion = $request->query->get('champion', '');
        $category = $request->query->get('category', '');

        if ($query) {
            $skins = $this->skinRepository->searchSkins($query);
        } elseif ($champion) {
            // Logique pour filtrer par champion
            $skins = $this->skinRepository->findByChampion((int)$champion);
        } elseif ($category) {
            // Logique pour filtrer par catégorie
            $skins = $this->skinRepository->findByCategory((int)$category);
        } else {
            $skins = $this->skinRepository->findPublishedSkins();
        }

        $products = array_map(function ($skin) {
            return [
                'id_produit' => $skin->getId(),
                'nom_produit' => $skin->getTitle(),
                'prix' => $skin->getPrice() / 100,
                'image_produit' => $skin->getCoverImage() ?: '/images/default-skin.jpg',
                'description_produit' => $skin->getDescription(),
                'champion' => $skin->getChampion()->getName(),
                'seller' => $skin->getSeller()->getPseudo()
            ];
        }, $skins);

        return $this->json([
            'success' => true,
            'data' => $products
        ]);
    }
}
