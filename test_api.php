<?php

// Script de test pour l'API Symfony
require_once 'backend/vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();

echo "🧪 Test de l'API Symfony Severum\n\n";

// Test 1: Récupérer les skins populaires
echo "📦 Test 1: Récupération des skins populaires...\n";
try {
    $response = $client->request('GET', 'http://localhost:8000/products/pop');
    if ($response->getStatusCode() === 200) {
        $data = $response->toArray();
        echo "✅ Succès ! " . count($data['data']) . " skins trouvés\n";
        if (!empty($data['data'])) {
            echo "   Premier skin: " . $data['data'][0]['nom_produit'] . " (" . $data['data'][0]['prix'] . "€)\n";
        }
    } else {
        echo "❌ Erreur HTTP: " . $response->getStatusCode() . "\n";
    }
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "   💡 Assurez-vous que le serveur Symfony est démarré avec: php bin/console server:run\n";
}

echo "\n";

// Test 2: Récupérer les skins en promo
echo "🏷️  Test 2: Récupération des skins en promo...\n";
try {
    $response = $client->request('GET', 'http://localhost:8000/products/reduc');
    if ($response->getStatusCode() === 200) {
        $data = $response->toArray();
        echo "✅ Succès ! " . count($data['data']) . " skins en promo trouvés\n";
    } else {
        echo "❌ Erreur HTTP: " . $response->getStatusCode() . "\n";
    }
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Authentification
echo "🔐 Test 3: Authentification...\n";
try {
    $response = $client->request('POST', 'http://localhost:8000/auth/login', [
        'json' => [
            'email' => 'admin@severum.com',
            'password' => 'admin123'
        ]
    ]);
    if ($response->getStatusCode() === 200) {
        $data = $response->toArray();
        echo "✅ Connexion réussie ! Bienvenue " . $data['data']['user']['pseudo'] . "\n";
    } else {
        echo "❌ Erreur HTTP: " . $response->getStatusCode() . "\n";
    }
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

echo "\n🎉 Tests terminés !\n";
echo "\n📋 Prochaines étapes:\n";
echo "   1. Démarrez le serveur: cd backend && php bin/console server:run\n";
echo "   2. Démarrez le frontend: cd frontend && npm run dev\n";
echo "   3. Testez l'application complète\n";
