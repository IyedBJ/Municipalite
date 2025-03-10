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

// Récupérer l'ID de la réclamation
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID de réclamation non spécifié.");
}

// Supprimer la réclamation
$sql = "DELETE FROM reclamations WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header('Location: reclamations.php');
    exit;
} else {
    echo "Erreur lors de la suppression : " . $conn->error;
}

$conn->close();
?>