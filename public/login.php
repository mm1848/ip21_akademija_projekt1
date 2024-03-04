<?php

if (isset($_GET['success'])): ?>
    <p>Registration successful. Please log in.</p>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Crypto Prices</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <?php if (isset($_GET['success'])): ?>
            <p class="success-message">Registration successful. Please log in.</p>
        <?php endif; ?>
        
        <form action="process_login.php" method="POST">
            <h1>Crypto Prices</h1>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-button">Login</button>
        </form>
    </div>
</body>
</html>