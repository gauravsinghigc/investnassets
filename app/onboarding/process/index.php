<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/app/onboarding/headers/HeaderRequests.php';

//pagevariables
$PageName = "Step $NextForm : " . ONBOARDING_MENUS[$NextForm]['name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <?php include $Dir . "/assets/HeaderFiles.php"; ?>
</head>

<body>
  <?php include $Dir . "/app/onboarding//headers/Header.php"; ?>

  <section class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="flex-s-b">
          <?php
          $NameCondition = 0;
          foreach (ONBOARDING_MENUS as $Keys => $OnBoardingMenus) {
            $NameCondition++;
            $StepName = "";
            if (isset($_SESSION['NEXT_FORM_STATUS'])) {
              if ($Keys == $_SESSION['NEXT_FORM_STATUS']) {
                $ActiveStep = "active";
              } else {
                $ActiveStep = "";
              }
            } else {
              if ($NameCondition == 1) {
                $ActiveStep = "active";
              } else {
                $ActiveStep = "";
              }
            }
            if ($NextForm != 7) { ?>
              <span class='onboarding-steps <?php echo $ActiveStep; ?>'>
                <span class='count <?php echo $ActiveStep; ?>'><?php echo $OnBoardingMenus['count']; ?></span>
                <span class='step'><?php echo $OnBoardingMenus['name']; ?></span>
              </span>
          <?php }
          } ?>
        </div>
      </div>
    </div>
  </section>

  <section class="container pb-5 mb-5">
    <?php
    include "sections/" . ONBOARDING_MENUS[$NextForm]['include'];
    ?>
  </section>

  <?php
  include $Dir . "/include/forms/Add-Education-Details.php";
  include $Dir . "/include/forms/Add-Work-Experiences.php";
  include $Dir . "/include/forms/Add-User-Address.php";
  include $Dir . "/app/onboarding/headers/FooterRights.php";
  include $Dir . "/assets/FooterFiles.php";
  ?>

</body>

</html>