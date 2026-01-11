<!DOCTYPE html>
<html>
<head>
    <title>Athena - Register</title>
</head>
<body>
    <h1>Register</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="index.php?action=register">
        <div>
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required>
        </div>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="index.php?action=login">Login</a></p>
</body>
</html>