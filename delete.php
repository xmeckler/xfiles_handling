<?php
/**
 * Created by PhpStorm.
 * User: wilder17
 * Date: 08/05/18
 * Time: 10:44
 */
if (!empty($_POST['fileName'])) {
    if (is_dir($_POST['fileName'])) {
        rmdir($_POST['fileName']);
    } else {
        unlink($_POST['fileName']);
    }
    header('Location: index.php');
    exit();
}
