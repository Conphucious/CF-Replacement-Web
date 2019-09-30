<?php

include('session.php');

$adminp = $db -> query("SELECT is_admin FROM users WHERE id = '$id';");

while ($r = $adminp -> fetch_array()) {
    if ($r['is_admin'] == 0) {
        $_SESSION['logMsg'] = 'You need to administrative privileges to access this form! Redirecting...';
        $_SESSION['url'] = 'dashboard.php';
        header("refresh:0;url=redirect.php");
    }
}


$error = '<div style="color:#cc0000; margin-top:10px">Register an account</div>';
$checkbox = '<input type="checkbox" name="isAdmin"';

if (isset($_POST['isAdmin']))
    $checkbox = $checkbox . 'value="1" checked >';
else
    $checkbox = $checkbox . 'value="0" >';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $cpassword = mysqli_real_escape_string($db, $_POST['cpassword']);
    $isAdmin = mysqli_real_escape_string($db, $_POST['isAdmin']);

    if ($isAdmin == 0)
        $isAdmin = 0;
    else
        $isAdmin = 1;

    if (!preg_match("/^[a-zA-Z0-9]*$/", $username))
        $error = '<div style="color:#cc0000; margin-top:10px">Only numbers and letters for usernames are allowed.</div>';
    elseif (strlen($username) > 45)
        $error = '<div style="color:#cc0000; margin-top:10px">Username must be less than 45 characters.</div>';
    elseif (strlen($password) < 4 || strlen($password) > 25)
        $error = '<div style="color:#cc0000; margin-top:10px">password must be longer than 4 and less than 25 characters.</div>';
    elseif ($password != $cpassword)
        $error = '<div style="color:#cc0000; margin-top:10px">Passwords do not match.</div>';
    elseif (mysqli_num_rows(mysqli_query($db, "SELECT id FROM users WHERE username = '$username'")) == 1)
        $error = '<div style="color:#cc0000; margin-top:10px">Username already in use.</div>';
    else {
        $pass = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $db -> prepare("INSERT INTO users(username, password, is_admin) VALUES('$username', '$pass', $isAdmin)");

        if($stmt -> execute()) {
            $error = '<div style="color:#cc0000; margin-top:10px">Account successfully registered - ' . date('m/d/Y h:i:s a', time()) . '</div>';
        } else
        $error = "Something went wrong. Please try again later.";
        $stmt -> close();
    }
}

$db -> close();

?>

<html>
	  <head>
		    <title>SCWA Tool - Register an Account</title>
		</head>
		<table width="100%" height="100%" cellpadding="4" cellspacing="0" border="0" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
				<tr>
					  <td>&nbsp;</td>
					  <td width="500" align="center" valign="middle">
						    <fieldset style="font-weight:bold; background-color: white"><br>
								    <p align="center"><img src="images/logo.png" /></p>
								    <p align="center">
                        <?php echo $error; ?>
                    </p>

								    <form name="login" method="post">
									      <table width="80%" cellpadding="4" cellspacing="0" border="0" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                            <tr>
                                <td width="20%">Admin Privileges</td>
											          <td width="20%"><?php echo $checkbox; ?></td>
											          <td width="20%" align="right">Username:</td>
											          <td width="20%"><input name="username" type="text" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" /></td>
										        </tr>
										        <tr>
											          <td align="right">Password:</td>
											          <td><input name="password" type="password" /></td>
                                <td align="right">Confirm Password:</td>
											          <td><input name="cpassword" type="password" /></td>
											          <td>&nbsp;</td>
										        </tr>
										        <tr>
                                <td>&nbsp;</td>
                                <td colspan="3" align="right"><input name="Submit" id="Submit"  type="submit" value="Register" /></td>
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
