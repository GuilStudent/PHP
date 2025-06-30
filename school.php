<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<?php
require_once("partials/maindb.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete']) && isset($_POST['username'])) {
        $lusername = $_POST['username'];
        if (empty($lusername)) {
        $echo = "<br><h4 style='color: red;'>Fill in the forms.</h4>";
        } else {
        $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
        $stmt->bind_param("s", $lusername);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $echo = "<br><h4 style='color: green;'>User '" . $lusername . "' has been deleted.</h4>";   
            } else {
                $echo = "<br><h4 style='color: red;'>User Not Found.</h4>";
            }
        }

        $stmt->close();
    }
}
}

if (isset($_POST['update']) && isset($_POST['ueusername']) && isset($_POST['uepassword'])) {
        $ueusername = $_POST['ueusername'];
        $uepassword = sha1($_POST['uepassword']);
        if (empty($ueusername) || empty($uepassword)) {
        $echo = "<br><h4 style='color: red;'>Fill in the forms.</h4>";
        } else {

        $check = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $check->bind_param("s", $ueusername);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $uepassword, $ueusername);

            if ($stmt->execute()) {
                $echo = "<br><h4 style='color: green;'>'" . $ueusername . "' Updated</h4>";
            } else {
                $echo = $stmt->error;
            }

            $stmt->close();
        } else {
            $echo = "<br><h4 style='color: red;'>User Not Found.</h4>";
        }

        $check->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School</title>
    <link rel="stylesheet" href="css/school.css">
</head>
<body>
<form action="" method="post">
<div class="h1">Welcome, <?php echo $_SESSION['username'] ?></div><img src="img/user.jpg" width="80" height="80"></img>
<p></p>
<div class="button-group">
<a href="logout.php" class="button">Logout</a>
</div>

<input type="text" name="username" placeholder="Username">
<button type="submit" name="delete" class="button">Delete User</button>
<p></p>
<input type="text" name="ueusername" placeholder="Username">
<input type="text" name="uepassword" placeholder="Password">
<button type="submit" name="update" class="button">Update User</button>
<p></p>
<?php if (!empty($echo)) echo $echo; ?>
<p></p>
<?php
require_once("partials/maindb.php");

$sql = "SELECT username, password FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $count = 1;
  while($row = $result->fetch_assoc()) {
    echo "Persoon " . $count . ": " . $row["username"] . "<br>";
    $count++;
  }
} else {
  die("Geen personenen gevonden!");
}

$conn->close();
?>
</form>
</body>
</html>