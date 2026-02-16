<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Skin;
use App\Repository\OrderRepository;
use App\Repository\SkinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
    private SkinRepository $skinRepository;
    private OrderRepository $orderRepository;
    private RequestStack $requestStack;

    public function __construct(
        SkinRepository $skinRepository,
        OrderRepository $orderRepository,
        RequestStack $requestStack
    ) {
        $this->skinRepository = $skinRepository;
        $this->orderRepository = $orderRepository;
        $this->requestStack = $requestStack;
    }

    private function getCart(): array
    {
        return $this->requestStack->getSession()->get('cart', []);
    }

    private function setCart(array $cart): void
    {
        $this->requestStack->getSession()->set('cart', $cart);
    }

    #[Route('', name: 'cart_show', methods: ['GET'])]
    public function showCart(): JsonResponse
    {
        $cart = $this->getCart();
        $items = [];

        foreach ($cart as $productId => $quantity) {
            $skin = $this->skinRepository->find($productId);
            if ($skin && $skin->getStatus() === 'published') {
                $items[] = [
                    'produit' => [
                        'id_produit' => $skin->getId(),
                        'nom_produit' => $skin->getTitle(),
                        'prix' => $skin->getPrice() / 100,
                        'image_produit' => $skin->getCoverImage() ?: '/images/default-skin.jpg'
                    ],
                    'quantite' => $quantity
                ];
            }
        }

        return $this->json([
            'success' => true,
            'data' => [
                'items' => $items
            ]
        ]);
    }

    #[Route('/add', name: 'cart_add', methods: ['POST'])]
    public function addToCart(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['id_produit']) || !isset($data['quantite'])) {
            return $this->json([
                'success' => false,
                'message' => 'id_produit et quantite requis'
            ], 400);
        }

        $skin = $this->skinRepository->find($data['id_produit']);
        if (!$skin || $skin->getStatus() !== 'published') {
            return $this->json([
                'success' => false,
                'message' => 'Produit non disponible'
            ], 404);
        }

        $cart = $this->getCart();
        $productId = $data['id_produit'];
        $quantity = (int) $data['quantite'];

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        $this->setCart($cart);

        return $this->json([
            'success' => true,
            'message' => 'Produit ajouté au panier'
        ]);
    }

    #[Route('/update', name: 'cart_update', methods: ['POST'])]
    public function updateCart(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['id_produit']) || !isset($data['quantite'])) {
            return $this->json([
                'success' => false,
                'message' => 'id_produit et quantite requis'
            ], 400);
        }

        $productId = $data['id_produit'];
        $quantity = (int) $data['quantite'];

        if ($quantity < 1) {
            return $this->json([
                'success' => false,
                'message' => 'La quantité doit être supérieure à 0'
            ], 400);
        }

        $cart = $this->getCart();
        
        if (isset($cart[$productId])) {
            $cart[$productId] = $quantity;
            $this->setCart($cart);
        }

        return $this->json([
            'success' => true,
            'message' => 'Quantité mise à jour'
        ]);
    }

    #[Route('/remove', name: 'cart_remove', methods: ['POST'])]
    public function removeFromCart(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['id_produit'])) {
            return $this->json([
                'success' => false,
                'message' => 'id_produit requis'
            ], 400);
        }

        $cart = $this->getCart();
        $productId = $data['id_produit'];

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->setCart($cart);
        }

        return $this->json([
            'success' => true,
            'message' => 'Produit retiré du panier'
        ]);
    }

    #[Route('/validate', name: 'cart_validate', methods: ['POST'])]
    public function validateOrder(): JsonResponse
    {
        $cart = $this->getCart();

        if (empty($cart)) {
            return $this->json([
                'success' => false,
                'message' => 'Le panier est vide'
            ], 400);
        }

        // Pour l'instant, on simule une validation
        // Plus tard, vous pourrez créer une vraie commande ici
        
        $total = 0;
        $items = [];

        foreach ($cart as $productId => $quantity) {
            $skin = $this->skinRepository->find($productId);
            if ($skin && $skin->getStatus() === 'published') {
                $itemTotal = ($skin->getPrice() / 100) * $quantity;
                $total += $itemTotal;
                
                $items[] = [
                    'product' => $skin->getTitle(),
                    'quantity' => $quantity,
                    'unit_price' => $skin->getPrice() / 100,
                    'total' => $itemTotal
                ];
            }
        }

        // Vider le panier après validation
        $this->setCart([]);

        return $this->json([
            'success' => true,
            'message' => 'Commande validée avec succès',
            'data' => [
                'order_reference' => 'CMD-' . date('Y') . '-' . strtoupper(uniqid()),
                'total' => $total,
                'items' => $items
            ]
        ]);
    }
}
