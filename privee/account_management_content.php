<h2>Gestion De Compte</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Compte ID</th>
            <th>Numero Du Compte</th>
            <th>Solde</th>
            <th>Client ID</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="accounts-table">
        <!-- Content dynamically loaded via JavaScript -->
    </tbody>
</table>

<!-- Modals for Deposit, Withdrawal, Transfer -->
<div class="modal fade" id="accountActionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="accountActionModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="account-action-form">
                    <div class="form-group">
                        <label for="action-amount">Montant</label>
                        <input type="number" id="action-amount" class="form-control" required>
                    </div>
                    <input type="hidden" id="action-account-id">
                    <button type="submit" class="btn btn-primary" id="action-submit-button"></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery Script pour charger les donnee -->
<script>
$(document).ready(function() {
    // Load accounts into the table
    $.ajax({
        url: 'load_account.php',
        type: 'GET',
        success: function(response) {
            $('#accounts-table').html(response);
        }
    });

    // Handle form submission
    $('#account-action-form').submit(function(event) {
        event.preventDefault();
        var accountId = $('#action-account-id').val();
        var amount = $('#action-amount').val();
        var action = $('#action-submit-button').data('action');

        $.ajax({
            url: action + '.php',
            type: 'POST',
            data: { account_id: accountId, amount: amount },
            success: function(response) {
                alert(response.message);
                $('#accountActionModal').modal('hide');
                location.reload(); // Refresh the page to reflect changes
            }
        });
    });

    // Handle deposit, withdrawal, and transfer buttons
    function handleAccountAction(action, accountId) {
        $('#accountActionModalLabel').text(action.charAt(0).toUpperCase() + action.slice(1));
        $('#action-submit-button').text(action.charAt(0).toUpperCase() + action.slice(1)).data('action', action);
        $('#action-account-id').val(accountId);
        $('#accountActionModal').modal('show');
    }

    window.handleAccountAction = handleAccountAction;
});
</script>
