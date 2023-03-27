<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="css/styles2.css">
</head>
<body>
    <br>
    <h1>User Registration</h1>
    
    <?php if (isset($user)): ?>
        
        <p> <?= htmlspecialchars($user["name"]) ?></p>
        
        <p><a href="logout.php">Log out</a></p>
        
    <?php else: ?>
        
        <p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="login.php">Log in</a> or <a href="signup.html">sign up</a> to continue</p>

        <br><br><br><br><h2>" Learn continually,<br> there's always one more thing to learn! "</h2>
        
    <?php endif; ?>
   
   
    
    
</body>
</html>
    
    
    
    
    
    
    
    
    
    
    