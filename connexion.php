<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: burlywood;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6 text-center">Connexion</h2>
        <form method="post" action="login_handler.php">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="telephone">Téléphone</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="telephone" type="text" name="telephone" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="mot_de_passe">Mot de passe</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="mot_de_passe" type="password" name="mot_de_passe" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Se connecter
                </button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="index.php">
                    Pas de compte ? Inscrivez-vous
                </a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
require_once 'classes/based.php';
require_once 'classes/Clients.php';

// Activer le rapport d'erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $telephone = $_POST['telephone'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $response = [];

    // Rechercher le client par numéro de téléphone
    $sql = "SELECT * FROM clients WHERE telephone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $telephone);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();

    if ($client && password_verify($mot_de_passe, $client['photo_profil'])) {
        // Authentification réussie
        session_start();
        $_SESSION['client_id'] = $client['client_id'];
        $_SESSION['nom'] = $client['nom'];
        header("Location: privee/index.php"); // Rediriger vers le tableau de bord ou la page souhaitée
        exit();
    } else {
        // Échec de l'authentification
        $response['success'] = false;
        $response['message'] = 'Numéro de téléphone ou mot de passe incorrect.';
        echo json_encode($response);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode de requête invalide.']);
}
?>
