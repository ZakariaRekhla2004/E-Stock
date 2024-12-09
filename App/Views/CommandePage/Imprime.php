<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture - Commande <?= htmlspecialchars($commande->getId()) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .details { margin-bottom: 20px; }
        .details p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        .footer { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Facture</h1>
        <p>Commande N° <?= htmlspecialchars($commande->getId()) ?></p>
        <p>Date : <?= htmlspecialchars($commande->getDateCommande()) ?></p>
    </div>
    <div class="details">
        <p><strong>Client :</strong> <?= htmlspecialchars($commande->getIdClient()) ?> <?= htmlspecialchars($commande->getIdClient()) ?></p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produits as $produit): ?>
            <tr>
                <td><?= htmlspecialchars($produit['nom']) ?></td>
                <td><?= htmlspecialchars($produit['quantity']) ?></td>
                <td><?= htmlspecialchars($produit['prix']) ?> DH</td>
                <td><?= htmlspecialchars($produit['quantity'] * $produit['prix']) ?> DH</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="footer">
        <p><strong>Total :</strong> <?= htmlspecialchars(array_reduce($produits, fn($sum, $p) => $sum + $p['quantity'] * $p['prix'], 0)) ?> DH</p>
    </div>
</body>
</html>