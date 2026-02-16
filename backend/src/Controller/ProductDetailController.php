<?php

namespace App\Controller;

use App\Entity\Skin;
use App\Repository\SkinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductDetailController extends AbstractController
{
    private SkinRepository $skinRepository;

    public function __construct(SkinRepository $skinRepository)
    {
        $this->skinRepository = $skinRepository;
    }

    #[Route('/{id}', name: 'product_detail', methods: ['GET'])]
    public function getProductDetail(string $id): JsonResponse
    {
        $skin = $this->skinRepository->find($id);
        
        if (!$skin || $skin->getStatus() !== 'published') {
            throw new NotFoundHttpException('Produit introuvable');
        }

        $product = [
            'id_produit' => $skin->getId(),
            'nom_produit' => $skin->getTitle(),
            'prix' => $skin->getPrice() / 100,
            'image_produit' => $skin->getCoverImage() ?: '/images/default-skin.jpg',
            'description_produit' => $skin->getDescription(),
            'file_path' => $skin->getFilePath(),
            'champion' => [
                'id' => $skin->getChampion()->getId(),
                'name' => $skin->getChampion()->getName(),
                'slug' => $skin->getChampion()->getSlug()
            ],
            'seller' => [
                'id' => $skin->getSeller()->getId(),
                'pseudo' => $skin->getSeller()->getPseudo(),
                'bio' => $skin->getSeller()->getBio(),
                'avatar_url' => $skin->getSeller()->getAvatarUrl()
            ],
            'categories' => array_map(function($category) {
                return [
                    'id' => $category->getId(),
                    'name' => $category->getName(),
                    'slug' => $category->getSlug()
                ];
            }, $skin->getCategories()->toArray()),
            'created_at' => $skin->getCreatedAt()->format('Y-m-d H:i:s')
        ];

        return $this->json([
            'success' => true,
            'data' => $product
        ]);
    }
}
