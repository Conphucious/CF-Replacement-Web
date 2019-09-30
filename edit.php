<?php

include('session.php');
$id = $_GET['id'];
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $town = $_POST['town'];
    $startDate = $_POST['sDate'];
    $endDate = $_POST['eDate'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // check date is valid between one another
    if ($town != '' && $startDate != '' && $endDate != '' && $title != '' && $content != '') {
        $sDate = implode("-", array_reverse(explode("/", $startDate)));
        $eDate = implode("-", array_reverse(explode("/", $endDate)));

        $results = $db -> query("UPDATE posts SET town = '$town', start_date = '$sDate', end_date='$eDate', title = '$title', content = '$content' WHERE id = '$id';");
        $error = '<div style="color:#cc0000; margin-top:10px">Announcement has been edited at ' . date('m/d/Y h:i:s a', time()) . '</div>';
    } else {
        $error = '<div style="color:#cc0000; margin-top:10px">A field is left blank.</div>';
    }
} else {
    $tableData = $db -> query("SELECT * FROM posts WHERE id = '$id'");
    while ($row = $tableData -> fetch_array()) {
        $town = $row['town'];
        $startDate = $row['start_date'];
        $endDate = $row['end_date'];
        $title = $row['title'];
        $content = $row['content'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>SCWA Tool - Maintenance Announcement</title>
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/simple-sidebar.css" rel="stylesheet">
    </head>

    <body>
        <div class="d-flex" id="wrapper">
            <?php include('nav.php'); ?>
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom"></nav>

                <div class="container-fluid">
                    <h1 class="mt-4">Edit a Post</h1><hr><?php echo $error; ?>
                    <br><br>
                    <form method="POST">
                        <p align="left">
                            Town:
                            <?php
                            $filename = 'files/towns.txt';
                            $eachlines = file($filename, FILE_IGNORE_NEW_LINES);
                            echo '<select name="town">';
                            foreach($eachlines as $lines){
                                if ($town == $lines)
                                    echo '<option value="' . $town . '" selected="selected" hidden="hidden">' . $town . '</option>';
                                else
                                    echo '<option value="' . $lines . '">' . $lines . '</option>';
                            }
                            echo '</select>';
                            ?>&emsp;&emsp;
                            Start Date: <input type="date" value=<?php echo $startDate; ?> name="sDate">&emsp;&emsp;
                            End Date: <input type="date" value=<?php echo $endDate; ?> name="eDate"><br><br>
                        </p>
                        <hr><br>

                        Heading<br><input type="text" value=<?php echo $title; ?> name="title">
                        <br><br>
                        Content
                        <p><textarea name="content" rows="10" style="width: 60%"><?php echo $content; ?></textarea></p><br>
                        <p align="left">
                            <input name="Submit" type="submit" value="Edit Announcement" />&emsp;
                            <input type="button" value="Cancel" onClick="location.href = 'history.php';" />
                        </p>
                    </form>

                </div>

            </div>
    </body>

</html>
