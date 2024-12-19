<?php


session_start(); 


require_once 'controller/UserController.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'createUser':
        $controller = new UserController();
        $controller->createUser($_POST);
        break;
    case 'showUsers':
        $controller = new UserController();
        
        $controller->showAllUsers();
        break;

    case 'showUsers2':
        $controller = new UserController();
            
        $controller->showAllUsers2();
        exit();
        break;
    
    case 'editUser':
        $controller = new UserController();
        $controller->editUser($_GET['Username']);
        break;
        
   
    case 'deleteUser':
        $controller = new UserController();
        $controller->deleteUser($_GET['Username']);
        break;
    case 'updateUser':
        $controller = new UserController();
        $controller->updateUser( $_POST['Username'],$_POST['Prenom'], $_POST['Nom'], $_POST['E_mail'], $_POST['Adresse'],$_POST['Tel']);
        break;
    case 'updateUser2':
        $controller = new UserController();
        $controller->updateUser2( $_POST['username'],$_POST['prenom'], $_POST['nom'], $_POST['email'], $_POST['adresse'],$_POST['tel']);
        break;
        case 'ChangerType':
            $controller = new UserController();
            $controller->editUser2($_POST['username'], $_POST['user_type']);
            
            break;
        
    case 'verifyUser':
        $controller =new UserController();
        $controller->verifyUser( $_POST['Username'],$_POST['Mdp']);
       break;

    case 'verifyUsername':
        $controller =new UserController();
        $controller->verifyUser2( $_POST['Username']);
        break;
    case 'ModifierMdp':
        $controller =new UserController();
        $controller->ModifierMdp($_SESSION['user']['Username'], $_POST['new_password'], $_POST['confirm_password']);
        break;

    case 'AjoutTache':
        $controller =new UserController();
        $controller->AjoutTache();
        break;
        
    default:
        header('Location: /BACK/view/task2/template/index.php');
        
        break;
        

}




?>
