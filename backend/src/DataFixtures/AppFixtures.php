<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Champion;
use App\Entity\Skin;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création des utilisateurs
        $admin = new User();
        $admin->setEmail('admin@severum.com');
        $admin->setPseudo('Admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $admin->setBio('Administrateur de la plateforme Severum');
        $manager->persist($admin);

        $seller1 = new User();
        $seller1->setEmail('seller1@severum.com');
        $seller1->setPseudo('SkinMaster');
        $seller1->setRoles(['ROLE_USER', 'ROLE_SELLER']);
        $seller1->setPassword($this->passwordHasher->hashPassword($seller1, 'seller123'));
        $seller1->setBio('Créateur de skins depuis 5 ans, spécialisé dans les thèmes cyberpunk.');
        $manager->persist($seller1);

        $seller2 = new User();
        $seller2->setEmail('seller2@severum.com');
        $seller2->setPseudo('AnimeArtist');
        $seller2->setRoles(['ROLE_USER', 'ROLE_SELLER']);
        $seller2->setPassword($this->passwordHasher->hashPassword($seller2, 'seller123'));
        $seller2->setBio('Artiste passionné par l\'univers manga et anime.');
        $manager->persist($seller2);

        $buyer = new User();
        $buyer->setEmail('buyer@severum.com');
        $buyer->setPseudo('GamerPro');
        $buyer->setRoles(['ROLE_USER']);
        $buyer->setPassword($this->passwordHasher->hashPassword($buyer, 'buyer123'));
        $manager->persist($buyer);

        // Création des champions
        $champions = [
            ['Ahri', 'ahri'],
            ['Yasuo', 'yasuo'],
            ['Jinx', 'jinx'],
            ['Lee Sin', 'lee-sin'],
            ['Lux', 'lux'],
            ['Garen', 'garen'],
            ['Ashe', 'ashe'],
            ['Thresh', 'thresh'],
        ];

        $championEntities = [];
        foreach ($champions as [$name, $slug]) {
            $champion = new Champion();
            $champion->setName($name);
            $champion->setSlug($slug);
            $manager->persist($champion);
            $championEntities[$slug] = $champion;
        }

        // Création des catégories
        $categories = [
            ['Cyberpunk', 'cyberpunk'],
            ['Anime', 'anime'],
            ['Fantasy', 'fantasy'],
            ['Steampunk', 'steampunk'],
            ['Space', 'space'],
            ['Medieval', 'medieval'],
        ];

        $categoryEntities = [];
        foreach ($categories as [$name, $slug]) {
            $category = new Category();
            $category->setName($name);
            $category->setSlug($slug);
            $manager->persist($category);
            $categoryEntities[$slug] = $category;
        }

        // Création des skins
        $skins = [
            [
                'title' => 'Ahri Cyber Runner',
                'description' => 'Ahri dans un style cyberpunk futuriste avec des néons roses et bleus.',
                'price' => 500,
                'seller' => $seller1,
                'champion' => $championEntities['ahri'],
                'categories' => [$categoryEntities['cyberpunk']],
                'status' => 'published'
            ],
            [
                'title' => 'Yasuo Samurai',
                'description' => 'Yasuo en armure de samurai traditionnelle avec des détails modernes.',
                'price' => 750,
                'seller' => $seller2,
                'champion' => $championEntities['yasuo'],
                'categories' => [$categoryEntities['anime'], $categoryEntities['medieval']],
                'status' => 'published'
            ],
            [
                'title' => 'Jinx Space Pirate',
                'description' => 'Jinx en pirate de l\'espace avec des armes futuristes.',
                'price' => 600,
                'seller' => $seller1,
                'champion' => $championEntities['jinx'],
                'categories' => [$categoryEntities['space']],
                'status' => 'published'
            ],
            [
                'title' => 'Lee Sin Dragon Spirit',
                'description' => 'Lee Sin avec l\'esprit du dragon manifesté autour de lui.',
                'price' => 800,
                'seller' => $seller2,
                'champion' => $championEntities['lee-sin'],
                'categories' => [$categoryEntities['fantasy'], $categoryEntities['anime']],
                'status' => 'published'
            ],
            [
                'title' => 'Lux Steampunk',
                'description' => 'Lux avec des accessoires steampunk en cuivre et laiton.',
                'price' => 450,
                'seller' => $seller1,
                'champion' => $championEntities['lux'],
                'categories' => [$categoryEntities['steampunk']],
                'status' => 'published'
            ],
            [
                'title' => 'Garen Knight Commander',
                'description' => 'Garen en armure de commandant chevalier avec des détails dorés.',
                'price' => 550,
                'seller' => $seller2,
                'champion' => $championEntities['garen'],
                'categories' => [$categoryEntities['medieval']],
                'status' => 'published'
            ],
        ];

        foreach ($skins as $skinData) {
            $skin = new Skin();
            $skin->setTitle($skinData['title']);
            $skin->setDescription($skinData['description']);
            $skin->setPrice($skinData['price']);
            $skin->setSeller($skinData['seller']);
            $skin->setChampion($skinData['champion']);
            $skin->setStatus($skinData['status']);
            $skin->setCoverImage('/images/skins/' . strtolower(str_replace(' ', '-', $skinData['title'])) . '.jpg');
            
            foreach ($skinData['categories'] as $category) {
                $skin->addCategory($category);
            }
            
            $manager->persist($skin);
        }

        $manager->flush();
    }
}
