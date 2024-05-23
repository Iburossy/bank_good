<h2>Inscription employé</h2>
<form id="signup-form">
    <div class="form-group">
        <label for="prenom">First Name</label>
        <input type="text" id="prenom" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="nom">Last Name</label>
        <input type="text" id="nom" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="poste">Position</label>
        <input type="text" id="poste" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Sign Up</button>
</form>

<!-- AJAX Script for Employee Signup -->
<script>
$(document).ready(function() {
    $('#signup-form').submit(function(event) {
        event.preventDefault();

        $.ajax({
            url: 'signup_handler.php',
            type: 'POST',
            data: {
                prenom: $('#prenom').val(),
                nom: $('#nom').val(),
                poste: $('#poste').val(),
                email: $('#email').val(),
                password: $('#password').val()
            },
            success: function(response) {
                alert(response.message);
                if (response.success) {
                    window.location.href = 'login.php'; // Redirect to login page
                }
                $('#signup-form')[0].reset();
            }
        });
    });
});
</script>
