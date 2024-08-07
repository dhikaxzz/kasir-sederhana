<?php 
require 'function.php';

if( isset($_POST["register"]) ) {

	if( registrasi($_POST) > 0 ) {
		echo "<script>
				alert('user baru berhasil ditambahkan!');
			  </script>";
	} else {
		echo mysqli_error($conn);
	}

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Registrasi</title>
	<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Poppins&display=swap" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" crossorigin="anonymous" />
</head>

<body style="background-color: #eee; height: 100vh; font-family: 'Poppins', sans-serif; background: linear-gradient(to top, #fff 10%, rgba(93, 42, 141, 0.4) 90%) no-repeat;">
    <div class="wrapper" style="max-width: 500px; border-radius: 10px; margin: 50px auto; padding: 30px 40px; box-shadow: 20px 20px 80px rgb(206, 206, 206); background: white;">
        <div class="h2 text-center" style="font-family: 'Kaushan Script', cursive; font-size: 3.5rem; font-weight: bold; color: #400485; font-style: italic;">Kasir Sederhana</div>
        <div class="h4 text-muted text-center pt-2" style="font-family: 'Poppins', sans-serif;">Registrasi Akun</div>
        <form class="pt-3" method="post">
            <div class="form-group py-2">
                <div class="input-field" style="border-radius: 5px; padding: 5px; display: flex; align-items: center; cursor: pointer; border: 1px solid #400485; color: #400485;">
                    <span class="far fa-use p-2" style="position: absolute; z-index: 2; left: 1rem; top: 50%; transform: translateY(-50%); color: #aaa;"></span>
                    <input type="text" placeholder="Username" name="username" id="username" required style="border: none; outline: none; box-shadow: none; width: 100%; padding: 0px 2px; font-family: 'Poppins', sans-serif; " autofocus/>
                </div>
            </div>
            <div class="form-group py-1 pb-2">
                <div class="input-field" style="border-radius: 5px; padding: 5px; display: flex; align-items: center; cursor: pointer; border: 1px solid #400485; color: #400485;">
                    <span class="fas fa-lock p-2" style="position: absolute; z-index: 2; left: 1rem; top: 50%; transform: translateY(-50%); color: #aaa;"></span>
                    <input type="password" placeholder="Password" name="password" id="password" required style="border: none; outline: none; box-shadow: none; width: 100%; padding: 0px 2px; font-family: 'Poppins', sans-serif;"/>
                </div>
            </div>
            <div class="form-group py-1 pb-2">
                <div class="input-field" style="border-radius: 5px; padding: 5px; display: flex; align-items: center; cursor: pointer; border: 1px solid #400485; color: #400485;">
                    <span class="fas fa-lock p-2" style="position: absolute; z-index: 2; left: 1rem; top: 50%; transform: translateY(-50%); color: #aaa;"></span>
                    <input type="password" placeholder="Confirm Password" id="password2" name="password2" required style="border: none; outline: none; box-shadow: none; width: 100%; padding: 0px 2px; font-family: 'Poppins', sans-serif;" />
                </div>
            </div>
            <div class="d-flex align-items-start" style="margin-top: 1rem;">
                <div class="remember" style="position: relative; padding-left: 30px; cursor: pointer;">
                    </label>
                </div>
            </div>
            <button type="submit" name="register" value="Register!" class="btn btn-block text-center my-3" style="border-radius: 20px; background-color: #400485; color: #fff; width: 100%; border: none;">Register</button>
            <div class="text-center pt-3 text-muted">Have you registered? <a href="login.php" style="color: #400485; font-weight: 700;">Sign in</a></div>
        </form>
    </div>
</body>
</html>