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
    <style>
        body {
            font-size: 2;
            display: flex;
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
    <form action="" method="post">
        <div class="Signup-form">
            <img src="https://img.freepik.com/premium-vector/menselijke-hulpbronnen-concept_24911-17949.jpg?semt=ais_hybrid"
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