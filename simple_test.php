<?php
// Test simple avec file_get_contents
echo "🧪 Test simple de l'API\n\n";

// Test 1: Homepage de l'API
echo "📡 Test 1: Homepage de l'API...\n";
$result = @file_get_contents('http://localhost:8000/');
if ($result) {
    echo "✅ Serveur répond !\n";
} else {
    echo "❌ Serveur inaccessible\n";
    echo "   Erreur: " . error_get_last()['message'] . "\n";
}

echo "\n";

// Test 2: Endpoint products/pop
echo "📦 Test 2: Endpoint products/pop...\n";
$result = @file_get_contents('http://localhost:8000/products/pop');
if ($result) {
    $data = json_decode($result, true);
    if ($data && isset($data['success'])) {
        echo "✅ Endpoint fonctionne ! " . count($data['data']) . " skins trouvés\n";
    } else {
        echo "❌ Réponse invalide\n";
        echo "   Réponse: " . substr($result, 0, 200) . "...\n";
    }
} else {
    echo "❌ Endpoint inaccessible\n";
    echo "   Erreur: " . error_get_last()['message'] . "\n";
}

echo "\n🎉 Test terminé !\n";
