<?php
namespace App\Controller;

use App\Model\Dao\UserDAO;
use App\Model\Entities\User;
use InvalidArgumentException;
use Exception;

class UserController
{

    public function index(): void
    {
        $userDAO = new UserDAO();
        $users = $userDAO->getAll(); // Récupérer tous les users

        $view = './App/Views/userPage/Main.php'; // Vue principale
        include_once './App/Views/Layout/Layout.php';
    }

    public function profile() {
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

        $view = './App/Views/userPage/my-profile.php'; // Vue de my-profile
        include_once './App/Views/Layout/Layout.php';
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? null;
            $prenom = $_POST['prenom'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $role = $_POST['role'] ?? null;

            try {
                if (!$nom || !$prenom || !$email || !$password || !$role) {
                    throw new InvalidArgumentException('Tous les champs doivent être remplis.');
                }

                $userDAO = new UserDAO();
                $user = new User($email, $password, $nom, $prenom, 0, $role, null);
                $userDAO->create($user);

                $_SESSION['success_message'] = 'User ajouté avec succès.';
            } catch (InvalidArgumentException $e) {
                $_SESSION['error_message'] = $e->getMessage();
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
            }

            header('Location: /user');
            exit;
        }
    }

    public function update($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? null;
            $prenom = $_POST['prenom'] ?? null;
            $email = $_POST['email'] ?? null;
            $role = $_POST['role'] ?? null;
    
            try {
                if (!$nom || !$prenom || !$email || !$role) {
                    throw new InvalidArgumentException('Tous les champs doivent être remplis.');
                }
    
                $userDAO = new UserDAO();
                $user = new User($email, null, $nom, $prenom, 0, $role, null);
                $userDAO->update($id, $user);
    
                $_SESSION['success_message'] = 'User modifié avec succès.';
            } catch (InvalidArgumentException $e) {
                $_SESSION['error_message'] = $e->getMessage();
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
            }
    
            header('Location: /user');
            exit;
        }
    }
    

    public function delete($id): void
    {
        try {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException('ID invalide.');
            }
    
            $userDAO = new UserDAO();
            $userDAO->delete($id);
    
            $_SESSION['success_message'] = 'User supprimé avec succès.';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
        }
    
        // Redirection après la suppression
        header('Location: /user');
        exit;
    }

    function updateprofile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? null;
            $prenom = $_POST['prenom'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            
            $userSession = $_SESSION['user'];
            $id = $userSession['user_id'];
            try {
                if (!$nom || !$prenom || !$email || !$password) {
                    throw new InvalidArgumentException('Tous les champs doivent être remplis.');
                }

                $userDAO = new UserDAO();
                $user = new User($email, $password, $nom, $prenom, 0, null, null);
                $userDAO->updateProfile($id, $user);
                $userDAO->updatePassword($id, $password);

                $_SESSION['user']['nom'] = $nom;
                $_SESSION['user']['prenom'] = $prenom;
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['password'] = $password;


                $_SESSION['success_message'] = 'Votre profil a été modifié avec succès.';
            } catch (InvalidArgumentException $e) {
                $_SESSION['error_message'] = $e->getMessage();
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
            }
            header('Location: /my-profile');
            exit;
        }
    }
     
}
