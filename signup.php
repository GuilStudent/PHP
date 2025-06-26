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
    <style>
        body {
            font-size: 2;
            display: grid;
            justify-content: center;
        }

        .login-form {
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
            border: 5px solid rgb(0, 0, 0);
            width: 600px;
            border-radius: 20px;
            margin: 20px;
        }

        input {
            background-color: white;
            text-align: center;
            width: 50%;
            border-radius: 20px;
            padding: 10px;
            margin: 10px;
        }

        .Signup-form {
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
            border: 5px solid rgb(0, 0, 0);
            width: 600px;
            border-radius: 20px;
            margin: 20px;
        }

        .sign-button {
            cursor: pointer;
            padding: 8px;
        }

        button {
            background-color: #000000;
            color: white;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            border: none;
            cursor: pointer;
            padding: 8px;
            border: 5px solid rgb(0, 0, 0);
            border-radius: 20px;
        }

        .login-button {
            cursor: pointer;
            padding: 8px;
        }
        label, select {
            display: block;
            margin: 10px auto;
            text-align: center;
        }

        select {
            border: 1px solid rgb(0, 0, 0);
            border-radius: 20px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <form action="" method="POST">
        <div class="login-form">
            <img src="https://static.vecteezy.com/system/resources/previews/004/477/572/non_2x/business-woman-elegant-avatar-character-free-vector.jpg"
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