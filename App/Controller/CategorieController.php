<?php

namespace App\Controller;

use App\Model\Dao\CategorieDAO;
use App\Model\Entities\Categorie;
use InvalidArgumentException;
use Exception;

class CategorieController
{
    public function index(): void
    {
        $categorieDAO = new CategorieDAO();
        $categories = $categorieDAO->getAll(); // Retrieve all categories

        $view = './App/Views/CategoryPage/CategoryPage.php'; // Main view
        include_once './App/Views/Layout/Layout.php'; // Layout with the main view
    }

    public function add(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'] ?? null;
        $description = $_POST['description'] ?? null;

        try {
            if (!$nom || !$description) {
                throw new InvalidArgumentException('Tous les champs doivent être remplis.');
            }

            $categorieDAO = new CategorieDAO();
            $categorie = new Categorie(null, $nom, $description, 0); // Créer une nouvelle catégorie (pas supprimée)
            $categorieDAO->create($categorie);

            $_SESSION['success_message'] = 'Catégorie ajoutée avec succès.';
        } catch (InvalidArgumentException $e) {
            $_SESSION['error_message'] = $e->getMessage();
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
        }

        // Rediriger vers /Category pour afficher les catégories
        header('Location: /Category');
        exit;
    }
}


    public function update($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? null;
            $description = $_POST['description'] ?? null;

            try {
                if (!$nom || !$description) {
                    throw new InvalidArgumentException('Tous les champs doivent être remplis.');
                }

                $categorieDAO = new CategorieDAO();
                $categorie = new Categorie($id, $nom, $description, 0); // Update category
                $categorieDAO->update($categorie);

                $_SESSION['success_message'] = 'Catégorie modifiée avec succès.';
            } catch (InvalidArgumentException $e) {
                $_SESSION['error_message'] = $e->getMessage();
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
            }

            header('Location: /Category');
            exit;
        }
    }

    public function delete($id): void
    {
        try {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException('ID invalide.');
            }

            $categorieDAO = new CategorieDAO();
            $categorieDAO->delete($id); // Soft delete the category

            $_SESSION['success_message'] = 'Catégorie supprimée avec succès.';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
        }

        header('Location: /Category');
        exit;
    }

}
