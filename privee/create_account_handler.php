<?php
require_once '../classes/based.php';
require_once '../classes/CompteBancaire.php';
// Activer le rapport d'erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST['client_id'];
    $account_number = $_POST['account_number'];
    $initial_balance = $_POST['initial_balance'];

    $response = [];

    // Vérifier si le client a déjà un compte bancaire
    $sql = "SELECT * FROM comptesbancaires WHERE client_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Le client a déjà un compte bancaire
        $response['success'] = false;
        $response['message'] = 'Le client a déjà un compte bancaire.';
    } else {
        // Le client n'a pas encore de compte bancaire, créer un nouveau compte
        if (CompteBancaire::createCompte($conn, $account_number, $initial_balance, $client_id)) {
            $response['success'] = true;
            $response['message'] = 'Compte créé avec succès!';
        } else {
            $response['success'] = false;
            $response['message'] = 'Échec de la création du compte.';
        }
    }

    echo json_encode($response);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}