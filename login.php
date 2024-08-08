<?php 
require 'function.php';

//login
// cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE iduser = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$error = '';

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    // cek username
    if (mysqli_num_rows($result) === 1) {
        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // set session
            $_SESSION["login"] = true;

            header("Location: index.php");
            exit;
        } else {
            $error = 'Username atau Password Anda salah';
        }
    } else {
        $error = 'Username atau Password Anda salah';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Poppins&display=swap" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" crossorigin="anonymous" />
    <script>
        // Display an alert if there's an error
        window.onload = function() {
            <?php if (!empty($error)): ?>
                alert("<?php echo $error; ?>");
            <?php endif; ?>
        }
    </script>
</head>
<body style="background-color: #eee; height: 100vh; font-family: 'Poppins', sans-serif; background: linear-gradient(to top, #fff 10%, rgba(93, 42, 141, 0.4) 90%) no-repeat;">
    <div class="wrapper" style="max-width: 500px; border-radius: 10px; margin: 50px auto; padding: 30px 40px; box-shadow: 20px 20px 80px rgb(206, 206, 206); background: white;">
        <div class="h2 text-center" style="font-family: 'Kaushan Script', cursive; font-size: 3.5rem; font-weight: bold; color: #400485; font-style: italic;">Kasir Sederhana</div>
        <div class="h4 text-muted text-center pt-2" style="font-family: 'Poppins', sans-serif;">Made By Afdhika Syahputra</div>
        <form class="pt-3" method="post">
            <div class="form-group py-2">
                <div class="input-field" style="border-radius: 5px; padding: 5px; display: flex; align-items: center; cursor: pointer; border: 1px solid #400485; color: #400485;">
                    <input type="text" placeholder="Enter your Username" id="inputEmail" name="username" required style="border: none; outline: none; box-shadow: none; width: 100%; padding: 0px 2px; font-family: 'Poppins', sans-serif; " autofocus/>
                </div>
            </div>
            <div class="form-group py-1 pb-2">
                <div class="input-field" style="border-radius: 5px; padding: 5px; display: flex; align-items: center; cursor: pointer; border: 1px solid #400485; color: #400485;">
                    <input type="password" placeholder="Enter your Password" id="inputPassword" name="password" required style="border: none; outline: none; box-shadow: none; width: 100%; padding: 0px 2px; font-family: 'Poppins', sans-serif;" />
                </div>
            </div>
            <button type="submit" name="login" class="btn btn-block text-center my-3" style="border-radius: 20px; background-color: #400485; color: #fff; width: 100%; border: none;">Log in</button>
            <div class="text-center pt-3 text-muted">Not a member? <a href="register.php" style="color: #400485; font-weight: 700;">Register</a></div>
        </form>
    </div>
</body>
</html>
