<?php

include('session.php');

$error = '';

$checkbox = '<input type="checkbox" name="showNow"';

if (isset($_POST['showNow'])) {
    $checkbox = $checkbox . 'value="1" checked >';
    $showNow = 1;
} else {
    $checkbox = $checkbox . 'value="0" >';
    $showNow = 0;
}

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

        $tableData = $db -> query("INSERT INTO posts (town, start_date, end_date, title, content, user_id, show_now) VALUE ('$town', '$sDate', '$eDate', '$title', '$content', '$userId', '$showNow')");

        $error = '<div style="color:#cc0000; margin-top:10px">*added post for ' . $town . ' at ' . date('m/d/Y h:i:s a', time())  . '</div>';
        $startDate = '';
        $endDate = '';
        $title = '';
        $content = '';
    } else {
        $error = '<div style="color:#cc0000; margin-top:10px">*A field is left blank.</div>';
    }
} else {
    $town = '';
    $startDate = '';
    $endDate = '';
    $title = '';
    $content = '';
}

$db -> close();
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
                    <h1 class="mt-4">Add a Post</h1><hr><?php echo $error; ?>
                    <br><br>
                    <form method="POST">
                        <p align="left">
                            Town:
                            <?php
                            //https://en.wikipedia.org/wiki/List_of_municipalities_on_Long_Island
                            $filename = 'files/towns.txt';
                            $eachlines = file($filename, FILE_IGNORE_NEW_LINES);//create an array
                            echo '<select name="town">';
                            foreach($eachlines as $lines){
                                if ($town == $lines)
                                    echo '<option value="' . $town . '" selected="selected" hidden="hidden">' . $town . '</option>';
                                else
                                    echo '<option value="' . $lines . '">' . $lines . '</option>';
                            }
                            echo '</select>';
                            ?>

                            &emsp;&emsp;
                            Start Date: <input type="date" name="sDate"value=<?php echo $startDate; ?>>&emsp;&emsp;
                            End Date: <input type="date" name="eDate" value=<?php echo $endDate; ?>>
                            <br><br>
                        </p>
                        <hr><br>

                        Heading<br>
                        <!-- <input type="text" name="title" value=<?php echo $title; ?>> -->
                        <?php
                        $filename = 'files/headings.txt';
                        $eachlines = file($filename, FILE_IGNORE_NEW_LINES);
                        echo '<select name="title">';
                        foreach($eachlines as $lines){
                            if ($title == $lines)
                                echo '<option value="' . $title . '" selected="selected" hidden="hidden">' . $title . '</option>';
                            else
                                echo '<option value="' . $lines . '">' . $lines . '</option>';
                        }
                        echo '</select>';
                        ?>

                        &emsp;&emsp;Show post now: <?php echo $checkbox; ?>
                        <br><br>
                        Content
                        <p><textarea name="content" rows="10" style="width: 60%"><?php echo $content; ?></textarea></p><br>
                        <p align="left"><input type="submit" value="Submit Announcement" /></p>
                    </form>

                </div>

            </div>
    </body>

</html>
