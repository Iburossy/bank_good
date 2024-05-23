<?php
require_once '../classes/based.php';
require_once '../classes/EmployeeBank.php';

header('Content-Type: application/json');

$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$poste = $_POST['poste'];
$email = $_POST['email'];
$password = $_POST['mot_de_passe'];

if (EmployesDeBank::createEmploye($conn, $prenom, $nom, $poste, $email, $password)) {
    echo json_encode(['success' => true, 'message' => 'Employee registered successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error registering employee.']);
}
?>
