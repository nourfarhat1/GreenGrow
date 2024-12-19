function showFarmOptions() {
    document.getElementById('farmOptions').style.display = 'block';
    document.getElementById('zoneOptions').style.display = 'none';
}

function showZoneOptions() {
    document.getElementById('farmOptions').style.display = 'none';
    document.getElementById('zoneOptions').style.display = 'block';
}

function saveZone(zone) {
    const referenceZone = document.getElementById("referenceZone" + zone).value;
    const zoneName = document.getElementById("zoneName" + zone).value;
    const zoneType = document.getElementById("zoneType" + zone).value;
    const referenceFarm = document.getElementById("referenceFarm" + zone).value;

    // Here you can add the logic to save the zone details to the database
    console.log(`Zone ${zone} saved with details: Reference Zone: ${referenceZone}, Zone Name: ${zoneName}, Zone Type: ${zoneType}, Reference Farm: ${referenceFarm}`);
}

function validateForm() {
    let isValid = true;

    // Get all input elements
    const referenceZone = document.getElementById("reference_zone").value;
    const nom = document.getElementById("nom").value;
    const typeZone = document.getElementById("type_zone").value;
    const superficieZone = document.getElementById("superficie_zone").value;
    const culture = document.getElementById("culture").value;
    const referenceF = document.getElementById("reference_f").value;

    // Clear previous error messages
    document.getElementById("erreurReferenceZone").innerText = "";
    document.getElementById("erreurNom").innerText = "";
    document.getElementById("erreurTypeZone").innerText = "";
    document.getElementById("erreurSuperficieZone").innerText = "";
    document.getElementById("erreurCulture").innerText = "";
    document.getElementById("erreurReferenceF").innerText = "";

    // Validate each input
    if (referenceZone === "") {
        document.getElementById("erreurReferenceZone").innerText = "Référence de la zone est requise.";
        isValid = false;
    }
    if (nom === "") {
        document.getElementById("erreurNom").innerText = "Nom de la zone est requis.";
        isValid = false;
    }
    if (typeZone === "") {
        document.getElementById("erreurTypeZone").innerText = "Type de la zone est requis.";
        isValid = false;
    }
    if (superficieZone === "") {
        document.getElementById("erreurSuperficieZone").innerText = "Superficie de la zone est requise.";
        isValid = false;
    } else if (!Number.isInteger(Number(superficieZone))) {
        document.getElementById("erreurSuperficieZone").innerText = "Superficie de la zone doit être un entier.";
        isValid = false;
    }
    if (culture === "") {
        document.getElementById("erreurCulture").innerText = "Culture est requise.";
        isValid = false;
    }
    if (referenceF === "") {
        document.getElementById("erreurReferenceF").innerText = "Référence de la ferme est requise.";
        isValid = false;
    }

    return isValid;
}
