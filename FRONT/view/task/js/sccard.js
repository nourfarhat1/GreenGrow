const apiKey = "d16324440d01f5e972aea9de07c50ab1";
        const lat = 36.8665;
        const lon = 10.1647;

        const aqiDescriptions = [
            "Bonne",
            "Acceptable",
            "Modérée",
            "Dégradée",
            "Mauvaise",
            "Très mauvaise"
        ];

        const agriculturalRisks = [
            "Conditions idéales pour l'agriculture.",
            "Peu d'impact, mais surveillez les besoins en eau.",
            "Légère réduction de la photosynthèse. Irriguer modérément.",
            "Stress pour les cultures. Augmentez l'irrigation.",
            "Risques élevés de dommages aux cultures. Prévoir une irrigation abondante.",
            "Conditions extrêmes : protégez vos cultures."
        ];

        async function fetchPollutionData() {
            try {
                const response = await fetch(`http://api.openweathermap.org/data/2.5/air_pollution?lat=${lat}&lon=${lon}&appid=${apiKey}`);
                const data = await response.json();
                displayData(data);
            } catch (error) {
                console.error("Erreur lors de la récupération des données :", error);
            }
        }

        function calculateIQAPlus(aqi, pm25) {
            return ((aqi * 0.7) + (pm25 / 10 * 0.3)).toFixed(1);
        }

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

            const pointer = document.getElementById("pointer");
            pointer.style.left = `${(aqi - 1) * 25}%`;
        }

        fetchPollutionData();