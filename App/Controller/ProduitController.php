<?php

namespace App\Controller;

use App\Model\Dao\ProduitDAO;
use App\Model\Entities\Produit;
use App\Model\Dao\CategorieDAO;
use InvalidArgumentException;
use Exception;

class ProduitController
{
    public function index(): void
    {
        $produitDAO = new ProduitDAO();
        $produits = $produitDAO->getAll(); // Retrieve all products

        if (empty($produits)) {
            $produits = []; // Ensure it's always an empty array
        }

        $categorieDAO = new CategorieDAO(); // Initialize CategorieDAO
        $categories = $categorieDAO->getAll(); // Fetch all categories (if needed)

        // Pass the required data to the view
        $view = './App/Views/ProduitPage/ProduitPage.php'; // Main view
        include_once './App/Views/Layout/Layout.php'; // Layout with the main view
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCategorie = $_POST['idCategorie'] ?? null;
            $designation = $_POST['designation'] ?? null;
            $prix = $_POST['prix'] ?? null;
            $qtt = $_POST['qtt'] ?? null;
            $pathImage = $_FILES['pathImage'] ?? null;  // Change to handle file upload

            try {
                // Vérification des champs obligatoires
                if (!$designation || !$prix || !$qtt || !$idCategorie || !$pathImage || $pathImage['error'] !== UPLOAD_ERR_OK) {
                    throw new InvalidArgumentException('Tous les champs doivent être remplis et l\'image doit être téléchargée correctement.');
                }

                // Définir le répertoire de stockage des images (dossier uploads dans public)
                $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/E-Stock/public/uploads/';

                // Vérifier si le répertoire existe, sinon le créer
                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true);  // Crée le dossier s'il n'existe pas
                }

                // Générer un nom unique pour l'image
                $imageName = uniqid('product_', true) . '.' . pathinfo($pathImage['name'], PATHINFO_EXTENSION);

                // Définir le chemin complet où déplacer l'image
                $imagePath = $uploadDirectory . $imageName;

                // Déplacer le fichier téléchargé vers le répertoire public/uploads
                if (!move_uploaded_file($pathImage['tmp_name'], $imagePath)) {
                    throw new Exception('Erreur lors du téléchargement de l\'image.');
                }

                // Chemin relatif de l'image (pour l'utiliser dans la base de données)
                $relativeImagePath = 'uploads/' . $imageName;

                // Créer le produit et l'ajouter à la base de données
                $produitDAO = new ProduitDAO();
                $produit = new Produit(null, $designation, $prix, $qtt, $relativeImagePath, 0, $idCategorie);
                $produitDAO->create($produit);

                $_SESSION['success_message'] = 'Produit ajouté avec succès.';
            } catch (InvalidArgumentException $e) {
                $_SESSION['error_message'] = $e->getMessage();
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
            }

            header(header: 'Location: /Product');
            exit;
        }
    }


    public function update($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $designation = $_POST['designation'] ?? null;
            $prix = $_POST['prix'] ?? null;
            $qtt = $_POST['qtt'] ?? null;
            $idCategorie = $_POST['idCategorie'] ?? null;
            $pathImage = $_FILES['pathImage'] ?? null; // Pour gérer le téléchargement d'une nouvelle image

            try {
                // Validation des champs obligatoires (hors image)
                if (!$designation || !$prix || !$qtt || !$idCategorie) {
                    throw new InvalidArgumentException('Tous les champs doivent être remplis.');
                }

                // Gestion de l'image : conserver l'ancienne ou remplacer par la nouvelle
                $produitDAO = new ProduitDAO();
                $produitActuel = $produitDAO->getById($id);

                if (!$produitActuel) {
                    throw new Exception('Produit non trouvé.');
                }

                $relativeImagePath = $produitActuel->getPathImage(); // Conserver l'image actuelle par défaut

                if ($pathImage && $pathImage['error'] === UPLOAD_ERR_OK) {
                    // Définir le répertoire de stockage des images
                    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/E-Stock/public/uploads/';

                    if (!is_dir($uploadDirectory)) {
                        mkdir($uploadDirectory, 0777, true);
                    }

                    // Générer un nom unique pour la nouvelle image
                    $imageName = uniqid('product_', true) . '.' . pathinfo($pathImage['name'], PATHINFO_EXTENSION);

                    // Chemin complet pour l'image
                    $imagePath = $uploadDirectory . $imageName;

                    if (!move_uploaded_file($pathImage['tmp_name'], $imagePath)) {
                        throw new Exception('Erreur lors du téléchargement de l\'image.');
                    }

                    // Chemin relatif de la nouvelle image
                    $relativeImagePath = 'uploads/' . $imageName;

                    // Supprimer l'ancienne image si elle existe et est différente de la nouvelle
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/E-Stock/public/' . $produitActuel->getPathImage())) {
                        unlink($_SERVER['DOCUMENT_ROOT'] . '/E-Stock/public/' . $produitActuel->getPathImage());
                    }
                }

                // Mettre à jour le produit
                $produit = new Produit($id, $designation, $prix, $qtt, $relativeImagePath, 0, $idCategorie);
                $produitDAO->update($produit);

                $_SESSION['success_message'] = 'Produit modifié avec succès.';
            } catch (InvalidArgumentException $e) {
                $_SESSION['error_message'] = $e->getMessage();
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
            }

            header('Location: /Product');
            exit;
        }
    }

    public function delete($id): void
    {
        try {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException('ID invalide.');
            }

            $produitDAO = new ProduitDAO();
            $produitDAO->delete($id); // Soft delete the product

            $_SESSION['success_message'] = 'Produit supprimé avec succès.';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
        }

        header('Location: /Product');
        exit;
    }
}
?>