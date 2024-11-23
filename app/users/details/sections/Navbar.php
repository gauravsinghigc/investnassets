<ul class="contact-info">
    <?php
    foreach (MENU as $Key => $Menu) {
        if (isset($_GET['get'])) {
            if ($_GET['get'] == $Menu) {
                $ActiveView = $Key;
                $_SESSION['USER_DASHBOARD'] = $ActiveView;
            } else {
                $ActiveView = "";
            }
        } else {
            if (isset($_SESSION['USER_DASHBOARD'])) {
                $ActiveView = $_SESSION['USER_DASHBOARD'];
            } else {
                $ActiveView = "dashboard.php";
                $_SESSION['USER_DASHBOARD'] = $ActiveView;
            }
        }
        if ($ActiveView == $Key) {
            $Active = "active";
        } else {
            $Active = "";
        }
    ?>
        <li class="text-left <?php echo $Active; ?>">
            <a href="?get=<?php echo $Menu; ?>"><?php echo $Menu; ?></a>
        </li>
    <?php } ?>
</ul>