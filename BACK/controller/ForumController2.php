<?php

require_once 'C:\xamppp\htdocs\GreenGrow\BACK\config\config.php'; // Vérifiez le chemin du fichier database.php
require_once '../model/ForumModel.php'; // Vérifiez également le chemin du ForumModel.php

class ForumController2 {
    private $forumModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->forumModel = new ForumModel($db);
    }

    // Créer une réponse
    public function createReponse() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['codeF'])) {
            if (isset($_POST['reponse'], $_POST['username'])) {
                $ID_rep = uniqid();
                $codeF = $_POST['codeF'];
                $reponse = htmlspecialchars($_POST['reponse']);
                $date_rep = date("Y-m-d");
                $heure_rep = date("H:i:s");
                $nom_utilisateur = htmlspecialchars($_POST['username']);

                $result = $this->forumModel->createReponse($ID_rep, $codeF, $reponse, $date_rep, $heure_rep, $nom_utilisateur);
                if ($result) {
                    header("Location: C:\xamppp\htdocs\GreenGrow\BACK\view\task2\template\createm.php?codeF=" . urlencode($codeF));
                    exit;
                } else {
                    echo "Erreur lors de l'ajout de la réponse.";
                }
            } else {
                echo "Veuillez fournir une réponse valide.";
            }
        }
    }

    // Lire toutes les réponses pour une question
    public function readReponses($codeF) {
        $reponses = $this->forumModel->getReponsesByQuestion($codeF);
        include 'C:\xamppp\htdocs\GreenGrow\BACK\view\task2\template\createm.php';
    }

    // Supprimer une réponse
    public function deleteReponse() {
        if (isset($_GET['ID_rep'])) {
            $ID_rep = $_GET['ID_rep'];
            $result = $this->forumModel->deleteReponse($ID_rep);
            if ($result) {
                header("Location: C:\xamppp\htdocs\GreenGrow\BACK\view\task2\template\createm.php");
                exit;
            } else {
                echo "Erreur lors de la suppression de la réponse.";
            }
        }
    }

    // Mettre à jour une réponse
    public function updateReponse() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ID_rep'])) {
            if (isset($_POST['reponse'])) {
                $ID_rep = $_POST['ID_rep'];
                $reponse = htmlspecialchars($_POST['reponse']);

                $result = $this->forumModel->updateReponse($ID_rep, $reponse);
                if ($result) {
                    header("Location: C:\xamppp\htdocs\GreenGrow\BACK\view\task2\template\createm.php?ID_rep=" . urlencode($ID_rep));
                    exit;
                } else {
                    echo "Erreur lors de la mise à jour de la réponse.";
                }
            } else {
                echo "Veuillez fournir une réponse valide.";
            }
        } else {
            echo "Données invalides pour la mise à jour.";
        }
    }
}

?>
