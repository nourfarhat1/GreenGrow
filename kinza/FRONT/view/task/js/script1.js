const apiKey = '67492c1c8c12188faab5583c543f7e8a';  // Remplacer par votre clé API
const city = 'Tunis';  // Ville pour les données météo

// Fonction pour obtenir les données météo
async function getWeatherData() {
    try {
        const currentWeatherResponse = await fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric&lang=fr`);
        const currentWeatherData = await currentWeatherResponse.json();
        displayCurrentWeather(currentWeatherData);

        const forecastResponse = await fetch(`https://api.openweathermap.org/data/2.5/forecast?q=${city}&appid=${apiKey}&units=metric&lang=fr`);
        const forecastData = await forecastResponse.json();
        displayForecast(forecastData);
    } catch (error) {
        console.error('Erreur lors de la récupération des données météo:', error);
    }
}

// Afficher la météo actuelle
function displayCurrentWeather(data) {
    const currentWeatherDiv = document.getElementById('current-weather-info');
    currentWeatherDiv.innerHTML = `
        <p><img src="icon/temp-icon.png" alt="Temp Icon"> Température: ${data.main.temp}°C</p>
        <p><img src="icon/condition-icon.png" alt="Condition Icon"> Conditions: ${data.weather[0].description}</p>
        <p><img src="icon/humidity-icon.png" alt="Humidity Icon"> Humidité: ${data.main.humidity}%</p>
    `;
}

// Afficher la prévision sur 7 jours
function displayForecast(data) {
    const forecastDiv = document.getElementById('forecast');
    forecastDiv.innerHTML = '';  // Réinitialiser le contenu

    data.list.forEach((forecast, index) => {
        if (index % 8 === 0) {  // Pour les prévisions quotidiennes (tous les 8 points de données)
            const date = new Date(forecast.dt * 1000);
            const dayOfWeek = date.toLocaleDateString('fr-FR', { weekday: 'long' });
            const dayOfMonth = date.getDate();
            const month = date.toLocaleDateString('fr-FR', { month: 'long' });
            const icon = `https://openweathermap.org/img/wn/${forecast.weather[0].icon}.png`;

            // Température min/max
            const tempMin = forecast.main.temp_min;
            const tempMax = forecast.main.temp_max;

            // Détails de la pluie
            const rainPercentage = forecast.rain ? forecast.rain["3h"] : 0;
            const rainText = rainPercentage > 0 ? `${rainPercentage * 10}%` : "Pas de pluie prévue";

            // Détails du vent
            const windSpeed = forecast.wind.speed;
            const windDirection = forecast.wind.deg;
            const windDirectionText = getWindDirection(windDirection);

            forecastDiv.innerHTML += `
                <div class="forecast-card">
                    <p><strong>${dayOfWeek}, ${dayOfMonth} ${month}</strong></p>
                    
                    <div class="details">
                        <p><img src="icon/condition-icon.png" alt="Condition Icon"> ${forecast.weather[0].description}</p>
                        <p><img src="icon/temp-icon.png" alt="Temp Icon"> Max ${tempMax}° / Min ${tempMin}°</p>
                        <p><img src="icon/humidity-icon.png" alt="Humidity Icon"> Humidité: ${forecast.main.humidity}%</p>
                        <p><img src="icon/rain-icon.png" alt="Rain Icon"> Pluie: ${rainText}</p>
                        <p><img src="icon/wind-icon.png" alt="Wind Icon"> Vent: ${windSpeed} km/h, ${windDirectionText}</p>
                    </div>
                </div>
            `;
        }
    });
}

// Convertir les degrés de direction du vent en texte
function getWindDirection(degrees) {
    const directions = ['Nord', 'Nord-Est', 'Est', 'Sud-Est', 'Sud', 'Sud-Ouest', 'Ouest', 'Nord-Ouest'];
    const index = Math.floor((degrees + 22.5) / 45);
    return directions[index % 8];
}

