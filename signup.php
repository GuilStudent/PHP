<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$lusername = $_POST["username"];
$lpassword = sha1($_POST["password"]);
if (empty($lusername) || empty($lpassword)) {
    $echo = "<br><h4 style='color: red;''>fill in forms</h4>";
} else if (strlen($lusername) > 20 && strlen($lpassword) > 20) {
    $echo = "<br><h4 style='color: red;''>Username and password cant be more than 20</h4>";
} else if (strlen($lusername) < 3 && strlen($lpassword) < 3) {
    $echo = "<br><h4 style='color: red;''>Username and password cant be less than 3</h4>";
}
else if ($lusername && $lpassword == true) {
    require_once("partials/maindb.php");
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $lusername, $lpassword);
    if ($stmt->execute()) {
        header('Location: login.php');
        $echo = "<br>Je bent geregistreerd";
        $stmt->close();
        $conn->close();
        die();
    } else {
        $echo = "<br>Er was een error met signup";
    }
 //   $stmt->close();
  //  $conn->close();
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up Page</title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <form action="" method="POST">
        <div class="login-form">
            <img src="img/user2.jpg"
                width="100" height="100">
            <h1>Register</h1>
            <input name="username" text="username" placeholder="username">
            <input type="password" name="password" text="password" placeholder="password">
            <div>
            <?php if (!empty($echo)) echo $echo; ?>
            </div>
            <div class="login-button">
                <button type="submit">Submit</button>
            </div>
        </div>
    </form>
</body>

</html>