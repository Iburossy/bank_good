<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">HOME</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="account_creation.php">Créer un compte</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php">Gérer les comptes</a></li>
                <li class="nav-item"><a class="nav-link" href="account_statement.php">Relevés</a></li>
                <li class="nav-item"><a class="nav-link" href="tranfer_form.php">Virement</a></li>
            </ul>
        </div>
    </nav>
    <title>Virement entre comptes bancaires</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Virement entre comptes bancaires</h2>
        <form id="transfer-form">
            <div class="form-group">
                <label for="source-account-id">Compte source</label>
                <select id="source-account-id" class="form-control" required>
                    <option value="">Sélectionnez un compte source</option>
                </select>
            </div>
            <div class="form-group">
                <label for="destination-account-id">Compte destination</label>
                <select id="destination-account-id" class="form-control" required>
                    <option value="">Sélectionnez un compte destination</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Montant</label>
                <input type="number" id="amount" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Effectuer le virement</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
    $(document).ready(function() {
        // Charger tous les comptes bancaires
        $.ajax({
            url: 'get_all_accounts.php',
            type: 'GET',
            dataType: 'json',
            success: function(accounts) {
                let sourceSelect = $('#source-account-id');
                let destinationSelect = $('#destination-account-id');
                accounts.forEach(account => {
                    let option = `<option value="${account.compte_id}">${account.numero_compte}</option>`;
                    sourceSelect.append(option);
                    destinationSelect.append(option);
                });
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors du chargement des comptes:', xhr.responseText);
            }
        });

        // Soumettre le formulaire de virement
        $('#transfer-form').submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: 'transfer_handler.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    source_account_id: $('#source-account-id').val(),
                    destination_account_id: $('#destination-account-id').val(),
                    amount: $('#amount').val()
                },
                success: function(response) {
                    alert(response.message);
                    if (response.success) {
                        $('#transfer-form')[0].reset();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erreur lors du virement:', xhr.responseText);
                }
            });
        });
    });
    </script>
</body>
</html>
