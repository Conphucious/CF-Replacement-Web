<?php

include('session.php');

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tableData = $db -> query("DELETE FROM posts WHERE id = '$id';");
    header('location: history.php');
} else {
    $page = '<table width="95%" cellspacing="0" cellpadding="0" border="0"><tbody><form method="POST"><tr valign="top"><td>';
    $tableData = $db -> query("SELECT * FROM posts WHERE id = '$id';");

    while ($row = $tableData -> fetch_array()) {
        $id = $row['id'];
        $town = $row['town'];
        $sDate = str_replace('-', '/', date("m-d-y", strtotime($row['start_date'])));
        $eDate = str_replace('-', '/', date("m-d-y", strtotime($row['end_date'])));
        $title = $row['title'];
        $content = $row['content'];
        $postDate = $row['post_date'];

        $script = "location.href = 'delete.php?id=" . $id . "';";

        $page = $page . '<br />ID: <code>' . $id . '</code><br />
Town: <code>' . $town . '</code><br />
Start Date: <code>' . $sDate . '</code><br />
End Date: <code>' . $eDate . '</code><br />
Header: <code>' . $title . '</code><br />
Content: <code>' . $content . '</code><br />';
    }
    $page = $page . '</td></tr></form></tbody></table>';
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
                    <h1 class="mt-4">Delete Post from <i><?php echo $postDate; ?></i></h1>
                    <?php echo $page; ?><br /><br />
                    <form method="POST">
                        <input type="submit" value="Delete Post">
                        <input type="button" value="Cancel" onClick="location.href = 'history.php';">
                    </form>
                </div>
            </div>

        </div>
    </body>
</html>
