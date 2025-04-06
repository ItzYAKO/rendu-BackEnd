<?php
// Charge automatiquement les classes installées via Composer
require 'vendor/autoload.php';

// Importation de la classe Client de Guzzle pour effectuer des requêtes HTTP
use GuzzleHttp\Client;

// Configuration de l'API
$apiKey = '86b64c8d-4941-440a-892d-1a5e185faad0';
$resource = 'object';
$url = "https://api.harvardartmuseums.org/$resource";
$size = 100;

// Récupération du numéro de page depuis le formulaire, ou assignation de la page 1 si non spécifiée
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Création d'un client Guzzle pour effectuer des requêtes HTTP
$client = new Client();

try {
    // Envoi de la requête GET à l'API de Harvard Art Museums avec les paramètres nécessaires
    $response = $client->request('GET', $url, [
        'query' => [
            'apikey' => $apiKey,  // La clé API pour l'authentification
            'size' => $size,      // Le nombre d'objets à récupérer par page
            'page' => $page       // La page à afficher
        ]
    ]);

    // Récupération du corps de la réponse de l'API
    $body = $response->getBody();
    // Décodage du JSON reçu en tableau PHP
    $data = json_decode($body, true);
} catch (Exception $e) {
    // En cas d'erreur dans la requête, on affiche le message d'erreur
    $error = "Erreur lors de la requête : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Harvard Art Museums - Page <?= $page ?></title>
</head>
<body>
    <h1>Œuvres du Harvard Art Museums</h1>

    <!-- Formulaire pour changer de page -->
    <form method="get">
        <label for="page">Numéro de page :</label>
        <input type="number" name="page" id="page" value="<?= $page ?>" min="1" required>
        <button type="submit">Afficher</button>
    </form>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>  <!-- Affiche l'erreur en rouge si elle existe -->
    <?php elseif (!empty($data['records'])): ?>
        <!-- Si les données sont présentes, affiche un tableau des résultats -->
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>Titre</th>
                <th>Artiste</th>
                <th>Culture</th>
            </tr>
            <?php foreach ($data['records'] as $record): ?>
                <tr>
                    <td><?= $record['title'] ?? 'Titre inconnu' ?></td>   <!-- Affiche le titre, ou 'Titre inconnu' si non trouvé -->
                    <td><?= $record['people'][0]['name'] ?? 'Artiste inconnu' ?></td>  <!-- Affiche le nom de l'artiste, ou 'Artiste inconnu' si non trouvé -->
                    <td><?= $record['culture'] ?? 'Culture inconnue' ?></td>  <!-- Affiche la culture, ou 'Culture inconnue' si non trouvée -->
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <!-- Si aucune donnée n'est disponible, affiche un message -->
        <p>Aucune donnée trouvée pour la page <?= $page ?>.</p>
    <?php endif; ?>
</body>
</html>