<?php
require_once '../classes/based.php';
require_once '../classes/CompteBancaire.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['compte_id'], $data['amount'])) {
    $compte_id = $data['compte_id'];
    $amount = $data['amount'];

    if (CompteBancaire::withdraw($conn, $compte_id, $amount)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to withdraw.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}
?>
