<?php
require_once 'model/user.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function createUser($requestData) {
        $Username = $requestData['Username'] ?? '';
        $Prenom = $requestData['prenom'] ?? '';
        $Nom = $requestData['nom'] ?? '';
        $E_mail = $requestData['email'] ?? '';
        $Adresse = $requestData['Adresse'] ?? '';
        $Tel = $requestData['Tel'] ?? '';
        $Mdp = $requestData['Mdp'] ?? '';

       
        $errorMessageUsername = $errorMessageEmail = $errorMessagePhone = $errorMessageAdresse = $errorMessageNom = $errorMessagePrenom= $errorMessageMdp = '';

        try {
           
            if (!empty($Username)) {
                $existingUser = $this->userModel->getUserByUsername($Username);
                if ($existingUser) {
                    $errorMessageUsername = "The username '$Username' already exists. Please choose another one.";
                }
            }

       
            if (!filter_var($E_mail, FILTER_VALIDATE_EMAIL)) {
                $errorMessageEmail = "Invalid email address.";
            }

           
            if (empty($Tel)) {
                $errorMessagePhone = "Phone number is required.";
            }

           
            if (empty($Adresse)) {
                $errorMessageAdresse = "Address is required.";
            }

         
            if (empty($Nom)) {
                $errorMessageNom = "Nom is required.";
            }

            if (empty($Prenom)) {
                $errorMessagePrenom = "Prenom is required.";
            }
            if (empty($Mdp)) {
                if(strlen($Mdp) < 8){$errorMessage = "Password must be at least 8 characters long.";}
                $errorMessageMdp = "Password is required.";
            }

           
            if (!empty($errorMessagePrenom) || !empty($errorMessageEmail) || !empty($errorMessagePhone) || !empty($errorMessageNom) || !empty($errorMessageAdresse) || !empty($errorMessageUsername)|| !empty($errorMessageMdp)) {
                
                require 'view/form.php';
                return;
            }

            $this->userModel->createUser($Username, $Prenom, $Nom, $E_mail, $Adresse, $Tel, $Mdp);

            header('Location: view/success.php');
            exit();

        } catch (Exception $e) {
          
            $errorMessage = "An error occurred while creating the user. Please try again.";
            require 'view/form.php';  
        }
    }
    
    


    public function showAllUsers() {
        try {
            $users=$this->userModel->getAllUsers();
           
            require 'view/userList.php'; 
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function showAllUsers2() {
        try {
            $users=$this->userModel->getAllUsers();
           
            require 'view/liste-basic.php';
            
           
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteUser($Username) {
        try {
            if ($this->userModel->deleteUser($Username)) {
                header('Location: index.php?action=showUsers2'); 
                exit;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function updateUser($Username, $Prenom, $Nom, $E_mail, $Adresse, $Tel) {
        try {
            if ($this->userModel->updateUser($Username, $Prenom, $Nom, $E_mail, $Adresse, $Tel)) {
                header('Location: index.php?action=showUsers2');
                exit;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function updateUser2($Username, $Prenom, $Nom, $E_mail, $Adresse, $Tel) {
        try {
            if ($this->userModel->updateUser2($Username, $Prenom, $Nom, $E_mail, $Adresse, $Tel)) {
                header('Location: /BACK/index.php');
                exit;
            } else {
                echo "Failed to update user.";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    
    
    

    
    
    
    
    public function editUser($Username) {
        $user = $this->userModel->getUserByUsername($Username);
        if ($user) {
            require 'view/editUser.php';
        } else {
            echo "User not found.";
        }
    }
    public function editUser2($Username, $type) {
        $this->userModel->updateUser3($Username, $type);
        header('Location: /BACK/index.php');
        exit; // Ensure the script stops after the redirect
    }
    


    public function verifyUser($Username, $Mdp) {
        try {
         
            $user = $this->userModel->getUserByUsername($Username);
    
            if (!$user) {
              
                $errorMessage = "Username incorrecte.";
                require 'view/page-signin.php';
                return; 
            }
    
            if (!$this->userModel->verifyUserPassword($Username, $Mdp)) {
                $errorMessage = "Mot de passe incorrecte.";
                require 'view/page-signin.php';
                return;
            }
    
       
            session_start();
            $_SESSION['user'] = $user; 
            $_SESSION['loggedIn'] = true;
    
            header('Location: /BACK/index.php');
            exit();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function verifyUser2($Username) {
        
        try {
            session_start();
            $user = $this->userModel->getUserByUsername($Username);
    
            if (!$user) {
              
                $errorMessage = "Username incorrecte.";
                require 'view/password_reset.php';
                return; 
            }
            else{$_SESSION['user'] = $user;
                header('Location: view/sending.php');
                 exit();}

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    public function ModifierMdp($Username, $newPassword, $confirmPassword) {
      
        
        if ($newPassword !== $confirmPassword) {
            $errorMessage = "New password and confirmation do not match.";
            require 'C:\xampp\htdocs\BACK\view\reset_p.php'; 
            return;
        }

        if (strlen($newPassword) < 8) {
            $errorMessage = "Password must be at least 8 characters long.";
            require 'C:\xampp\htdocs\BACK\view\reset_p.php'; 
            return;
        }
        if ($this->userModel->updatePassword($Username, $newPassword)) {
            $successMessage = "Password updated successfully.";
            require 'view/success_mdp.html';
        } else {
            $errorMessage = "Failed to update password. Please try again.";
            require 'view/password_reset.php'; 
        }


    }

    public function AjoutTache() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskDate = $_POST['task_date'] ?? null;
            $taskName = $_POST['task_name'] ?? null;
            $taskStatus = $_POST['task_status'] ?? null;
    
            if (!$taskDate || !$taskName || !$taskStatus) {
                $errorMessage = "All fields are required.";
                require 'view/taskForm.php';
                return;
            }
    
            try {
                $this->userModel->addTask($taskDate, $taskName, $taskStatus);
                header("Location: overview.php");
                exit();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
    
    
    
    

    

        
}
?>
