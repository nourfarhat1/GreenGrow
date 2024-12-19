<?php
require_once 'Config.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Config::getConnexion();
    }

    public function createUser($Username, $Prenom, $Nom, $E_mail, $Adresse, $Tel, $Mdp) {
        try {
            $sql = "INSERT INTO user (Username, Prenom, Nom, E_mail, Adresse, Tel, Mdp) VALUES (:Username, :Prenom, :Nom, :E_mail, :Adresse, :Tel, :Mdp)";
            $query = $this->db->prepare($sql);

            
           

            $query->execute([
                'Username'=>$Username,
                'Prenom' => $Prenom,
                'Nom' => $Nom,
                'E_mail' => $E_mail,
                'Adresse' =>$Adresse,
                'Tel' =>$Tel,
                'Mdp' =>$Mdp
            ]);
            return true; 
        } catch (Exception $e) {
            throw new Exception('Error while inserting: ' . $e->getMessage());
        }
    }

    public function getAllUsers() {
        try {
            $sql = "SELECT * FROM user";
            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(); 
        } catch (Exception $e) {
            throw new Exception('Error fetching users: ' . $e->getMessage());
        }
    }

    public function deleteUser($Username) {
        try {
            $sql = "DELETE FROM user WHERE Username = :Username";
            $query = $this->db->prepare($sql);
            $query->execute(['Username' => $Username]);
            return true; 
        } catch (Exception $e) {
            throw new Exception('Error deleting user: ' . $e->getMessage());
        }
    }
    

    public function updateUser($Username, $Nom, $Prenom, $E_mail, $Adresse, $Tel) {
        try {
            $sql = "UPDATE user SET Prenom = :Prenom, Nom = :Nom, E_mail= :E_mail, Adresse=:Adresse, Tel= :Tel  WHERE Username = :Username";
            $query = $this->db->prepare($sql);
            $query->execute([
                'Username'=> $Username,
                'Prenom' => $Prenom,
                'Nom' => $Nom,
                'E_mail' => $E_mail,
                'Adresse' => $Adresse,
                'Tel' =>$Tel,
               
            ]);
            return true; 
        } catch (Exception $e) {
            throw new Exception('Error updating user: ' . $e->getMessage());
        }
    }




    public function updateUser2($Username, $Nom, $Prenom, $E_mail, $Adresse, $Tel) {
        try {
            error_log('Username in session: ' . $_SESSION['user']['Username']);
            $sql = "UPDATE user SET Prenom = :Prenom, Nom = :Nom, E_mail= :E_mail, Adresse=:Adresse, Tel= :Tel  WHERE Username = :Username";
            $query = $this->db->prepare($sql);
            $query->execute([
                ':Username' => $_SESSION['user']['Username'],
                ':Prenom' => $Prenom,
                ':Nom' => $Nom,
                ':E_mail' => $E_mail,
                ':Adresse' => $Adresse,
                ':Tel' =>$Tel,
               
            ]);
            return true; 
        } catch (Exception $e) {
            throw new Exception('Error updating user: ' . $e->getMessage());
        }
    }



    public function updateUser3($Username, $typeU) {
        try {
            $sql = "UPDATE user SET user_type= :typeU  WHERE Username = :Username";
            $query = $this->db->prepare($sql);
            $query->execute([
                ':Username' => $Username,
                ':typeU' => $typeU
            ]);
            return true;
        } catch (Exception $e) {
            throw new Exception('Error updating user: ' . $e->getMessage());
        }
    }
    
    
    public function getUserByUsername($Username) {
        try {
            $sql = "SELECT * FROM user WHERE Username = :Username";
            $query = $this->db->prepare($sql);
            $query->execute(['Username' => $Username]);
            return $query->fetch(); 
        } catch (Exception $e) {
            throw new Exception('Error fetching user: ' . $e->getMessage());
        }
    }

    public function verifyUserPassword($Username, $Mdp) {
        try {
            
            $sql = "SELECT Mdp FROM user WHERE LOWER(Username) = LOWER(:Username)";

            $query = $this->db->prepare($sql);
            $query->execute(['Username' => $Username]);
    
           
            $result = $query->fetch();
            
            
    
            if ($result) {
              
                return $Mdp === $result['Mdp'];
            } else {
               
                return false;
            }
        } catch (Exception $e) {
            throw new Exception('Error verifying user password: ' . $e->getMessage());
        }
    }




    public function updatePassword($Username, $newPassword) {
        $stmt = $this->db->prepare("UPDATE user SET Mdp = :Mdp WHERE Username = :Username");
        return $stmt->execute(['Mdp' => $newPassword, 'Username' => $Username]);
    }


    public function addTask($taskDate, $taskName, $taskStatus) {
        $sql = "INSERT INTO task_history (task_date, task_name, task_status) VALUES (:task_date, :task_name, :task_status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':task_date', $taskDate);
        $stmt->bindParam(':task_name', $taskName);
        $stmt->bindParam(':task_status', $taskStatus);
        $stmt->execute();
    }

    public function getTasks() {
        $sql = "SELECT * FROM task_history ORDER BY task_date DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChartData() {
        try {
            // Fetch user data
            $sql = "SELECT COUNT(*) as count, MONTH(created_at) as month FROM user GROUP BY MONTH(created_at)";
            $query = $this->db->prepare($sql);
            $query->execute();
            $userData = $query->fetchAll();

           

            return [
                'userData' => $userData
                
            ];
        } catch (Exception $e) {
            throw new Exception('Error fetching chart data: ' . $e->getMessage());
        }
    }
}
?>



















    

    
    
    


