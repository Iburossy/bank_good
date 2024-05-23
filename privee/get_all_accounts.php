<?php
require_once '../classes/based.php';
require_once '../classes/CompteBancaire.php';

// Activer le rapport d'erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

$comptes = CompteBancaire::getAllComptes($conn);
echo json_encode($comptes);
