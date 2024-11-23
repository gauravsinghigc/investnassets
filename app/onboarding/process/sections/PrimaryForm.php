<form class='row shadow-sm p-2' action='<?php echo CONTROLLER; ?>' method="POST">
    <?php echo FormPrimaryInputs(true, [
        "UserId" => $UserId,
        "OnboardingId" => $OnBoardingRequestedBy
    ]); ?>
    <div class="col-md-12 text-center">
        <p class="text-danger p-2"><i class='fa fa-bell blink-data'></i><?php echo REQUIRED; ?> marked input options are mandatory. disabled values are changed by HR and ADMIN only.</p>
    </div>
    <div class='col-md-4'>
        <h5 class='app-heading'>Primary Details</h5>
        <div class="row">
            <div class="form-group col-lg-3 col-md-4 col-sm-6 col-6">
                <label>Sal *</label>
                <select class="form-control " name="UserSalutation" required="">
                    <?php echo InputOptions(SALUTATION, FETCH($UserSQL, "UserSalutation")); ?>
                </select>
            </div>
            <div class="form-group col-lg-9 col-md-8 col-sm-6 col-6">
                <label>Full Name <?php echo REQUIRED; ?></label>
                <input type="text" name="UserFullName" value="<?php echo FETCH($UserSQL, "UserFullName"); ?>" class="form-control " required="" placeholder="Full Name">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-6 col-12">
                <label>Phone Number <?php echo REQUIRED; ?></label>
                <input type="phone" readonly name="UserPhoneNumber" value="<?php echo FETCH($UserSQL, "UserPhoneNumber"); ?>" class="form-control " value="+91" placeholder="+91">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-6 col-12">
                <label>Primary Email-ID <?php echo REQUIRED; ?></label>
                <input type="email" readonly name="UserEmailId" value="<?php echo FETCH($UserSQL, "UserEmailId"); ?>" class="form-control " required="">
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                <label>Date of Birth <?php echo REQUIRED; ?></label>
                <input type="date" name="UserDateOfBirth" class="form-control " value="<?php echo FETCH($UserSQL, "UserDateOfBirth"); ?>">
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <h5 class="app-heading">Alternate Contact Details</h5>
        <div class='row'>
            <div class='col-md-12 text-right mb-2'>
                <button type='button' class='btn btn-danger btn-xs add-contact'><i class='fa fa-plus'></i> More</button>
            </div>
            <div class='col-md-3 form-group'>
                <label>Relation</label>
                <select name='uacd_relation[]' class="form-control">
                    <?php echo InputOptionsWithKey(
                        HUMAN_RELATIONS,
                        ""
                    ); ?>
                </select>
            </div>
            <div class='col-md-4 form-group'>
                <label>Name</label>
                <input type="text" name="uacd_person_name[]" class="form-control">
            </div>
            <div class='col-md-5 col-12 col-sm-12 form-group'>
                <label>Phone Number</label>
                <input type="number" name="uacd_phone_number[]" minlength="10" maxlength="10" class="form-control">
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class="col-md-12">
            <h4 class='app-heading'>Existing alternate contact details!</h4>

            <div class="row">
                <?php
                $AllAltContacts = _DB_COMMAND_("SELECT * FROM user_alternate_contact_details where uacd_main_user_id='$UserId'", true);
                if ($AllAltContacts == null) {
                    echo NoData("No Alternate Contact found!");
                } else {
                    foreach ($AllAltContacts as $Contacts) {
                ?>
                        <div class='col-md-12'>
                            <div class='data-list flex-s-b'>
                                <div class='w-pr-20'>
                                    <span class='text-grey'>Name</span><br>
                                    <b class='bold text-primary fs-15'><?php echo $Contacts->uacd_person_name; ?></b>
                                </div>
                                <div class='w-pr-30 text-left'>
                                    <span class='text-grey'>Relation</span><br>
                                    <b class='bold text-primary fs-15'><?php echo $Contacts->uacd_relation; ?></b>
                                </div>
                                <div class='w-pr-30 text-left'>
                                    <span class='text-grey'>Phone Number</span><br>
                                    <b class='bold text-primary fs-15'><?php echo $Contacts->uacd_phone_number; ?></b>
                                </div>
                                <div class='w-pr-10 text-right pt-2'>
                                    <?php echo CONFIRM_DELETE_POPUP(
                                        "contacts",
                                        [
                                            "remove_contact_records" => true,
                                            "uacd_id" => $Contacts->uacd_id,
                                        ],
                                        null,
                                        "<i class='fa fa-trash'></i>",
                                        "btn btn-xs btn-danger mt-2"
                                    ); ?>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } ?>
            </div>
        </div>
    </div>
    <div class='col-md-12 text-right pb-5'>
        <hr>
        <button type='submit' name='STEP_TWO_FOR_ADDRESS' class='btn btn-md btn-success'>Continue for Address <i class='fa fa-angle-right'></i></button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $(".add-contact").click(function() {
            var newRow = `<div class='row'>
                                <div class='col-md-3 form-group'>
                                    <label>Relation</label>
                                    <select name='uacd_relation[]' class="form-control">
                                        <?php echo InputOptionsWithKey(
                                            HUMAN_RELATIONS,
                                            ""
                                        ); ?>
                                    </select>
                                </div>
                                <div class='col-md-4 form-group'>
                                    <label>Name</label>
                                    <input type="text" name="uacd_person_name[]" class="form-control">
                                </div>
                                <div class='col-md-5 col-12 col-sm-12 form-group'>
                                    <label>Phone Number</label>
                                    <input type="phone" name="uacd_phone_number[]" minlength="10" maxlength="10"  class="form-control">
                                </div>
                            </div>`;
            $(this).closest('.row').after(newRow);
        });
    });
</script>