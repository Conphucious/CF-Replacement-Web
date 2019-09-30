<?php

include('session.php');

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['dbtn'])) {
        $startDate = $_POST['sDate'];
        $endDate = $_POST['eDate'];

        if ($startDate != '' && $endDate != '') {
            $sDater = date("Y-m-d H:i:s",strtotime($startDate));
            $eDater = date("Y-m-d 23:59:59",strtotime($endDate));

            $tableData = $db -> query("DELETE FROM posts WHERE post_date BETWEEN '$sDater' AND '$eDater';");


            echo $sDater . '-----' . $eDater;

            $error = '<div style="color:#cc0000; margin-top:10px">*Posts by Date deleted! ' . $town . ' - ' . date('m/d/Y h:i:s a', time())  . '</div>';
        } else {
            $error = '<div style="color:#cc0000; margin-top:10px">*Invalid dates!</div>';
        }
    } else {

        $id = $_POST['id'];
        $id = rtrim($id, ',');

        if ($id != '') {
            $ids = explode (",", $id);
            foreach ($ids as $value) {
                $tableData = $db -> query("DELETE FROM posts WHERE id = '$value';");
                $error = '<div style="color:#cc0000; margin-top:10px">*Posts by ID deleted! ' . $town . ' - ' . date('m/d/Y h:i:s a', time())  . '</div>';
            }
        } else {
            $error = '<div style="color:#cc0000; margin-top:10px">*Invalid entry of IDs!</div>';
        }

        echo $id;
    }

} else {
    $error = '';
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
                    <h1 class="mt-4">Delete posts</h1><hr><br><br>

                    <?php echo $error; ?>
                    <form method="POST">
                        <p>
                            <h3>Delete by Post Date</h3><br>
                            Start Date: <input type="date" name="sDate">&emsp;
                            End Date: <input type="date" name="eDate">&emsp;&emsp;
                            <input type="submit" name="dbtn" value="Delete by Date">
                        </p>

                        <br><hr><br><br>

                        <p>
                            <h3>Delete by ID</h3><br>
                            Post ID: <input type="textfield" name="id">
                            <input type="submit" value="Delete"> &emsp;&emsp;&emsp;&emsp;(Example: 1,2,3)
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
