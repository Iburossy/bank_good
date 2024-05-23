<?php
require_once '../classes/based.php';
require_once '../classes/Clients.php';

// Activer le rapport d'erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

$clients = Client::getAllClients($conn);
echo json_encode($clients);