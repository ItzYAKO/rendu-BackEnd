<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte de base - League of Legends</title>
    <style>
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
        .search-container {
            margin-top: 20px;
        }
        .search-container input {
            padding: 10px;
            width: 80%;
            max-width: 400px;
            font-size: 16px;
            border: 2px solid #444;
            border-radius: 5px;
            background: #333;
            color: white;
        }

        /* Main content */
        .main-content {
            flex-grow: 1; /* Permet au contenu de prendre tout l'espace disponible */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .champion-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
            padding: 20px;
            flex-shrink: 0; /* Empêche le rétrécissement */
            overflow: auto; /* Permet à la section de défiler si le contenu dépasse */
        }

        .champion {
            max-width: 300px;
            border: 2px solid #444;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .champion:hover {
            transform: scale(1.05);
        }
        .champion img {
            width: 100%;
            display: block;
        }
        .champion-name {
            padding: 10px;
            background: #222;
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

    <!-- Header -->
    <header>
        <h1>Carte de base de League of Legends</h1>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Rechercher un champion..." oninput="filterChampions()">
        </div>
    </header>

    <!-- Main content container -->
    <div class="main-content">
        <!-- Champion Container -->
        <div class="champion-container" id="championContainer"></div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 - Tous droits réservés</p>
        <p>Projet créé par Adrien Hersant</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
