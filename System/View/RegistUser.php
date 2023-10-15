<!DOCTYPE html>
<html>
<head>
    <title>Register User</title>
</head>
<body>
    <h1>Register User</h1>
    <form action="../Control/RegistUserController.php" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Register</button>
    </form>
</body>
</html>

<?php
