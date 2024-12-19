document.getElementById("irrigationForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const lieu = document.getElementById("lieu").value;
    const superficie = document.getElementById("superficie").value;
    const typeDeSol = document.getElementById("type_de_sol").value;
    const typeDeCulture = document.getElementById("type_de_culture").value;

    // Validation des champs
    if (!lieu || !superficie || !typeDeSol || !typeDeCulture) {
        alert("Tous les champs doivent être remplis.");
        return;
    }

    if (superficie <= 0) {
        alert("La superficie doit être un nombre positif.");
        return;
    }

    // OpenWeather API Key and URL
    const apiKey = "67492c1c8c12188faab5583c543f7e8a";
    const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${lieu}&appid=${apiKey}&units=metric`;

    // Fetch weather data
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            // Validation si les données météo sont récupérées correctement
            if (!data || !data.main || !data.wind) {
                alert("Impossible de récupérer les données météo pour ce lieu.");
                return;
            }

            // Extract weather data
            const temperature = data.main.temp;
            const vent = data.wind.speed;
            const humidite = data.main.humidity;
            const precipitation = data.rain ? data.rain["1h"] || 0 : 0;

            // Calculate irrigation water quantity
            const quantiteEau = calculateWaterNeeds(superficie, typeDeSol, typeDeCulture, temperature, humidite, precipitation);

            // Update UI
            document.getElementById("temperature").textContent = temperature.toFixed(1);
            document.getElementById("vent").textContent = vent.toFixed(1);
            document.getElementById("humidite").textContent = humidite.toFixed(1);
            document.getElementById("precipitations").textContent = precipitation.toFixed(1);
            document.getElementById("quantiteEau").textContent = quantiteEau.toFixed(1);

            // Show results
            document.getElementById("weatherResult").style.display = "block";
            fetch("/FRONT/view/IrrigationView.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams({
                    lieu,
                    type_de_sol: typeDeSol,
                    type_de_culture: typeDeCulture,
                    superficie,
                    quantite_eau: quantiteEau,
                    temperature,
                    vent,
                    humidite,
                    precipitation
                }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Données enregistrées avec succès !");
                    } else {
                        alert("Échec de l'enregistrement des données.");
                    }
                })
                .catch(error => console.error("Erreur :", error));
            
            
            
        })
        .catch(error => {
            console.error("Erreur lors de la récupération des données météo:", error);
            alert("Impossible de récupérer les données météo. Veuillez vérifier le lieu ou réessayer plus tard.");
        });
});

// Function to calculate irrigation water needs
function calculateWaterNeeds(superficie, typeDeSol, typeDeCulture, temperature, humidite, precipitation) {
    // Simple formula for demonstration purposes
    const baseNeed = 5; // Base water need in liters per m²
    const soilFactor = typeDeSol === "Sablonneux" ? 1.2 : typeDeSol === "Argileux" ? 0.8 : 1;
    const cropFactor = typeDeCulture === "Blé" ? 1.1 : typeDeCulture === "Tomates" ? 1.5 : 1;
    const climateFactor = temperature > 30 ? 1.2 : temperature < 15 ? 0.8 : 1;

    const irrigationNeed = baseNeed * soilFactor * cropFactor * climateFactor - precipitation;
    return Math.max(irrigationNeed * superficie, 0); // Ensure no negative value
}

