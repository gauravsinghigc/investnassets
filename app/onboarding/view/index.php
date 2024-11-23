<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';

$PageName = "Candidate Profile @ ";

//store profile key in session
if (isset($_GET['viewfor'])) {
    $_SESSION['viewfor'] = SECURE($_GET['viewfor'], "d");
    $user_onboarding_id  = $_SESSION['viewfor'];
} else {
    if (isset($_SESSION['viewfor'])) {
        $user_onboarding_id  = $_SESSION['viewfor'];
    } else {
        $user_onboarding_id = null;
    }
}
HandleInvalidData($user_onboarding_id, "../../");

//get all SQL where onboarding details are saved which is filled by candidate
$OnboardingSQL = "SELECT * FROM user_onboarding where users_main_id='$user_onboarding_id'";
$OnBoardingId = FETCH($OnboardingSQL, "user_onboarding_id");
$UserId = FETCH($OnboardingSQL, "users_main_id");
$REQ_UserId = $UserId;
$UserSQL = "SELECT * FROM users where UserId='$UserId'";
$UserAddressSQL = "SELECT * FROM user_addresses where UserAddressUserId='$UserId'";
$UserAccessSQL = "SELECT * FROM user_access where UserAccessUserId='$UserId'";
$UserAltSQL = "SELECT * FROM user_alternate_contact_details where uacd_main_user_id='$UserId'";
$BankSql = "SELECT * FROM user_bank_details where UserMainId='$UserId'";
$UserDocuments = "SELECT * FROM user_documents WHERE UserMainId='$UserId'";
$EduSQL = "SELECT * FROM user_educational_details where ued_main_user_id='$UserId'";
$EmpSql = "SELECT * FROM user_employment_details where UserMainUserId='$UserId'";
$WorkSQL = "SELECT * FROM user_work_experiences where uwe_main_user_id='$UserId'";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $PageName; ?> <?php echo APP_NAME; ?></title>
    <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
    <meta name="keywords" content="<?php echo APP_NAME; ?>">
    <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
    <?php include $Dir . "/assets/HeaderFiles.php"; ?>
</head>

