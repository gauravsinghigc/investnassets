<div class="row">
    <div class="col-md-12">
        <div class="flex-s-b">
            <h6 class="app-heading w-75 mb-0">Address Details</h6>
            <button type='button' onclick="Databar('AddMoreAddress')" class='btn btn-sm ml-1 w-25 btn-block btn-danger'><i class='fa fa-plus'></i> Add More</button>
        </div>
    </div>
    <div class="col-md-12 mt-2">
        <div class='row'>
            <?php
            $UserId = $REQ_UserId;
            $AddressSQL = "SELECT * FROM user_addresses where UserAddressUserId='$REQ_UserId' ORDER BY UserAddressId DESC";
            $GetAllAddressRecords = _DB_COMMAND_($AddressSQL, true);
            if ($GetAllAddressRecords != null) {
                foreach ($GetAllAddressRecords as $Address) { ?>
                    <form class='col-md-12 mb-2' action="<?php echo CONTROLLER; ?>" method="POST">
                        <?php FormPrimaryInputs(true, [
                            "UserId" => $REQ_UserId,
                            "UserAddressId" => $Address->UserAddressId
                        ]); ?>
                        <div class="shadow-sm p-2 b-r-1">
                            <h5 class="app-sub-heading">Update <?php echo $Address->UserAddressType; ?> Address</h5>
                            <div class='row'>
                                <div class="form-group col-lg-12 col-md-12 col-12">
                                    <label>Street Address</label>
                                    <input type='text' name='UserStreetAddress' value='<?php echo SECURE($Address->UserStreetAddress, "d"); ?>' class='form-control'>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-12">
                                    <label>Sector/Locality/Area/Landmark</label>
                                    <input type="text" name="UserLocality" value='<?php echo $Address->UserLocality; ?>' class="form-control">
                                </div>
                                <input type='hidden' name='UserCountry' value='<?php echo $Address->UserCountry; ?>'>
                                <div class="form-group col-lg-6 col-md-6 col-12">
                                    <label>State</label>
                                    <select class="state form-control SelectedState" name="UserState" onchange='GetStateCities()'>
                                        <?php echo InputOptions(STATES_OPTIONS, $Address->UserState); ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-12">
                                    <label>City</label>
                                    <input type="text" name="UserCity" value='<?php echo $Address->UserCity; ?>' class="form-control">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-12">
                                    <label>Pincode</label>
                                    <input type="text" name="UserPincode" value='<?php echo $Address->UserPincode; ?>' class="form-control">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-12">
                                    <label>Address Type</label>
                                    <select class="form-control " name="UserAddressType">
                                        <?php echo InputOptions(["PERMANENT", "CURRENT"], $Address->UserAddressType); ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-12">
                                    <label>Contact Person At Address</label>
                                    <input type="text" name="UserAddressContactPerson" value='<?php echo $Address->UserAddressContactPerson; ?>' class="form-control">
                                </div>
                                <div class='col-md-12 text-right'>
                                    <hr>
                                    <?php echo CONFIRM_DELETE_POPUP(
                                        "address",
                                        [
                                            "remove_address_record" => true,
                                            "UserAddressId" => $Address->UserAddressId
                                        ],
                                        null,
                                        "<i class='fa fa-trash'></i> Remove Address",
                                        "btn btn-xs pull-left text-danger"
                                    ); ?>
                                    <button type='submit' name='UpdateUserAddress' class='btn btn-xs btn-primary'><i class='fa fa-check-circle'></i> Update Address</button>
                                </div>
                            </div>
                        </div>
                    </form>
            <?php }
            } ?>
        </div>
    </div>
</div>