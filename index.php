<?php
if(isset($_POST['content'])) {
    $file = "files/roswell/maj-marcel.txt";
}
?>
<?php include('inc/head.php'); ?>

    <h2>Folder tree:</h2>
    <ul>
        <?php
        $xfiles = scandir("files");
        foreach ($xfiles as $xfile) {
            if (!in_array($xfile, array(".", ".."))) {
                echo "<li>" . $xfile ;
                if (is_dir("files/$xfile")) {
                    echo "<ul>";
                    $subdirs = scandir("files/$xfile");
                    foreach ($subdirs as $subdir) {
                        if (!in_array($subdir, array(".", ".."))) {
                            echo "<li>".$subdir;
                            if (is_dir("files/$xfile/$subdir")) {
                                echo "<ul>";
                                $subsubdirs =scandir("files/$xfile/$subdir");
                                foreach ($subsubdirs as $subsubdir) {
                                    if (!in_array($subsubdir, array(".", ".."))) {
                                        echo "<li>" . $subsubdir . "</li>";
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
$file = "files/roswell/maj-marcel.txt";
$content = file_get_contents($file);
?>

    <form method="post" action="index.php">
        <div class="form-group">
            <textarea name="content" class="form-control"><?php echo $content ;?></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </form>

    C'est ici que tu vas devoir afficher le contenu de tes repertoires et fichiers.

<?php include('inc/foot.php'); ?>