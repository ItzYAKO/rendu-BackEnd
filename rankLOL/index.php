<?php
//Inclusion des dépendances et initialisation des variables
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

$apiKey = "RGAPI-e1d58a8c-b257-4906-9f76-df3421ca93c"; // Clé API Riot Games

$riotId = "";
$riotTag = "";
$PUUID = null;
$summonerLevel = null;
$rank = null;

$regionRouting = "europe"; // Pour l'API "account"
$regionGame = "euw1";      // Pour les APIs "lol/*"

$errorMessage = null; // À placer tout en haut de ton PHP

//Récupération des informations via le formulaire
if (isset($_GET['riotId']) && isset($_GET['riotTag'])) {
    $riotId = str_replace('+', '%20', urlencode($_GET['riotId']));
    $riotTag = urlencode($_GET['riotTag']);
    

//Récupération du PUUID via Riot ID et Tag
    $urlPUUID = "https://$regionRouting.api.riotgames.com/riot/account/v1/accounts/by-riot-id/$riotId/$riotTag";

    try {
        $client = new Client();
        $response = $client->request('GET', $urlPUUID, [
            'headers' => [
                'X-Riot-Token' => $apiKey
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        $PUUID = $data['puuid'];

    }  catch (RequestException $e) {
        if ($e->hasResponse()) {
            $statusCode = $e->getResponse()->getStatusCode();
            $errorBody = json_decode($e->getResponse()->getBody(), true);
    
            if ($statusCode === 404) {
                $errorMessage = "Aucun joueur trouvé avec cet ID et ce tag.";
            } elseif ($statusCode === 403 || $statusCode === 401) {
                $errorMessage = "Clé API invalide ou expirée.";
            } else {
                $errorMessage = "Erreur API : " . $errorBody['status']['message'];
            }
        } else {
            $errorMessage = "Erreur de connexion à l'API Riot.";
        }
    }
    

//Récupération des informations du compte via PUUID
    if ($PUUID) {
        $urlAccount = "https://$regionGame.api.riotgames.com/lol/summoner/v4/summoners/by-puuid/$PUUID";

        try {
            $response = $client->request('GET', $urlAccount, [
                'headers' => [
                    'X-Riot-Token' => $apiKey
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            $summonerLevel = $data['summonerLevel'];

        } catch (RequestException $e) {
            echo "<p>Erreur (Summoner) : " . $e->getMessage() . "</p>";
        }
    }

//Récupération du rang classé via PUUID
    if ($PUUID) {
        $urlRank = "https://$regionGame.api.riotgames.com/lol/league/v4/entries/by-puuid/$PUUID";

        try {
            $response = $client->request('GET', $urlRank, [
                'headers' => [
                    'X-Riot-Token' => $apiKey
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            if (!empty($data)) {
                $rank = $data[0]['tier'] . " " . $data[0]['rank'];
            } else {
                $rank = "Non classé";
            }

        } catch (RequestException $e) {
            echo "<p>Erreur (Rank) : " . $e->getMessage() . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Rang - League of Legends</title>
    <style>
                /* Style général */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Conteneur principal */
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
            text-align: center;
            box-sizing: border-box; 
        }

        /* Titre principal */
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Formulaire */
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        /* Champs de saisie */
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; 
        }

        /* Bouton */
        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%; 
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Résultats */
        .result {
            margin-top: 20px;
            background-color: #e9f7fc;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #b3d9ff;
        }

        .result h2 {
            font-size: 20px;
        }

        .result p {
            font-size: 16px;
        }

        .error {
            color: red;
        }
        .error-container {
        background-color: #ffe5e5;
        color: #cc0000;
        border: 1px solid #cc0000;
        padding: 15px;
        margin: 20px auto; /* auto pour centrer horizontalement */
        border-radius: 8px;
        width: fit-content;
        text-align: center;
        max-width: 90%;
        }


    </style>
</head>
<body>
    <div class="container">
        <h1>Rechercher le rang d'un compte LoL en europe</h1>
        <form method="GET">
        <!-- Formulaire -->
            <label for="riotId">Riot ID :</label>
            <input type="text" id="riotId" name="riotId" placeholder="Ex: Itzyako" required><br><br>

            <label for="riotTag">Tag :</label>
            <input type="text" id="riotTag" name="riotTag" placeholder="Ex: EUW" required><br><br>

            <button type="submit">Rechercher</button>
        </form>

        <?php if ($PUUID): ?>
            <!-- Affichage des résultats ou des erreurs -->
            <div class="result">
                <h2>Résultat pour <?= htmlspecialchars($_GET['riotId']) ?>#<?= htmlspecialchars($_GET['riotTag']) ?> :</h2>
                <p><strong>Niveau :</strong> <?= $summonerLevel ?></p>
                <p><strong>Rang classé :</strong> <?= $rank ?></p>
            </div>
        <?php elseif (isset($_GET['riotId']) && isset($_GET['riotTag'])): ?>
            <p class="error-container"><?= htmlspecialchars($errorMessage) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
