<?php
if(isset($_POST['content'])) {
    $fileToOpen = "files/" . $_POST['fileName'];
    $fileToEdit = fopen($fileToOpen, "w");
    fwrite($fileToEdit, $_POST['content']);
    fclose($fileToEdit);
}
?>
<?php include('inc/head.php'); ?>

    <h2>Folder tree:</h2>
    <ul>
        <?php
        $xfiles = scandir("files");
        foreach ($xfiles as $xfile) {
            if (!in_array($xfile, array(".", ".."))) {
                echo '<li><a href="?f=' . $xfile . '">' . $xfile . '</a>';
                if (is_dir("files/$xfile")) {
                    echo "<ul>";
                    $subdirs = scandir("files/$xfile");
                    foreach ($subdirs as $subdir) {
                        if (!in_array($subdir, array(".", ".."))) {
                            echo '<li><a href="?f=' . $xfile . "/" . $subdir . '">' . $subdir . '</a>';
                            if (is_dir("files/$xfile/$subdir")) {
                                echo "<ul>";
                                $subsubdirs =scandir("files/$xfile/$subdir");
                                foreach ($subsubdirs as $subsubdir) {
                                    if (!in_array($subsubdir, array(".", ".."))) {
                                        echo '<li><a href="?f=' . $xfile . "/" . $subdir . "/" . $subsubdir . '">' . $subsubdir . '</a></li>';
                                    }
                                }
                                echo "</ul>";
                            }
                        }
                        echo "</li>";
                    }
                    echo "</ul>";
                }
                echo "</li>";
            }
        }
        ?>
    </ul>

<?php
if (isset($_GET["f"])) :
$file = "files/" . $_GET["f"];
$content = file_get_contents($file);
?>

    <form method="post" action="index.php">
        <div class="form-group">
            <textarea name="content" class="form-control textEdition">
                <?php
                if (in_array(mime_content_type($file), array('text/plain', 'text/html'))) {
                    echo $content ;
                } else {
                    echo "Only text files can be edited (.txt/.html)";
                }
                ?>
            </textarea>
        </div>
        <input type="hidden" name="fileName" value="<?= $_GET["f"];?>" />
        <div class="form-group">
            <button type="submit" class="btn btn-default">Edit</button>
        </div>
    </form>
<?php
endif;
?>


<?php include('inc/foot.php'); ?>