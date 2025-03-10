<?php
session_start(); // Démarrer la session



// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier les identifiants (à adapter selon vos besoins)
    if ($username === 'admin' && $password === 'admin') {
        // Authentification réussie
        $_SESSION['loggedin'] = true;
        header('Location: reclamations.php'); // Rediriger vers la page des réclamations
        exit;
    } else {
        // Identifiants incorrects
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Connexion Administrateur</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .php-email-form {
      padding: 30px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      width: 100%;
    }

    .php-email-form .form-control {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      width: 100%;
      box-sizing: border-box;
      transition: border-color 0.3s ease;
      margin-bottom: 20px;
    }

    .php-email-form .form-control:focus {
      border-color: rgb(215, 116, 59);
    }

    .php-email-form label {
      font-weight: bold;
      margin-bottom: 8px;
      display: block;
    }

    .php-email-form button {
      background-color: rgb(215, 116, 59);
      color: #fff;
      border: none;
      padding: 12px 24px;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      width: 100%;
    }

    .php-email-form button:hover {
      background-color: rgb(195, 96, 39);
    }

    .php-email-form .error-message {
      color: #dc3545;
      margin-bottom: 15px;
      text-align: center;
    }

    .php-email-form .sent-message {
      color: #28a745;
      margin-bottom: 15px;
      text-align: center;
    }

    .php-email-form .loading {
      display: none;
    }
  </style>
</head>

<body>
  <form action="" method="POST" class="php-email-form">
    <h2 class="text-center mb-4">Connexion Administrateur</h2>

    <?php if (isset($error)) : ?>
      <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="form-section">
      <label for="username">Nom d'utilisateur *</label>
      <input type="text" name="username" id="username" class="form-control" placeholder="Votre nom d'utilisateur" required>
    </div>

    <div class="form-section">
      <label for="password">Mot de passe *</label>
      <input type="password" name="password" id="password" class="form-control" placeholder="Votre mot de passe" required>
    </div>

    <div class="form-section text-center">
      <button type="submit">Se connecter</button>
    </div>
  </form>
</body>

</html>