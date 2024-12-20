<?php
namespace App\Controller;

use App\Config\Auth;
use App\Model\Dao\UserDAO;
use App\Model\Entities\User;
use InvalidArgumentException;
use Exception;
use App\Model\Dao\AuditDAO;
use App\Model\Entities\Audit;
use App\Model\Enums\AuditActions;
use App\Model\Enums\AuditTables;
class UserController
{
    public function index(): void
    {
        $userDAO = new UserDAO();
        $users = $userDAO->getAll(); // Récupérer tous les users

        $view = './App/Views/userPage/Main.php'; // Vue principale
        include_once './App/Views/Layout/Layout.php';
    }

    public function profile()
    {
        $user = Auth::getUser();

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

                $userId = Auth::getUser()->getId();
                $audit = new Audit(null, AuditTables::USER->value, AuditActions::CREATE->value, 'L\'utilisateur avec l\'email' . $email . ' a été créé !', date('Y-m-d H:i:s'), $userId);
                $auditDAO = new AuditDAO();
                $auditDAO->logAudit($audit);

                $_SESSION['success_message'] = 'User ajouté avec succès.';
            } catch (InvalidArgumentException $e) {
                $_SESSION['error_message'] = $e->getMessage();
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
            }

            header('Location: /user');
            exit();
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

                $userId = Auth::getUser()->getId();
                $audit = new Audit(null, AuditTables::USER->value, AuditActions::UPDATE->value, 'L\'utilisateur avec l\'ID ' . $id . ' a été mis à jour !', date('Y-m-d H:i:s'), $userId);
                $auditDAO = new AuditDAO();
                $auditDAO->logAudit($audit);

                $_SESSION['success_message'] = 'User modifié avec succès.';
            } catch (InvalidArgumentException $e) {
                $_SESSION['error_message'] = $e->getMessage();
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
            }

            header('Location: /user');
            exit();
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

            $userId = Auth::getUser()->getId();
            $audit = new Audit(null, AuditTables::USER->value, AuditActions::DELETE->value, 'L\'utilisateur avec l\'ID ' . $id . ' a été supprimé !', date('Y-m-d H:i:s'), $userId);
            $auditDAO = new AuditDAO();
            $auditDAO->logAudit($audit);

            $_SESSION['success_message'] = 'User supprimé avec succès.';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
        }

        // Redirection après la suppression
        header('Location: /user');
        exit();
    }

    function updateprofile()
    {
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

                $userId = Auth::getUser()->getId();
                $audit = new Audit(null, AuditTables::USER->value, AuditActions::UPDATE->value, 'L\'utilisateur avec l\'ID ' . $id . ' a été mis à jour !', date('Y-m-d H:i:s'), $userId);
                $auditDAO = new AuditDAO();
                $auditDAO->logAudit($audit);

                $_SESSION['success_message'] = 'Votre profil a été modifié avec succès.';
            } catch (InvalidArgumentException $e) {
                $_SESSION['error_message'] = $e->getMessage();
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
            }
            header('Location: /my-profile');
            exit();
        }
    }

    public function archives(): void
    {
        $userDAO = new UserDAO();
        $deletedUsers = $userDAO->getDeletedUsers(); // Récupérer les utilisateurs supprimés

        $view = './App/Views/userPage/archives.php'; // Vue des archives
        include_once './App/Views/Layout/Layout.php';
    }
    public function restore($id): void
    {
        try {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException('ID invalide.');
            }

            $userDAO = new UserDAO();
            $userDAO->restore($id); // Restaurer l'utilisateur

            $userId = Auth::getUser()->getId();
            $audit = new Audit(null, AuditTables::USER->value, AuditActions::RESTORE->value, 'L\'utilisateur avec l\'ID ' . $id . ' a été restauré !', date('Y-m-d H:i:s'), $userId);
            $auditDAO = new AuditDAO();
            $auditDAO->logAudit($audit);

            $_SESSION['success_message'] = 'Utilisateur restauré avec succès.';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
        }

        header('Location: /user/archives');
        exit();
    }
}
