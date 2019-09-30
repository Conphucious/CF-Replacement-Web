<?php

include('session.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach($_POST as $postID => $content) {}
    header('location: edit.php?id=' . $postID);
} else {
    $page = '<table width="95%" cellspacing="0" cellpadding="0" border="0"><tbody><form method="POST"><tr valign="top"><td>';
    $tableData = $db -> query("SELECT * FROM posts WHERE end_date ORDER BY post_date DESC");

    while ($row = $tableData -> fetch_array()) {
        $id = $row['id'];
        $town = $row['town'];
        $sDate = str_replace('-', '/', date("m-d-y", strtotime($row['start_date'])));
        $eDate = str_replace('-', '/', date("m-d-y", strtotime($row['end_date'])));
        $title = $row['title'];
        $content = $row['content'];

        $script = "location.href = 'delete.php?id=" . $id . "';";

        $page = $page . '<hr /><i>' . $id . '</i> | <b>' . $town . '</b> posted on <u>' . $row['post_date'] . '</u><hr />' . '<p class="lightblue">' . $sDate . ' - ' . $eDate . ':&nbsp;&nbsp;' . $title . '</p>' . $content . '<br /><br />' . '<input type="submit" value="edit" name="' . $id  . '"> &nbsp<input type="button" value="delete" id="' . $id  . '" onClick="' . $script . '" >' . '<br /><br />';
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
                    <h1 class="mt-4">All Posts</h1>
                    <?php echo $page; ?>
                </div>
            </div>

        </div>
    </body>
</html>