// Fonction d'initialisation de la carte
function initMap() {
    const map = L.map('map').setView([33.8869, 9.5375], 6);  // Coordonnées de la Tunisie

    // Ajouter un fond de carte (OpenStreetMap ici)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Marqueurs pour différentes villes
    const cities = [
    { name: "Tunis", lat: 36.8065, lon: 10.1815 },
    { name: "Sfax", lat: 34.7396, lon: 10.7603 },
    { name: "Gabès", lat: 33.8815, lon: 10.0982 },
    { name: "Bizerte", lat: 37.2744, lon: 9.8739 },
    { name: "Sousse", lat: 35.8256, lon: 10.6360 },
    { name: "Kairouan", lat: 35.6781, lon: 10.0963 },
    { name: "Tozeur", lat: 33.9197, lon: 8.1335 },
    { name: "Douz", lat: 33.4669, lon: 9.0167 },
    { name: "Gafsa", lat: 34.4250, lon: 8.7842 },
    { name: "Monastir", lat: 35.7770, lon: 10.8262 },
    { name: "Nabeul", lat: 36.4561, lon: 10.7375 },
    { name: "Mahdia", lat: 35.5047, lon: 11.0622 },
    { name: "Kasserine", lat: 35.1676, lon: 8.8365 },
    { name: "Jendouba", lat: 36.5049, lon: 8.7802 },
    { name: "Kebili", lat: 33.7044, lon: 8.9733 },
    { name: "El Kef", lat: 36.1742, lon: 8.7049 },
    { name: "Zarzis", lat: 33.5030, lon: 11.1122 },
    { name: "Djerba", lat: 33.8076, lon: 10.8492 },
    { name: "Beja", lat: 36.7256, lon: 9.1817 },
    { name: "Siliana", lat: 36.0844, lon: 9.3708 }
    ];

    cities.forEach(city => {
        fetchWeatherDataForCity(city.name, city.lat, city.lon, map);
    });

    // Cercle de température sur la carte
    displayTemperatureCircle(map);
}

// Afficher les données météo pour chaque ville
async function fetchWeatherDataForCity(cityName, lat, lon, map) {
    try {
        const weatherResponse = await fetch(`https://api.openweathermap.org/data/2.5/weather?q=${cityName}&appid=${apiKey}&units=metric&lang=fr`);
        const weatherData = await weatherResponse.json();
        
        const temp = weatherData.main.temp;
        const iconCode = weatherData.weather[0].icon;
        const iconUrl = `https://openweathermap.org/img/wn/${iconCode}.png`;

        // Ajouter un marqueur avec les données de la ville
        const marker = L.marker([lat, lon]).addTo(map);
        marker.bindPopup(`
            <b>${cityName}</b><br>
            Température: ${temp}°C<br>
            Conditions: ${weatherData.weather[0].description}<br>
            <img src="${iconUrl}" alt="${weatherData.weather[0].description}">
        `).openPopup();
    } catch (error) {
        console.error('Erreur lors de la récupération des données météo pour la ville:', error);
    }
}

// Afficher un cercle de température
function displayTemperatureCircle(map) {
    // Définir une valeur de température pour exemple (par exemple, la température de Tunis)
    const temperature = 25;  // Température de Tunis (exemple)

    const color = getTemperatureColor(temperature);  // Définir la couleur en fonction de la température

    L.circle([36.8065, 10.1815], {
        color: color,
        fillColor: color,
        fillOpacity: 0.5,
        radius: 50000  // Rayon du cercle (en mètres)
    }).addTo(map).bindPopup(`Température: ${temperature}°C`);
}

// Fonction pour obtenir la couleur en fonction de la température
function getTemperatureColor(temp) {
    if (temp <= 10) return '#0000FF';  // Bleu pour froid
    if (temp <= 20) return '#00FF00';  // Vert pour tempéré
    return '#FF0000';  // Rouge pour chaud
}

// Appeler la fonction d'initialisation de la carte
initMap();

// Appeler la fonction pour récupérer les données météo
getWeatherData();
