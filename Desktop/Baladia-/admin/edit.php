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

// Récupérer les données de la réclamation
$sql = "SELECT * FROM reclamations WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    die("Réclamation non trouvée.");
}

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $cin = $_POST['cin'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $type = $_POST['type'];
    $subject = $_POST['subject'];

    // Mettre à jour la réclamation
    $sql = "UPDATE reclamations SET 
            name = '$name', 
            cin = '$cin', 
            email = '$email', 
            address = '$address', 
            type = '$type', 
            subject = '$subject' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header('Location: reclamations.php');
        exit;
    } else {
        echo "Erreur lors de la mise à jour : " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Réclamation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Modifier Réclamation</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nom & Prénom</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="cin" class="form-label">CIN</label>
                <input type="text" class="form-control" id="cin" name="cin" value="<?php echo $row['cin']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>">
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="type1" <?php if ($row['type'] == 'type1') echo 'selected'; ?>>Administration</option>
                    <option value="type2" <?php if ($row['type'] == 'type2') echo 'selected'; ?>>Constructions Anarchiques</option>
                    <option value="type3" <?php if ($row['type'] == 'type3') echo 'selected'; ?>>Éclairage Public</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Sujet</label>
                <input type="text" class="form-control" id="subject" name="subject" value="<?php echo $row['subject']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</body>
</html>