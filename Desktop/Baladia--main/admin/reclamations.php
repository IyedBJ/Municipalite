<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "municipalite";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les réclamations avec une requête préparée
$sql = "SELECT * FROM reclamations";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erreur de préparation de la requête : " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Réclamations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Gestion des Réclamations</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom & Prénom</th>
                    <th>CIN</th>
                    <th>Email</th>
                    <th>Adresse</th>
                    <th>Type</th>
                    <th>Sujet</th>
                    <th>Photo</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['id']) . "</td>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['cin']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['address']) . "</td>
                                <td>" . htmlspecialchars($row['type']) . "</td>
                                <td>" . htmlspecialchars($row['subject']) . "</td>
                                <td><img src='" . htmlspecialchars($row['photo']) . "' width='300'></td>
                                <td>" . htmlspecialchars($row['reg_date']) . "</td>
                                <td>
                                    <a href='edit.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-warning'>Modifier</a>
                                    <a href='delete.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger'>Supprimer</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>Aucune réclamation trouvée</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>