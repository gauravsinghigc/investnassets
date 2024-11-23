<div class="row">
    <div class='col-md-12'>
        <div class="shadow-sm p-2 b-r-1">
            <form action='<?php echo CONTROLLER; ?>' method='POST' class="row">
                <?php echo FormPrimaryInputs(true, [
                    "UserId" => $UserId,
                    "OnboardingId" => $OnBoardingRequestedBy
                ]); ?>
                <div class='col-md-5'>
                    <div class="shadow-sm p-2 b-r-1">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class='app-heading'>Review Login Id & Password!</h4>
                                <div class='col-md-12 form-group'>
                                    <label>Login Email-Id (Username)</label>
                                    <input readonly type='email' name='UserEmailId' value='<?php echo FETCH($UserSQL, "UserEmailId"); ?>' class='form-control'>
                                </div>
                                <div class="form-group col-md-12 col-sm-12">
                                    <label class="w-100">Current Password </label>
                                    <input type="text" class="form-control" value='<?php echo FETCH($UserSQL, "UserPassword"); ?>' readonly>
                                </div>
                                <hr>
                                <h5 class="app-sub-heading">Change Password?</h5>
                                <div class="form-group col-md-12 col-sm-12">
                                    <label class="w-100">Enter New Password </label>
                                    <input type="password" name="UserPasswordNEW" oninput="checkpass()" id="pass1" class="form-control">
                                </div>
                                <div class="form-group col-md-12 col-sm-12">
                                    <label>Re-Enter New Password</label>
                                    <input type="password" name="UserPassword_2" oninput="checkpass()" id="pass2" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <span style="font-size:1rem;"><span id="passmsg"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-md-7'>
                    <div class="shadow-sm p-2 b-r-1">
                        <h4 class='app-heading'>Applicable Company Policies</h4>
                        <?php

                        //check user access wise available policies
                        $GetUserAllowedAccess = _DB_COMMAND_("SELECT * FROM user_access where UserAccessUserId='$UserId' GROUP BY UserAccessName", true);
                        if ($GetUserAllowedAccess != null) {

                            //get all accessible policies
                            foreach ($GetUserAllowedAccess as $Access) {
                                $UserAccessName = $Access->UserAccessName;
                                $CompanyPolicy = _DB_COMMAND_("SELECT * FROM company_policy_applicable_on where ApplicableGroupName='$UserAccessName'", true);

                                //get applicable company policies
                                foreach ($CompanyPolicy as $Policy) {
                                    $PolicyMainId = $Policy->PolicyMainId;

                                    //GET POLICY DETAILS
                                    $PolicySQL = "SELECT * FROM company_policies where PolicyId='$PolicyMainId'";
                        ?>
                                    <div class='data-list flex-s-b'>
                                        <div class='w-pr-70'>
                                            <span class='text-grey'>Policy Name</span><br>
                                            <b class='text-info fs-17'><?php echo FETCH($PolicySQL, "PolicyName"); ?></b>
                                        </div>
                                        <div class='w-pr-30 text-right pt-1'>
                                            <a onclick="Databar('view_company_policy_<?php echo $PolicyMainId; ?>')" class='btn btn-md fs-10 btn-primary'>Read Policy</a>
                                        </div>
                                    </div>
                        <?php
                                    include $Dir . "/include/forms/View-Company-Policy.php";
                                }
                            }
                        } else {
                            echo NoData("No Company Policy Found!");
                        }
                        ?>
                    </div>

                </div>

                <div class='col-md-12 text-right'>
                    <hr>
                    <a href="?back_to=5" class='btn btn-md btn-default'><i class='fa fa-angle-left'></i> Back to Previous</a>
                    <button type='submit' name='CONTINUE_AND_SUBMIT' class='btn btn-success '><i class='fa fa-check'></i> Complete & Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function checkpass() {
        var pass1 = document.getElementById("pass1");
        var pass2 = document.getElementById("pass2");
        if (pass1.value === pass2.value) {
            document.getElementById("passbtn").classList.remove("disabled");
            document.getElementById("passmsg").classList.add("text-success");
            document.getElementById("passmsg").classList.remove("text-danger");
            document.getElementById("passmsg").innerHTML = "<i class='fa fa-check-circle'></i> Password Matched!";
        } else {
            document.getElementById("passmsg").classList.remove("text-success");
            document.getElementById("passmsg").classList.add("text-danger");
            document.getElementById("passbtn").classList.add("disabled");
            document.getElementById("passmsg").innerHTML = "<i class='fa fa-warning'></i> Password do not matched!";
        }
    }
</script>