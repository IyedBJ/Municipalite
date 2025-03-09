<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "municipalite";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et nettoyer les données du formulaire
    $name = htmlspecialchars($_POST['name']);
    $cin = htmlspecialchars($_POST['cin']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $type = htmlspecialchars($_POST['type']);
    $subject = htmlspecialchars($_POST['subject']);
    $reg_date = date("Y-m-d H:i:s"); // Date actuelle

    // Gestion du fichier image
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "../uploads/"; // Dossier où les images seront stockées
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifier si le fichier est une image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            // Vérifier la taille du fichier (2MB max)
            if ($_FILES["photo"]["size"] <= 2000000) {
                // Vérifier le type de fichier
                if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                    // Déplacer le fichier téléchargé vers le dossier "uploads"
                    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                        // Insertion des données dans la base de données
                        $sql = "INSERT INTO reclamations (name, cin, email, address, type, subject, photo, reg_date)
                                VALUES ('$name', '$cin', '$email', '$address', '$type', '$subject', '$target_file', '$reg_date')";

                        if ($conn->query($sql) === TRUE) {
                            // Réponse en cas de succès
                            echo json_encode(["status" => "success", "message" => "Votre réclamation a été envoyée. Merci!"]);
                        } else {
                            // Réponse en cas d'erreur SQL
                            echo json_encode(["status" => "error", "message" => "Erreur lors de l'enregistrement dans la base de données."]);
                        }
                    } else {
                        // Réponse en cas d'erreur de téléchargement
                        echo json_encode(["status" => "error", "message" => "Désolé, une erreur s'est produite lors du téléchargement de votre fichier."]);
                    }
                } else {
                    // Réponse en cas de type de fichier non autorisé
                    echo json_encode(["status" => "error", "message" => "Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés."]);
                }
            } else {
                // Réponse en cas de fichier trop volumineux
                echo json_encode(["status" => "error", "message" => "Désolé, votre fichier est trop volumineux (max 2MB)."]);
            }
        } else {
            // Réponse en cas de fichier non image
            echo json_encode(["status" => "error", "message" => "Le fichier n'est pas une image."]);
        }
    } else {
        // Réponse en cas d'erreur de fichier
        echo json_encode(["status" => "error", "message" => "Une erreur s'est produite lors du téléchargement de l'image."]);
    }
} else {
    // Réponse en cas de méthode non autorisée
    echo json_encode(["status" => "error", "message" => "Méthode non autorisée."]);
}

$conn->close();
?>