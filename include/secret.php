<?php
if (!defined("ENTRY")) exit("Invalid Entry Point");

session_start();

if (!empty($_POST['secret'])) {
    if ($_POST['secret'] == SECRET) {
        $_SESSION['allowed'] = true;
    }
}


if (empty($_SESSION['allowed'])) {
    echo '
        <div class="form">
            <form action="" method="post">
                Tell me a secret: <input type="password" name="secret"/>
                <input type="submit" value="Enter!"/>
            </form>
        </div>
        ';
    return false;
}
return true;