<?php
session_start();
header('refresh:2;url="' . $_SESSION['url'] .'"');
?>

<div style = "font-size:15px; color:#cc0000; margin-top:10px" align="center">
                                                                   <img src="https://www.clipartmax.com/png/middle/296-2962834_royal-crown-of-a-king-vector-king-crown-logo-hd.png">
                                                                           <br>
<?php echo $_SESSION['logMsg']; ?>
                                                                                </div


<?php
    unset($_SESSION['url']);
unset($_SESSION['logMsg']);
?>
