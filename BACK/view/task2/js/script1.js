

function deleteRow(type, id) {
    if (confirm(`Voulez-vous vraiment supprimer cet élément (${type}) avec l'ID ${id} ?`)) {
        // Envoie une requête à la page `delete.php` ou tout autre endpoint approprié
        fetch(`delete.php?type=${type}&id=${id}`, { method: 'GET' })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload(); // Recharge la page après suppression
            })
            .catch(error => console.error('Erreur:', error));
    }
}
