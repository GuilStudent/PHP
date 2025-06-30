<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lusername = $_POST["username"];
    $lpassword = sha1($_POST["password"]);
    if (empty($lusername) || empty($lpassword)) {
        $echo = "<br><h4 style='color: red;'>fill in forms</h4>";
    } else if (strlen($lusername) > 20 && strlen($lpassword) > 20) {
        $echo = "<br><h4 style='color: red;''>Username and password cant be more than 20</h4>";
    } else if (strlen($lusername) < 3 && strlen($lpassword) < 3) {
        $echo = "<br><h4 style='color: red;''>Username and password cant be less than 3</h4>";
    } else {
        require_once("partials/maindb.php");
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $lusername, $lpassword);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
        $_SESSION['username'] = $lusername;
        header('Location: school.php');
        $echo = "</h4>Successfull login!</h4>";
        } else {
        $echo = "<br><h4 style='color: red;'>Invalid username or password</h4>";
        }

        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <form action="" method="post">
        <div class="Signup-form">
            <img src="img/user1.avif"
                width="100" height="100">
            <h1>Login</h1>
            <input name="username" text="username" placeholder="username">
            <input type="password" name="password" text="password" placeholder="password">
            <?php if (!empty($echo)) echo $echo; ?>
            <div class="sign-button">
                <button type="submit">Submit</button>
            </div>
        </div>
    </form>
</body>

</html>