<?php
require '../classes/based.php';
require '../classes/CompteBancaire.php';
require '../classes/OperationBancaire.php';

// Activer le rapport d'erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $source_account_id = $_POST['source_account_id'];
    $destination_account_id = $_POST['destination_account_id'];
    $amount = $_POST['amount'];

    $response = [];

    // Vérifier que le compte source et le compte destination sont différents
    if ($source_account_id == $destination_account_id) {
        $response['success'] = false;
        $response['message'] = 'Le compte source et le compte destination doivent être différents.';
        echo json_encode($response);
        exit();
    }

    // Effectuer le virement
    if (CompteBancaire::transfer($conn, $source_account_id, $destination_account_id, $amount)) {
        $response['success'] = true;
        $response['message'] = 'Virement effectué avec succès.';
    } else {
        $response['success'] = false;
        $response['message'] = 'Échec du virement.';
    }

    echo json_encode($response);
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode de requête invalide.']);
}
?>
