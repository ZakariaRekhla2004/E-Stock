<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture - Commande <?= htmlspecialchars($commande->getId()) ?></title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 20px;
            color: #333;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #444;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .details {
            margin-bottom: 20px;
            padding: 10px;
            background: #f7f7f7;
            border-radius: 5px;
        }
        .details p {
            margin: 8px 0;
            font-size: 14px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table thead {
            background: #007BFF;
            color: white;
        }
        table thead tr th {
            text-align: left;
            padding: 10px;
            font-size: 14px;
        }
        table tbody tr td {
            padding: 10px;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
        }
        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }
        .footer p {
            font-weight: bold;
            color: #333;
        }
        .btn-print {
            display: inline-block;
            padding: 10px 20px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn-print:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Facture</h1>
            <p>Commande N° <?= htmlspecialchars($commande->getId()) ?></p>
            <p>Date : <?= htmlspecialchars($commande->getDateCommande()) ?></p>
        </div>
        <div class="details">
            <p><strong>Client :</strong> <?= htmlspecialchars($client->getNom()) ?> <?= htmlspecialchars($client->getPrenom()) ?></p>
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
            <p>Total : <?= htmlspecialchars(array_reduce($produits, fn($sum, $p) => $sum + $p['quantity'] * $p['prix'], 0)) ?> DH</p>
        </div>
    </div>
</body>
</html>
