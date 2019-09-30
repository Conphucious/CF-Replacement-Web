<?php

include('session.php');

$page = '<table width="95%" cellspacing="0" cellpadding="0" border="0">
    <tbody>
        <tr valign="top">
            <td><hr />';

$tableData = $db -> query("SELECT * FROM posts WHERE
end_date >= CURDATE() AND (start_date <= CURDATE() OR show_now = 1)
ORDER BY post_date DESC");

while ($row = $tableData -> fetch_array()) {

    $town = $row['town'];
    $sDate = str_replace('-', '/', date("m-d-y", strtotime($row['start_date'])));
    $eDate = str_replace('-', '/', date("m-d-y", strtotime($row['end_date'])));
    $title = $row['title'];
    $content = $row['content'];

    $page = $page . '<b>' . $town . '</b><hr />' . '<p class="lightblue">' . $sDate . ' - ' . $eDate . ':&nbsp;&nbsp; 		' . $title . '</p>' . $content . ' 		<br /><br />';

}

$page = $page . '</td>
        </tr>
    </tbody>
</table>';

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
                    <h1 class="mt-4">Announcement Overview</h1>

                    <?php echo $page; ?>
                    <textarea style="height: 0px;
                                     width: 0px;
                                     overflow: hidden;
                                     position: absolute;" id="temp">
                        <?php echo $page; ?>
                    </textarea>

                    <p><input type="button" value="Copy to Clipboard" onclick="copy()" /></p>
                </div>
            </div>

        </div>

        <script>
         function copy() {
             var copyText = document.getElementById("temp");
             copyText.select();
             document.execCommand("copy");
             alert("Copied announcements.")
             //alert("Copied the text: " + copyText.value);
         }
        </script>
    </body>

</html>
