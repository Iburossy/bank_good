<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank-Gestion</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">HOME</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="../index.php">Inscrire un client</a></li>
                <li class="nav-item"><a class="nav-link" href="account_creation.php">Créer un compte</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php">Gérer les comptes</a></li>
                <li class="nav-item"><a class="nav-link" href="account_statement.php">Relevés</a></li>
                <li class="nav-item"><a class="nav-link" href="tranfer_form.php">Virement</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Content Section -->
        <?php
        include($content); 
        ?>
    </div>

</body>
</html>
