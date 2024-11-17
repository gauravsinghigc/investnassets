<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Move Data";
$PageDescription = "Manage all customers";
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
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("customers").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php

    include $Dir . "/include/app/Header.php";
    include $Dir . "/include/sidebar/get-side-menus.php";
    include $Dir . "/include/app/Loader.php"; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="app-heading mb-1">Move Data</h3>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-3">
                      <form action="" method="GET">
                        <input type="hidden" name="GetLeadsFrom" value="true">
                        <h5 class="app-sub-heading">Fetch Data From</h5>
                        <div class="row">
                          <div class="form-group col-md-12 mb-2">
                            <label>Fetch Data From</label>
                            <select class="form-control" name="From" onchange="form.submit()">
                              <?php
                              $Users = _DB_COMMAND_("SELECT * FROM users ORDER BY UserFullName ASC", true);
                              foreach ($Users as $User) {
                                if ($User->UserId == IfRequested("GET", "From", LOGIN_UserId, false)) {
                                  $selected = "selected";
                                } else {
                                  $selected = "";
                                }
                                echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . " - " . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $User->UserId . "'", "UserEmpGroupName") . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="mt-2">
                          <button type="submit" name="GetLeadsFrom" value="true" class="btn btn-md btn-dark"><i class="fa fa-refresh"></i> Fetch Data Records</button>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-6">
                      <h5 class="app-sub-heading">Available Data</h5>
                      <?php

                      if (isset($_GET['GetLeadsFrom'])) {
                        $GetLeadsFrom = $_GET['GetLeadsFrom'];
                        $From = $_GET['From'];

                        //run last requested parameters and get data accordingly
                      } else {
                        $GetLeadsFrom = '';
                        $From = '';
                      }
                      ?>
                      <form>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="flex-s-b">
                              <div class="form-group w-100">
                                <label>Search Person</label>
                                <input type="search" oninput="SearchData('searching_leads', 'lead-lists')" id='searching_leads' placeholder="Enter Full Name" value='<?php echo IfRequested("GET", "search_leads", "", false); ?>' class="form-control " list="LeadPersonFullname" name="search_leads" onchange="form.submit()">
                                <input type='hidden' name='From' value='<?php echo IfRequested("GET", "From", "", FALSE); ?>'>
                                <input type='hidden' name='GetLeadsFrom' value='<?php echo IfRequested("GET", "GetLeadsFrom", "", FALSE); ?>'>
                                <?php SQL_SUGGEST("SELECT * FROM data_leads where LeadPersonManagedBy='$From' ORDER BY LeadPersonFullname ASC", "LeadPersonFullname"); ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      <?php
                      //get lead data
                      $start = START_FROM;
                      $listcounts = DEFAULT_RECORD_LISTING;

                      $SQL = "SELECT * FROM data_lead_uploads WHERE LeadsUploadedfor='$From' ORDER by leadsUploadId DESC";
                      $GetLeads = _DB_COMMAND_($SQL . " limit $start, $listcounts", true);
                      $Count = SERIAL_NO;
                      ?>
                      <form action="<?php echo CONTROLLER; ?>" method="POST">
                        <?php FormPrimaryInputs(true, [
                          "From" => IfRequested("GET", "From", 0, false),
                        ]); ?>
                        <?php
                        if ($GetLeads == null) {
                          NoData("No Data Found!");
                        } else {
                          echo "
                          <h6 class='mb-2 mt-0 ml-2 bold'>
                          Select Data for move : <b class='text-danger'>Total <b>" . TOTAL("SELECT * FROM data_lead_uploads WHERE LeadsUploadedfor='$From' ORDER by leadsUploadId DESC") . "</b> Data found!</b>
                          </h6>
                          <div class='row'>";
                          foreach ($GetLeads as $leads) {
                            $Count++;
                            $LeadsId = $leads->leadsUploadId;
                            include "../../../include/common/send-data-list.php";
                          }
                          echo "</div>";
                        }
                        ?>
                    </div>
                    <div class="col-md-3">
                      <h5 class="app-sub-heading">Move Data In</h5>
                      <?php if (isset($_GET['From'])) { ?>
                        <div class="form-group">
                          <label>Move data From</label>
                          <?php echo GetUserDetails($From); ?>
                        </div>
                        <div class="form-group">
                          <label>Move data In</label>
                          <select class="form-control" name="MoveIn">
                            <?php
                            $Users = _DB_COMMAND_("SELECT * FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
                            foreach ($Users as $User) {
                              if ($User->UserId == LOGIN_UserId) {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              }
                              echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . " - " . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $User->UserId . "'", "UserEmpGroupName") . "</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Bulk Number of data</label>
                          <input type='number' name='NumberOfLeads' value='0' class='form-control form-control-sm' min='0' max='<?php echo $TotalItems + 1; ?>'>
                        </div>
                        <div class="form-group">
                          <label>Order Of Selection</label>
                          <select name='OrderOfSelection' class='form-control form-control-sm'>
                            <option value='DESC' selected>Order of Selection</option>
                            <option value='ASC'>Old Data</option>
                            <option value='DESC' selected>New Data</option>
                          </select>
                        </div>
                        <div class="mt-2">
                          <button type="submit" onclick="form.submit()" name="MoveData" class="btn btn-md btn-success"> Move Data <i class="fa fa-exchange"></i></button>
                        </div>
                      <?php } else { ?>
                        <p>Please fetch some leads firsts..</p>
                      <?php } ?>
                    </div>
                    </form>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mx-auto">
                      <?php PaginationFooter(TOTAL($SQL), "data.php?From=" . $From . "&GetLeadsFrom=true"); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </section>
    </div>

    <?php
    include $Dir . "/include/app/Footer.php"; ?>
  </div>
  <script>
    function CallStatusFunction() {
      var statustype = document.getElementById("statustype");
      <?php
      $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
      if ($FetchCallStatus != null) {
        foreach ($FetchCallStatus as $CallStatus) { ?>
          if (statustype.value == <?php echo $CallStatus->ConfigValueId; ?>) {
            document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>").style.display = "block";
            document.getElementById("leasstatus").value = "<?php echo $CallStatus->ConfigValueDetails; ?>";
          } else {
            document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>").style.display = "none";
          }
      <?php }
      } ?>
    }
  </script>
  <script>
    function CallStatusFunction_2() {
      var statustype = document.getElementById("statustype_2");
      <?php
      $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
      if ($FetchCallStatus != null) {
        foreach ($FetchCallStatus as $CallStatus) { ?>
          if (statustype.value == <?php echo $CallStatus->ConfigValueId; ?>) {
            document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>_2").style.display = "block";
            document.getElementById("leasstatus2").value = "<?php echo $CallStatus->ConfigValueDetails; ?>";
          } else {
            document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>_2").style.display = "none";
          }
      <?php }
      } ?>
    }
  </script>
  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>