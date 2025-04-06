// Bloc d'attente pour le chargement complet du DOM
document.addEventListener('DOMContentLoaded', function() {
    
    // Récupère le conteneur des skins où les éléments seront ajoutés
    const skinsContainer = document.getElementById('skinsContainer');
    
    // Récupère le nom du champion depuis la variable PHP (championName)
    const championName = window.championName;

    // Vérifie si un nom de champion est passé depuis le PHP
    if (championName) {
        // Étape 1 : Récupérer les données du champion via l'API Riot
        const url = `https://ddragon.leagueoflegends.com/cdn/15.7.1/data/fr_FR/champion/${championName}.json`;

        fetch(url) // Effectue une requête fetch pour obtenir les informations
            .then(response => response.json()) // Parse la réponse JSON
            .then(data => {
                // Accède aux données spécifiques du champion
                const champion = data.data[championName]; 

                // Si des skins sont disponibles pour ce champion, on les affiche
                if (champion && champion.skins) {
                    displaySkins(champion.skins); // Appel à la fonction d'affichage des skins
                } else {
                    skinsContainer.innerHTML = '<p>Aucun skin disponible pour ce champion.</p>'; // Si aucun skin, message d'erreur
                }
            })
            .catch(error => {
                console.error('Erreur de récupération des données :', error);
                skinsContainer.innerHTML = '<p>Une erreur est survenue lors de la récupération des skins.</p>'; // Affichage en cas d'erreur
            });
    } else {
        skinsContainer.innerHTML = '<p>Le nom du champion est manquant.</p>'; // Si championName n'existe pas
    }

    // Fonction pour afficher les skins du champion
    function displaySkins(skins) {
        if (skins && skins.length > 0) {
            skinsContainer.innerHTML = ''; // Réinitialise le contenu du conteneur pour éviter les doublons
            skins.forEach(skin => {
                // Crée un div pour chaque skin
                const skinDiv = document.createElement('div');
                skinDiv.className = 'skin';
                
                // Ajoute un titre et une image pour chaque skin
                skinDiv.innerHTML = `
                    <h3>${skin.name === "default" ? championName : skin.name}</h3>
                    <img src="https://ddragon.leagueoflegends.com/cdn/img/champion/splash/${championName}_${skin.num}.jpg" alt="${skin.name}">
                `;
                
                // Ajoute le div du skin au conteneur
                skinsContainer.appendChild(skinDiv);
            });
        } else {
            skinsContainer.innerHTML = '<p>Aucun skin disponible pour ce champion.</p>'; // Si aucun skin disponible
        }
    }
});
