<section class="pop-section hidden" id="AddMoreAddress">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Add New Address</h4>
                </div>
            </div>
            <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true, [
                    "UserId" => $UserId,
                ]); ?>
                <div class="form-group col-lg-12 col-md-12 col-12">
                    <label>Street Address</label>
                    <input type='text' name='UserStreetAddress' class='form-control'>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-12">
                    <label>Sector/Locality/Area/Landmark</label>
                    <input type="text" name="UserLocality" class="form-control">
                </div>
                <input type='hidden' name='UserCountry' value='India'>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>State</label>
                    <select class="state form-control SelectedState" name="UserState" onchange='GetStateCities()'>
                        <?php echo InputOptions(STATES_OPTIONS, "Select State"); ?>
                    </select>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>City</label>
                    <input type="text" name="UserCity" class="form-control">
                </div>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Pincode</label>
                    <input type="text" name="UserPincode" class="form-control">
                </div>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Address Type</label>
                    <select class="form-control " name="UserAddressType">
                        <?php echo InputOptions(["PERMANENT", "CURRENT"], "PERMANENT"); ?>
                    </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-12">
                    <label>Contact Person At Address</label>
                    <input type="text" name="UserAddressContactPerson" class="form-control">
                </div>

                <div class='col-md-12 text-right'>
                    <hr>
                    <a onclick="Databar('AddMoreAddress')" class="btn btn-md btn-default mr-3">Cancel</a>
                    <button type="submit" name="ADD_MORE_ADDRESS" class='btn btn-md btn-success'><i class='fa fa-check'></i> Save Address</button>
                </div>
            </form>
        </div>
    </div>
</section>