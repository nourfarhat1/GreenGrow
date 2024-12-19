const apiKey = "67492c1c8c12188faab5583c543f7e8a";
const lat = 36.8665;
const lon = 10.1647;

// Descriptions de l'indice de qualité de l'air (AQI)
const aqiDescriptions = [
    "Bonne",
    "Acceptable",
    "Modérée",
    "Dégradée",
    "Mauvaise",
    "Très mauvaise"
];

// Conseils agricoles basés sur l'AQI
const agriculturalRisks = [
    "Conditions idéales pour l'agriculture.",
    "Peu d'impact, mais surveillez les besoins en eau.",
    "Légère réduction de la photosynthèse. Irriguer modérément.",
    "Stress pour les cultures. Augmentez l'irrigation.",
    "Risques élevés de dommages aux cultures. Prévoir une irrigation abondante.",
    "Conditions extrêmes : protégez vos cultures."
];

/**
 * Fonction pour récupérer les données de qualité de l'air depuis l'API OpenWeather
 */
async function fetchPollutionData() {
    const url = `https://api.openweathermap.org/data/2.5/air_pollution?lat=${lat}&lon=${lon}&appid=${apiKey}`;
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Erreur API : ${response.status} ${response.statusText}`);
        }
        const data = await response.json();
        displayData(data);
    } catch (error) {
        console.error("Erreur lors de la récupération des données :", error);
        document.getElementById("city").innerText = "Erreur de chargement des données.";
        document.getElementById("advice").innerText = "Impossible de fournir des recommandations pour le moment.";
    }
}

/**
 * Calcul de l'indice IQA+ personnalisé
 * @param {number} aqi - Indice de qualité de l'air
 * @param {number} pm25 - Niveau de PM2.5 en µg/m³
 * @returns {string} - IQA+ calculé
 */
function calculateIQAPlus(aqi, pm25) {
    return ((aqi * 0.7) + (pm25 / 10 * 0.3)).toFixed(1);
}

/**
 * Affichage des données de qualité de l'air dans le DOM
 * @param {Object} data - Données de l'API OpenWeather
 */
function displayData(data) {
    const aqi = data.list[0].main.aqi;
    const pm25 = data.list[0].components.pm2_5.toFixed(1);
    const iqaplus = calculateIQAPlus(aqi, pm25);

    document.getElementById("city").innerText = "Qualité de l'air à Ariana aujourd'hui";
    document.getElementById("aqi").innerText = aqi;
    document.getElementById("description").innerText = aqiDescriptions[aqi - 1];
    document.getElementById("health").innerText = `PM₂₅ : ${pm25} µg/m³`;
    document.getElementById("iqaplus").innerText = iqaplus;
    document.getElementById("advice").innerText = agriculturalRisks[aqi - 1];

    // Met à jour la position de l'indicateur sur la barre de progression
    const pointer = document.getElementById("pointer");
    pointer.style.left = `${(aqi - 1) * 20}%`;
}

// Appel de la fonction pour récupérer et afficher les données
fetchPollutionData();
