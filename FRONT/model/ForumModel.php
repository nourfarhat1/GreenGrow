<?php

class ForumModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Créer une question
    public function createQuestion($codeF, $question, $date_f, $heure_f, $nom_utilisateur) {
        $sql = "INSERT INTO forum (codeF, question, date_f, heure_f, nom_utilisateur) VALUES (:codeF, :question, :date_f, :heure_f, :nom_utilisateur)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'codeF' => $codeF,
            'question' => $question,
            'date_f' => $date_f,
            'heure_f' => $heure_f,
            'nom_utilisateur' => $nom_utilisateur
        ]);
    }

    // Lire toutes les questions
    public function getAllQuestions() {
        $sql = "SELECT * FROM forum";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprimer une question
    public function deleteQuestion($codeF) {
        $sql = "DELETE FROM forum WHERE codeF = :codeF";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['codeF' => $codeF]);
    }

    // Mettre à jour une question
    public function updateQuestion($codeF, $question) {
        $sql = "UPDATE forum SET question = :question WHERE codeF = :codeF";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'question' => $question,
            'codeF' => $codeF
        ]);
    }

    // Récupérer une question par son ID
    public function getQuestionById($codeF) {
        $sql = "SELECT * FROM forum WHERE codeF = :codeF";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['codeF' => $codeF]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer une réponse
    public function createReponse($ID_rep, $codeF, $reponse, $date_rep, $heure_rep, $nom_utilisateur) {
        $sql = "INSERT INTO message (ID_rep, codeF, reponse, date_rep, heure_rep, nom_utilisateur) VALUES (:ID_rep, :codeF, :reponse, :date_rep, :heure_rep, :nom_utilisateur)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'ID_rep' => $ID_rep,
            'codeF' => $codeF,
            'reponse' => $reponse,
            'date_rep' => $date_rep,
            'heure_rep' => $heure_rep,
            'nom_utilisateur' => $nom_utilisateur
        ]);
    }

    // Lire toutes les réponses pour une question spécifique
    public function getReponsesByQuestion($codeF) {
        $sql = "SELECT * FROM message WHERE codeF = :codeF";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['codeF' => $codeF]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprimer une réponse
    public function deleteReponse($ID_rep) {
        $sql = "DELETE FROM message WHERE ID_rep = :ID_rep";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['ID_rep' => $ID_rep]);
    }

    // Mettre à jour une réponse
    public function updateReponse($ID_rep, $reponse) {
        $sql = "UPDATE message SET reponse = :reponse WHERE ID_rep = :ID_rep";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'reponse' => $reponse,
            'ID_rep' => $ID_rep
        ]);
    }

    // Récupérer une réponse par son ID
    public function getReponseById($ID_rep) {
        $sql = "SELECT * FROM message WHERE ID_rep = :ID_rep";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['ID_rep' => $ID_rep]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
