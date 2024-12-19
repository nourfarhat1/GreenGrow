<?php
class ProduitView {
    public function render($produits) {
        echo '<div class="row">';
        foreach ($produits as $produit) {
            echo '
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="' . $produit['image_path'] . '" class="card-img-top" alt="' . htmlspecialchars($produit['image_name']) . '">
                        <div class="card-body">
                            <h5 class="card-title">' . htmlspecialchars($produit['nom_prod']) . '</h5>
                            <p class="card-text">Référence: ' . htmlspecialchars($produit['reference']) . '</p> <!-- Added reference -->
                            <p class="card-text">Type: ' . htmlspecialchars($produit['type_prod']) . '</p>
                            <p class="card-text">Fabricant: ' . htmlspecialchars($produit['fabricant']) . '</p>
                            <p class="card-text">Prix: ' . number_format($produit['prix'], 2) . ' TND</p>
                            <p class="card-text">Likes: ' . $produit['likes'] . '</p>
                            <p class="card-text">Dislikes: ' . $produit['dislikes'] . '</p>
                        </div>
                    </div>
                </div>
            ';
        }
        echo '</div>';
    }
}
?>
