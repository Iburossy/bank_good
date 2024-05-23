<h2>Relevé de compte</h2>
<form id="statement-form">
    <div class="form-group">
        <label for="account-number">Entrez le numero du compte</label>
        <input type="text" id="account-number" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Generer Un Relevé</button>
</form>

<h3>Historique des Transaction</h3>
<table class="table table-striped" id="statement-table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Montant</th>
            <th>Compte Source</th>
            <th>Compte Destinataire</th>
        </tr>
    </thead>
    <tbody>
        <!-- Rows will be dynamically populated -->
    </tbody>
</table>

<!-- jQuery Script for AJAX form submission -->
<script>
$(document).ready(function() {
    $('#statement-form').submit(function(event) {
        event.preventDefault();
        var accountNumber = $('#account-number').val();

        $.ajax({
            url: 'load_statement.php',
            type: 'POST',
            data: { account_number: accountNumber },
            success: function(response) {
                $('#statement-table tbody').html(response);
            }
        });
    });
});
</script>
