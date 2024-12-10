<?php

namespace App\Controller;

use App\Model\Dao\CategorieDAO;
use App\Model\Entities\Categorie;
use InvalidArgumentException;
use Exception;
use App\Model\Dao\ProduitDAO;
use App\Config\Auth;
use App\Model\Dao\AuditDAO;
use App\Model\Entities\Audit;
use App\Model\Enums\AuditActions;
use App\Model\Enums\AuditTables;


class CategorieController
{

    public function index(): void
    {
        $categorieDAO = new CategorieDAO();
        $categories = $categorieDAO->getAll(); // Récupérer toutes les catégories

        // Optionnel : Récupérer les produits pour chaque catégorie (si nécessaire)
        $produitDAO = new ProduitDAO();
        $productsByCategory = [];
        foreach ($categories as $category) {
            $productsByCategory[$category->getId()] = $produitDAO->getByCategory($category->getId());
        }

        // Inclure la vue principale
        $view = './App/Views/CategoryPage/CategoryPage.php'; // Vue principale
        include_once './App/Views/Layout/Layout.php'; // Layout avec la vue principale
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

                $userId = Auth::getUser()->getId();
                $audit = new Audit(
                    null,
                    AuditTables::CATEGORY->value,
                    AuditActions::CREATE->value,
                    'La catégorie avec le nom ' . $nom . ' a été créée !'
                    ,
                    date('Y-m-d H:i:s'),
                    $userId
                );
                $auditDAO = new AuditDAO();
                $auditDAO->logAudit($audit);


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

                $userId = Auth::getUser()->getId();
                $audit = new Audit(
                    null,
                    AuditTables::CATEGORY->value,
                    AuditActions::UPDATE->value,
                    'La catégorie avec l\'ID ' . $id . ' a été mise à jour !'
                    ,
                    date('Y-m-d H:i:s'),
                    $userId
                );
                $auditDAO = new AuditDAO();
                $auditDAO->logAudit($audit);

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
            $categorieDAO->delete($id);

            $userId = Auth::getUser()->getId();
            $audit = new Audit(
                null,
                AuditTables::CATEGORY->value,
                AuditActions::DELETE->value,
                'La catégorie avec l\'ID ' . $id . ' a été supprimée !'
                ,
                date('Y-m-d H:i:s'),
                $userId
            );
            $auditDAO = new AuditDAO();
            $auditDAO->logAudit($audit);

            $_SESSION['success_message'] = 'Catégorie supprimée avec succès.';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
        }

        header('Location: /Category');
        exit;
    }


}
