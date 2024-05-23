function handleAccountAction(action, compte_id) {
    let amount = prompt(`Enter the amount for ${action}:`);

    if (amount != null) {
        amount = parseFloat(amount);
        if (isNaN(amount) || amount <= 0) {
            alert("Please enter a valid amount.");
            return;
        }

        let url = action === "deposit" ? "deposit.php" : "withdraw.php";
        let data = new FormData();
        data.append('compte_id', compte_id);
        data.append('amount', amount);

        fetch(url, {
            method: 'POST',
            body: data
        })
        .then(response => response.text())
        .then(result => {
            alert(result);
            location.reload(); // Reload the page to see the updated balance
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred. Please try again.");
        });
    }
}
