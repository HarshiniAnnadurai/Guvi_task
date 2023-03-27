<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            if (mysqli_num_rows($result) == 1) {

                // The user's name and email are valid, so create a login session using Redis...
                // Redis can be connected in linux easily. If we use windows, redis server can be used...
                // by installing wsl (windows subsystem for linux). The other way is to use a redis...
                // driver with the languages we prefer. I have used Predis driver (i.e) php with redis...
                // driver
              
                //Connect to Predis...
                $redis = new Predis\Client();
                echo "Connected to Redis Successfully!";
                //Produce a unique Id
                $sessionId = uniqid();
                $redis->set($sessionId, $name);
              
                // Set the session ID as a cookie in the user's browser (local storage).
                setcookie('sessionId', $sessionId, time()+3600, '/', '', false, true);
            }
            header("Location: profile.html");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    
    <h1>Login</h1>
    
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    
    <form id="login-form">
        <label for="email">Email</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <br>
        <button style="color: aliceblue; background-image: linear-gradient(to right, #DA22FF 0%, #9733EE  51%, #DA22FF  100%)" data-color1="#DA22FF" data-color2="#9733EE">Log in</button>
    </form>
    <script src="js\login.js"></script>
</body>
</html>