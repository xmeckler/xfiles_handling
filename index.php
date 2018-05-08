<?php
if(isset($_POST['content'])) {
    $fileToOpen = "files/" . $_POST['fileName'];
    $fileToEdit = fopen($fileToOpen, "w");
    fwrite($fileToEdit, $_POST['content']);
    fclose($fileToEdit);
}
?>
<?php include('inc/head.php'); ?>

    <h3>Folder tree:</h3>
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
    <h3>Edit selected file: <?= $_GET["f"];?></h3>
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



    <h3>Delete selected file or directory: <?= $_GET["f"];?></h3>
    <?php
    if (isset($_GET["f"])) {
        $submit = "submit";
        if (is_dir("files/" . $_GET["f"])) {
            if (!empty(scandir("files/" . $_GET["f"]))) {
                $submit = "hidden";
                echo '<p>This directory is not empty and cannot be deleted: first delete every file in this directory</p>';
            } else {
                echo '<p>' . $_GET["f"] .  'is an empty directory</p>';
            }
        } else {
        echo '<p>By pressing the delete button, the selected file will be destroyed</p>';
        }
    }
    ?>
    <form method="post" action="delete.php">

        <input type="hidden" name="fileName" value="<?= "files/" . $_GET["f"];?>" />
        <div class="form-group">
            <input type="<?= $submit;?>" class="btn btn-info" value="Delete">
        </div>
    </form>


<?php
endif;
?>


<?php include('inc/foot.php'); ?>