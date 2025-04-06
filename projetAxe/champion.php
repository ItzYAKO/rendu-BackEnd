<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Champion - League of Legends</title>
    <style>
        /* Mise en page globale */
        body {
            font-family: Arial, sans-serif;
            background: #111;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Garantit que la page prend au moins toute la hauteur de l'écran */
        }

        /* Header */
        header {
            background: #222;
            padding: 20px;
            text-align: center;
        }
        header h1 {
            margin: 0;
            font-size: 2rem;
        }

        /* Conteneur principal */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        /* Conteneur des skins */
        #skinsContainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
            padding: 20px;
        }

        /* Style pour chaque skin */
        .skin {
            max-width: 300px;
            border: 2px solid #444;
            border-radius: 10px;
            overflow: hidden;
            background-color: #222;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .skin:hover {
            transform: scale(1.05);
        }
        .skin h3 {
            padding: 10px;
            background: #333;
            margin: 0;
            font-size: 1.2rem;
        }
        .skin img {
            width: 100%;
            display: block;
        }

        /* Footer */
        footer {
            background: #222;
            color: #888;
            padding: 20px;
            text-align: center;
        }
        footer p {
            margin: 0;
        }
    </style>
</head>
<body>

    <?php
        // Récupérer le nom du champion depuis l'URL (paramètre 'champion')
        $championName = isset($_GET['champion']) ? $_GET['champion'] : null;
    ?>

    <!-- Header -->
    <header>
    <h1>Carte skins de <?php echo $championName; ?></h1>
    <div style="margin-top: 15px;">
        <a href="index.php" style="text-decoration: none;">
            <button style="
                padding: 10px 20px;
                font-size: 16px;
                background-color: #444;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            " onmouseover="this.style.backgroundColor='#666'" onmouseout="this.style.backgroundColor='#444'">
                Retour à l'accueil
            </button>
        </a>
    </div>
    </header>

    <!-- Contenu principal -->
    <div class="main-content">
        <!-- Conteneur des skins -->
        <div id="skinsContainer"></div> <!-- Conteneur pour afficher les skins -->
    </div>

    <footer>
        <p>&copy; 2025 - Tous droits réservés</p>
        <p>Projet créé par Adrien Hersant</p>
    </footer>

    <script>
        // Passer la variable PHP au JavaScript
        window.championName = "<?php echo $championName; ?>";
    </script>
    
    <script src="champion.js"></script>
</body>
</html>
