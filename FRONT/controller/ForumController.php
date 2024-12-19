<?php

require_once '../config/database.php'; // Vérifiez le chemin du fichier database.php
require_once '../model/ForumModel.php'; // Vérifiez également le chemin du ForumModel.php

class ForumController {
    private $forumModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->forumModel = new ForumModel($db);
    }

    // Créer une question
    public function createQuestion() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST['message'], $_POST['username'])) {
                $codeF = uniqid();
                $question = htmlspecialchars($_POST['message']);
                $date_f = date("Y-m-d");
                $heure_f = date("H:i:s");
                $nom_utilisateur = htmlspecialchars($_POST['username']);

                $result = $this->forumModel->createQuestion($codeF, $question, $date_f, $heure_f, $nom_utilisateur);
                if ($result) {
                    header("Location: ../view/task/createclient.php");
                    exit;
                } else {
                    echo "Erreur lors de l'ajout de la question.";
                }
            } else {
                echo "Veuillez remplir tous les champs.";
            }
        }
    }

    // Lire toutes les questions
    public function readAllQuestions() {
        $questions = $this->forumModel->getAllQuestions();
        include '../view/task/createclient.php';
    }

    // Supprimer une question
    public function deleteQuestion() {
        if (isset($_GET['codeF'])) {
            $codeF = $_GET['codeF'];
            $result = $this->forumModel->deleteQuestion($codeF);
            if ($result) {
                header("Location: ../view/task/delete.php");
                exit;
            } else {
                echo "Erreur lors de la suppression de la question.";
            }
        }
    }

    // Mettre à jour une question
    public function updateQuestion() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['codeF'])) {
            if (isset($_POST['question'])) {
                $codeF = $_POST['codeF'];
                $question = htmlspecialchars($_POST['question']);

                $result = $this->forumModel->updateQuestion($codeF, $question);
                if ($result) {
                    header("Location: ../view/task/update.php?codeF=" . urlencode($codeF));
                    exit;
                } else {
                    echo "Erreur lors de la mise à jour de la question.";
                }
            } else {
                echo "Veuillez fournir une question valide.";
            }
        } else {
            echo "Données invalides pour la mise à jour.";
        }
    }

}