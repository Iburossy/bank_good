<?php
require_once '../classes/based.php';
require_once '../classes/CompteBancaire.php';

$accounts = CompteBancaire::getAllComptes($conn);
$rows = '';

foreach ($accounts as $account) {
    $rows .= "<tr>
        <td>{$account['compte_id']}</td>
        <td>{$account['numero_compte']}</td>
        <td>{$account['solde']}</td>
        <td>{$account['client_id']}</td>
        <td>
            <button class='btn btn-info' onclick='handleAccountAction(\"deposit\", {$account['compte_id']})'>Depot</button>
            <button class='btn btn-warning' onclick='handleAccountAction(\"withdraw\", {$account['compte_id']})'>Retrait</button>
        </td>
    </tr>";
}

echo $rows;
?>

<script>
function handleAccountAction(action, compte_id) {
    let amount = prompt("Please enter the amount:");
    if (amount === null || amount.trim() === "") {
        alert("Il faut taper le solde!");
        return;
    }
    amount = parseFloat(amount);
    if (isNaN(amount) || amount <= 0) {
        alert("solde invalide !");
        return;
    }

    let url = action === "deposit" ? "deposit.php" : "withdraw.php";

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ compte_id: compte_id, amount: amount }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Operation reussie!");
            location.reload(); // Reload the page to see the updated balance
        } else {
            alert("Operation echoué : " + data.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert("Erreur. Ressayez.");
    });
}

</script>