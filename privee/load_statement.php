<?php
require_once '../classes/based.php';
require_once '../classes/CompteBancaire.php';
require_once '../classes/OperationBancaire.php';

$accountNumber = $_POST['account_number'];

// Find the account ID based on the account number
$sql = "SELECT compte_id FROM comptesbancaires WHERE numero_compte = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $accountNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($account = $result->fetch_assoc()) {
    $compte_id = $account['compte_id'];

    // Retrieve the transaction history using the `OperationBancaire` class
    $transactions = OperationBancaire::getOperationsByCompte($conn, $compte_id);
    $rows = '';

    foreach ($transactions as $transaction) {
        $rows .= "<tr>
            <td>{$transaction['date_operation']}</td>
            <td>{$transaction['type_operation']}</td>
            <td>{$transaction['montant']}</td>
            <td>{$transaction['compte_source_id']}</td>
            <td>{$transaction['compte_destination_id']}</td>
        </tr>";
    }

    echo $rows;
} else {
    echo "<tr><td colspan='5'>Aucune transaction trouvée pour ce numero de compte.</td></tr>";
}
?>