<body>
    <section class='shadow-sm p-2 b-r-1'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-3'>
                    <div class='shadow-sm p-2 b-r-1'>
                        <img src="<?php echo GetUserImage($UserId); ?>" style='width:100%;' class='img-fluid'>
                    </div>
                </div>
                <div class='col-md-9'>
                    <div class='shadow-sm p-2 b-r-1'>
                        <h4 class='text-primary bold'>
                            <?php echo FETCH($UserSQL, "UserSalutation"); ?>
                            <?php echo FETCH($UserSQL, "UserFullName"); ?>
                        </h4>
                        <h5>
                            <i class='fa fa-phone text-success'></i>
                            <?php echo FETCH($UserSQL, "UserPhoneNumber"); ?> <span class='text-grey small font-italic fs-12'>+91 is added by system automatically at required sections.</span>
                        </h5>
                        <h5>
                            <i class='fa fa-envelope text-danger'></i>
                            <?php echo FETCH($UserSQL, "UserEmailId"); ?>
                            <?php if ($EmailStatus = FETCH($OnboardingSQL, "user_email_status")) {
                                echo " <span class='text-success fs-10 small font-italic'><i class='fa fa-check'></i> Verified</span";
                            }; ?>
                        </h5>
                        <h5>
                            <i class='fa fa-cake text-warning'></i>
                            <?php echo DATE_FORMATES("d M, Y", FETCH($UserSQL, "UserDateOfBirth")); ?>
                        </h5>
                        <h5>
                            <i class='fa fa-medkit text-danger'></i>
                            <?php echo FETCH($EmpSql, "UserEmpBloodGroup"); ?>
                        </h5>
                        <hr>
                        <div class='row'>
                            <?php
                            $UsersAllAddress = _DB_COMMAND_($UserAddressSQL, true);
                            if ($UsersAllAddress != null) {
                                foreach ($UsersAllAddress as $Address) {
                            ?>
                                    <div class='col-md-6'>
                                        <h6 class='text-primary'><?php echo $Address->UserAddressType; ?> Address</h6>
                                        <p>
                                            <?php echo SECURE($Address->UserStreetAddress, "d"); ?>, <?php echo $Address->UserLocality; ?>,<br> <?php echo $Address->UserCity; ?> <?php echo $Address->UserState; ?>,
                                            <br><?php echo $Address->UserPincode; ?> - <?php echo $Address->UserCountry; ?>
                                            <?php if ($Address->UserAddressContactPerson != "") {
                                                echo "<br>Contact Person: " . $Address->UserAddressContactPerson;
                                            } ?>
                                        </p>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class='row'>
                <div class='col-md-12 mt-3'>
                    <h5 class='text-primary bold b'>Alternate Contact Details</h5>
                    <hr>
                </div>
                <?php
                $AllAltContacts = _DB_COMMAND_($UserAltSQL, true);
                if ($AllAltContacts != null) {
                    foreach ($AllAltContacts as $AltContact) {
                ?>
                        <div class='col-md-3 col-lg-3 col-sm-6 col-6'>
                            <h6 class='mb-0'><?php echo $AltContact->uacd_person_name; ?></h6>
                            <p>
                                <span class='small text-grey'><?php echo $AltContact->uacd_relation; ?></span><br>
                                +91<?php echo $AltContact->uacd_phone_number; ?>
                            </p>
                        </div>
                <?php
                    }
                } ?>
            </div>

            <div class='row'>
                <div class='col-md-12 mt-3'>
                    <h5 class='text-primary bold b'>Education Details</h5>
                    <hr>
                </div>
                <?php
                //Get ALL EDUCATIONAL DETAILS
                $AllEducationalDetails = _DB_COMMAND_($EduSQL, true);
                if ($AllEducationalDetails != null) {
                    foreach ($AllEducationalDetails as $Edu) {
                ?>
                        <div class='col-md-4 mb-2'>
                            <h6 class='text-primary mb-0'><?php echo UpperCase($Edu->ued_title); ?></h6>
                            <p>
                                <span class='strong font-weight-bold'><?php echo $Edu->ued_qualification_type; ?></span><br>
                                <span>Institution: <?php echo $Edu->ued_athority; ?></span><br>
                                <span>Passing Year: <b><?php echo DATE_FORMATES("d M, Y", $Edu->ued_passed_year); ?></b></span><br>
                                <span class='text-grey'>
                                    <?php echo SECURE($Edu->ued_remarks, "d"); ?>
                                </span>
                            </p>
                        </div>
                <?php
                    }
                } ?>
            </div>

            <div class='row'>
                <div class='col-md-12 mt-3'>
                    <h5 class='text-primary bold b'>Work Experiences</h5>
                    <hr>
                </div>
                <?php
                //Get ALL Work Experiences DETAILS
                $AllWorkRecords = _DB_COMMAND_($WorkSQL, true);
                if ($AllWorkRecords != null) {
                    foreach ($AllWorkRecords as $Work) {
                ?>
                        <div class='col-md-4 mb-2'>
                            <h6 class='text-primary mb-0'><?php echo UpperCase($Work->uwe_work_title); ?></h6>
                            <p>
                                <span class='strong font-weight-bold'><?php echo $Work->uwe_employement_type; ?></span><br>
                                <span>Company: <?php echo $Work->uwe_company_name; ?></span><br>
                                <span>Location: <?php echo $Work->uwe_work_location; ?></span><br>
                                <span>
                                    From <b><?php echo DATE_FORMATES("d M, Y", $Work->uwe_start_date); ?></b>
                                    To <b><?php echo DATE_FORMATES("d M, Y", $Work->uwe_end_date); ?></b>
                                </span>
                                <br>
                                <span class='text-grey'>
                                    <?php echo SECURE($Work->uwe_role_and_work_details, "d"); ?>
                                </span>
                            </p>
                        </div>
                <?php
                    }
                } ?>
            </div>

            <div class='row'>
                <div class='col-md-12'>
                    <h5 class='text-primary bold'>Documents</h5>
                    <hr>
                </div>
                <?php
                $AllDocuments = _DB_COMMAND_($UserDocuments, true);
                if ($AllDocuments != null) {
                    foreach ($AllDocuments as $Documents) { ?>
                        <div class='col-md-4 col-lg-4 col-sm -6 col-6 mb-2'>
                            <div class='shadow-sm p-2 b-r-1'>
                                <div class='flex-s-b'>
                                    <h6 class='mb-0 fs-14'><i class='fa fa-file text-warning'></i> <?php echo $Documents->UserDocumentName; ?></h6>
                                    <a class='text-secondary' href="<?php echo STORAGE_URL; ?>/teams/documents/<?php echo $UserId; ?>/<?php echo $Documents->UserDocumentFile; ?>" target="_blank"><i class='fa fa-eye'></i> View</a>
                                </div>
                            </div>
                        </div>
                <?php }
                } else {
                    NoData("No Document found!");
                } ?>
            </div>

            <div class='row'>
                <div class='col-md-12 mt-3'>
                    <h5 class='text-primary bold'>Employement Details</h5>
                    <hr>
                </div>
                <div class="col-md-12">
                    <form action="<?php echo CONTROLLER; ?>" method="POST" class="mt-1">
                        <?php FormPrimaryInputs(true, [
                            "UserId" => $REQ_UserId,
                            "OnboardingId" => $OnBoardingId
                        ]); ?>
                        <div class="row onboarding-form">
                            <div class="col-md-3 form-group">
                                <label>Rera ID (If Have)</label>
                                <input type="text" class="form-control " value="<?php echo FETCH($EmpSql, "UserEmpReraId"); ?>" name="UserEmpReraId">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Reporting Manager</label>
                                <select class="form-control " name="UserEmpReportingMember">
                                    <option value="0">Select Manager</option>
                                    <?php
                                    $Users = _DB_COMMAND_("SELECT * FROM users ORDER BY UserFullName ASC", true);
                                    foreach ($Users as $User) {
                                        if ($User->UserId == FETCH($EmpSql, "UserEmpReportingMember")) {
                                            $selected = "selected";
                                        } else {
                                            $selected = "";
                                        }
                                        echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>CRM Status</label>
                                <select class="form-control " name="UserEmpCRMStatus">
                                    <?php echo InputOptions(["Yes" => "Yes", "No" => "No"], FETCH($EmpSql, "UserEmpCRMStatus")); ?>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Visiting Card</label>
                                <select class="form-control " name="UserEmpVisitingCard">
                                    <?php echo InputOptions(["Yes" => "Yes", "No" => "No"], FETCH($EmpSql, "UserEmpVisitingCard")); ?>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Employee Group </label>
                                <select class="form-control " name="UserEmpGroupName">
                                    <?php echo InputOptionsWithKey(AllUserLevels("config_user_level_short_name"), FETCH($EmpSql, "UserEmpGroupName")); ?>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Employement Type</label>
                                <select class="form-control " name="UserEmpType">
                                    <?php echo CONFIG_VALUES("EMP_TYPE", FETCH($EmpSql, "UserEmpType")); ?>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Work Location</label>
                                <select class="form-control" name="UserEmpLocations">
                                    <?php $GetOfficeLocations = _DB_COMMAND_("SELECT * FROM config_locations where config_location_status='1'", true);
                                    if ($GetOfficeLocations != null) {
                                        foreach ($GetOfficeLocations as $Locations) {
                                            if ($Locations->config_location_id == FETCH($EmpSql, "UserEmpLocations")) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                    ?>
                                            <option value='<?php echo $Locations->config_location_id; ?>' <?php echo $selected; ?>><?php echo $Locations->config_location_name; ?></option>
                                    <?php
                                        }
                                    } else {
                                        echo "<option value='0'>No Location!</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>(OnRole/OffRole) Status</label>
                                <select class="form-control " name="UserEmpRoleStatus">
                                    <?php echo InputOptions(["On Role" => "On Role", "Off Role" => "Off Role"], FETCH($EmpSql, "UserEmpRoleStatus")); ?>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Work Email-ID</label>
                                <input type="email" class="form-control " value="<?php echo FETCH($EmpSql, "UserEmpWorkEmailId"); ?>" name="UserEmpWorkEmailId">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Date of Joining</label>
                                <input type="date" class="form-control " value="<?php echo FETCH($UserSQL, "UserCreatedAt"); ?>" name="UserCreatedAt">
                            </div>
                        </div>
                        <div class="row onboarding-form">
                            <div class="col-md-12">
                                <h5 class='text-primary bold'> Bank Account Details</h5>
                                <hr>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Bank Name</label>
                                <select name='UserBankName' class='form-control' required>
                                    <?php echo InputOptions(BANK_LIST, FETCH($BankSql, "UserBankName")); ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Account Type</label>
                                <select name='UserBankAccountType' class='form-control' required>
                                    <?php echo InputOptions(BANK_ACCOUNT_TYPE_LIST, FETCH($BankSql, "UserBankAccountType")); ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Account No</label>
                                <input type="text" name="UserBankAccountNo" value='<?php echo FETCH($BankSql, "UserBankAccountNo"); ?>' class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>IFSC Code</label>
                                <input type="text" name="UserBankIFSC" value='<?php echo FETCH($BankSql, "UserBankIFSC"); ?>' class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Account Holder Name</label>
                                <input type="text" name="UserBankAccoundHolderName" value='<?php echo FETCH($BankSql, "UserBankAccoundHolderName"); ?>' class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-md-12 text-center'>
                                <hr>
                                <a onclick="Databar('RejectCandidateThroughOnboarding')" class='btn btn-md btn-danger'><i class='fa fa-times'></i> Reject & Remove Candidate</a>
                                <button type='submit' name='SUBMIT_ONBOARDING_STATUS' value='APPROVED' class='btn btn-md btn-success'><i class='fa fa-check'></i> Verify Account & Enable Login</button>
                            </div>
                        </div>
                        <?php include $Dir . "/include/forms/Update-Onboarding-Reject-Status.php"; ?>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php
    include $Dir . "/assets/FooterFiles.php"; ?>
</body>

</html>