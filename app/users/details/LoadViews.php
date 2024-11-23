<div class="col-md-9">
    <?php if (isset($_GET['get'])) {
        $Views = $_GET['get'];

        //load relative views
        foreach (MENU as $key => $Values) {
            if ($Values == $Views) {
                $_SESSION['USER_DASHBOARD'] = $key;
                $LoadViews = $_SESSION['USER_DASHBOARD'];
                include "views/$key";
            }
        }

        //load default views or dashboard
    } else {
        if (isset($_SESSION['USER_DASHBOARD'])) {
            $LoadViews = $_SESSION['USER_DASHBOARD'];
            include "views/$LoadViews";
        } else {
            include "views/dashboard.php";
        }
    } ?>
</div>