<?php

include('session.php');

$error = 'Please login to the platform using your assigned credentials.';

if (isset($_SESSION['login_id']))
    header("refresh:0;url=dashboard.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $row = ($db -> query("SELECT id, password FROM users WHERE username = '$username'")) -> fetch_array();

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['login_id'] = $row['id'];
            $URL = 'dashboard.php';
            echo "<script type='text/javascript'>document.location.href='dashboard.php';</script>";
        } else
        $error = '<div style="color:#cc0000; margin-top:10px">Username or password is invalid</div>';
    } else
    $error = '<div style="color:#cc0000; margin-top:10px">A field is left blank.</div>';
}

$db -> close();

?>

<html>
	  <head>
		    <title>SCWA MA Tool - Index</title>
		</head>
    <body>
		    <table width="100%" height="100%" cellpadding="4" cellspacing="0" border="0" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
				    <tr>
					      <td>&nbsp;</td>
					      <td width="500" align="center" valign="middle">
						        <fieldset style="font-weight:bold; background-color: white"><br>
								        <p align="center">
                            <img src="images/logo.png" />
                        </p>
								        <p align="center">
                            <?php echo $error; ?>
                        </p>

								        <form method="post">
									          <table width="80%" cellpadding="4" cellspacing="0" border="0" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
										            <tr>
											              <td width="35%" align="right">Username:</td>
											              <td width="40%"><input name="username" type="text" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" /></td>
											              <td width="25%"></td>
										            </tr>
										            <tr>
											              <td align="right">Password:</td>
											              <td><input name="password" type="password" /></td>
											              <td>&nbsp;</td>
										            </tr>
										            <tr>
                                    <td colspan="3" align="center"><input name="Submit" type="submit" value="Login" /></td>
										            </tr>
									          </table>
								        </form>

							      </fieldset>
							      <?php include('footer.php'); ?>
					      </td>
					      <td>&nbsp;</td>
				    </tr>
		    </table>
		</body>
</html>
