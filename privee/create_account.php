<?php
require_once '../classes/based.php';
require_once '../classes/Clients.php';
require_once '../classes/CompteBancaire.php';

header('Content-Type: application/json'); // Set correct content type

$client_name = $_POST['prenom'];
list($prenom, $nom) = explode(' ', $client_name, 1); // Assuming client_name is 'FirstName LastName'

// Validate inputs
if (empty($prenom) || empty($nom)) {
    echo json_encode(['message' => 'Client name must include first and last name.']);
    exit;
}

$client_id = Client::getClientIdByName($conn, $prenom, $nom);

if ($client_id === false) {
    echo json_encode(['message' => 'Client not found. Please check the name and try again.']);
    exit;
}

$account_number = $_POST['numero_compte'];
$account_balance = $_POST['solde'];

$result = CompteBancaire::createCompte($conn, $account_number, $account_balance, $client_id);

if ($result) {
    echo json_encode(['message' => 'Account created successfully!']);
} else {
    echo json_encode(['message' => 'Error creating account.']);
}
?>
