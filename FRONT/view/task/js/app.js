// Gestion de la commande et du message de confirmation
document.querySelectorAll('.checkOut').forEach(button => {
    button.addEventListener('click', () => {
        alert('Commande passée ! Merci de faire vos achats avec GREENGROW.');
    });
});

// Gestion de la fermeture du panier
document.querySelectorAll('.close').forEach(button => {
    button.addEventListener('click', () => {
        const cartTab = document.querySelector('.cartTab');
        if (cartTab) {
            cartTab.style.display = 'none';
        }
    });
});




// Fonction pour ajouter un produit au panier
document.querySelectorAll('.ajouter-panier').forEach(button => {
    button.addEventListener('click', function() {
        const produitId = this.getAttribute('data-id');
        const produitNom = this.getAttribute('data-nom');
        const produitPrix = parseFloat(this.getAttribute('data-prix'));
        
        // Ajouter le produit au panier (dans la page)
        const panierList = document.getElementById('panier-list');
        const totalElement = document.getElementById('total');
        
        if (panierList && totalElement) {
            // Créer un élément de liste pour le produit ajouté
            const panierItem = document.createElement('li');
            panierItem.textContent = `${produitNom} - ${produitPrix.toFixed(2)}€`;
    
            // Ajouter l'élément au panier
            panierList.appendChild(panierItem);
    
            // Mettre à jour le total du panier
            let total = parseFloat(totalElement.textContent.replace('€', '').trim()) || 0; // Si le total est vide, initialiser à 0
            total += produitPrix;
            totalElement.textContent = `${total.toFixed(2)}€`;
        }
    });
});
