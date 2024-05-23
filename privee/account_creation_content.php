<h2>Créer un nouveau compte bancaire</h2>
<form id="create-account-form">
    <div class="form-group">
        <label for="client-id">Sélectionnez un client parmi les inscrits sur notre application web et le compte bancaire lui sera automatiquement attribué</label>
        <select id="client-id" class="form-control" required>
            <option value="">Sélectionnez un client</option>
        </select>
    </div>
    <div class="form-group">
        <label for="account-number">Numéro de compte</label>
        <input type="text" id="account-number" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="initial-balance">Solde initial</label>
        <input type="number" id="initial-balance" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Créer un compte</button>
</form>

<!-- jQuery Script for AJAX form submission -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    // Charger tous les clients
    $.ajax({
        url: 'get_all_clients.php',
        type: 'GET',
        dataType: 'json',
        success: function(clients) {
            let clientSelect = $('#client-id');
            clients.forEach(client => {
                clientSelect.append(`<option value="${client.client_id}">${client.nom}</option>`);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error lors du chargement des clients:', xhr.responseText); // Afficher le texte de réponse pour déboguer
        }
    });

    // Soumettre le formulaire de création de compte
    $('#create-account-form').submit(function(event) {
        event.preventDefault();

        $.ajax({
            url: 'create_account_handler.php',
            type: 'POST',
            dataType: 'json',
            data: {
                client_id: $('#client-id').val(),
                account_number: $('#account-number').val(),
                initial_balance: $('#initial-balance').val()
            },
            success: function(response) {
                alert(response.message);
                if (response.success) {
                    $('#create-account-form')[0].reset();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error creation du compte:', xhr.responseText);
            }
        });
    });
});
</script>
