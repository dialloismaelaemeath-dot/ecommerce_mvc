<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/auth')]
class AuthController extends AbstractController
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/register', name: 'auth_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email']) || !isset($data['password']) || !isset($data['pseudo'])) {
            return $this->json([
                'success' => false,
                'message' => 'Champs email, password et pseudo requis'
            ], Response::HTTP_BAD_REQUEST);
        }

        // Vérifier si l'email existe déjà
        if ($this->userRepository->findByEmail($data['email'])) {
            return $this->json([
                'success' => false,
                'message' => 'Cet email est déjà utilisé'
            ], Response::HTTP_CONFLICT);
        }

        // Vérifier si le pseudo existe déjà
        if ($this->userRepository->findByPseudo($data['pseudo'])) {
            return $this->json([
                'success' => false,
                'message' => 'Ce pseudo est déjà utilisé'
            ], Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPseudo($data['pseudo']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
        $user->setRoles(['ROLE_USER']);

        $this->userRepository->save($user, true);

        return $this->json([
            'success' => true,
            'message' => 'Compte créé avec succès',
            'data' => [
                'user' => [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'pseudo' => $user->getPseudo(),
                    'roles' => $user->getRoles()
                ]
            ]
        ], Response::HTTP_CREATED);
    }

    #[Route('/login', name: 'auth_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email']) || !isset($data['password'])) {
            return $this->json([
                'success' => false,
                'message' => 'Email et password requis'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userRepository->findByEmail($data['email']);

        if (!$user || !$this->passwordHasher->isPasswordValid($user, $data['password'])) {
            return $this->json([
                'success' => false,
                'message' => 'Identifiants incorrects'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Pour l'instant, on simule une session simple
        // Plus tard, vous pourrez ajouter JWT ici
        return $this->json([
            'success' => true,
            'message' => 'Connexion réussie',
            'data' => [
                'user' => [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'pseudo' => $user->getPseudo(),
                    'roles' => $user->getRoles(),
                    'bio' => $user->getBio(),
                    'avatar_url' => $user->getAvatarUrl()
                ]
            ]
        ]);
    }

    #[Route('/me', name: 'auth_me', methods: ['GET'])]
    public function getCurrentUser(): JsonResponse
    {
        // Pour l'instant, on retourne un utilisateur de test
        // Plus tard, vous pourrez récupérer l'utilisateur connecté via JWT/session
        
        return $this->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => 'test-user-id',
                    'email' => 'test@example.com',
                    'pseudo' => 'TestUser',
                    'roles' => ['ROLE_USER']
                ]
            ]
        ]);
    }
}
