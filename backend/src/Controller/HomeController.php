<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/home')]
class HomeController extends AbstractController
{
    #[Route('', name: 'home_data', methods: ['GET'])]
    public function getHomeData(): JsonResponse
    {
        // Données pour la page d'accueil
        $homeData = [
            'hero' => [
                'title' => 'Bienvenue sur Severum',
                'subtitle' => 'La marketplace de skins custom pour League of Legends',
                'description' => 'Découvrez des skins uniques créés par la communauté',
                'cta_text' => 'Explorer les skins',
                'cta_link' => '/products'
            ],
            'features' => [
                [
                    'title' => 'Skins Uniques',
                    'description' => 'Des créations originales par des artistes talentueux',
                    'icon' => 'brush'
                ],
                [
                    'title' => 'Sécurisé',
                    'description' => 'Téléchargements sécurisés et vérifiés',
                    'icon' => 'shield'
                ],
                [
                    'title' => 'Support',
                    'description' => 'Guide d\'installation inclus pour chaque skin',
                    'icon' => 'help'
                ]
            ],
            'stats' => [
                'skins_count' => '150+',
                'creators_count' => '25+',
                'downloads_count' => '10K+'
            ]
        ];

        return $this->json([
            'success' => true,
            'data' => $homeData
        ]);
    }
}
