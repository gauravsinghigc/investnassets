 <div class='row'>
     <div class="col-md-12">
         <h6 class="app-heading">Primary Info</h6>
     </div>
     <div class="col-md-12">
         <form action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
             <?php FormPrimaryInputs(true, [
                    "UserId" => $REQ_UserId
                ]); ?>
             <div class="row">
                 <div class="col-md-12">
                     <div class="row">
                         <div class="form-group col-lg-1 col-md-2 col-sm-6 col-12">
                             <label>Sal *</label>
                             <select class="form-control " name="UserSalutation" required="">
                                 <?php echo InputOptions(
                                        [
                                            "Mr." => "Mr.",
                                            "Mrs." => "Mrs.",
                                            "Miss." => "Miss.",
                                            "M/s" => "M/s",
                                            "Dr." => "Dr.",
                                            "Prof." => "Prof."
                                        ],
                                        FETCH($PageSqls, "UserSalutation")
                                    ); ?>
                             </select>
                         </div>
                         <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                             <label>User Full Name *</label>
                             <input type="text" name="UserFullName" value="<?php echo FETCH($PageSqls, "UserFullName"); ?>" class="form-control " required="" placeholder="Full Name">
                         </div>
                         <div class="form-group col-lg-3 col-md-4 col-sm-6 col-12">
                             <label>Primary Contact Number *</label>
                             <input type="phone" name="UserPhoneNumber" value="<?php echo FETCH($PageSqls, "UserPhoneNumber"); ?>" class="form-control " value="+91" placeholder="+91">
                         </div>
                         <div class="form-group col-lg-5 col-md-4 col-sm-6 col-12">
                             <label>Primary Contact Email-ID *</label>
                             <input type="email" name="UserEmailId" value="<?php echo FETCH($PageSqls, "UserEmailId"); ?>" class="form-control " required="">
                         </div>
                     </div>

                     <div class="row">
                         <div class="form-group col-lg-4 col-md-4 col-sm-12">
                             <label>User Status</label>
                             <select class="form-control " name="UserStatus">
                                 <?php
                                    if (FETCH($PageSqls, "UserStatus") == 1) { ?>
                                     <option value="1" selected>Active</option>
                                     <option value="0">Inactive</option>
                                 <?php } else { ?>
                                     <option value="1">Active</option>
                                     <option value="0" selected>Inactive</option>
                                 <?php } ?>
                             </select>
                         </div>
                         <div class="form-group col-lg-4 col-md-4 col-sm-12">
                             <label>Date of Birth</label>
                             <input type="date" name="UserDateOfBirth" class="form-control " value="<?php echo FETCH($PageSqls, "UserDateOfBirth"); ?>">
                         </div>
                         <div class="form-group col-lg-12 col-lg-12 col-sm-12">
                             <label>Notes/Remarks</label>
                             <textarea class="form-control " rows="3" name="UserNotes"><?php echo SECURE(FETCH($PageSqls, "UserNotes"), "d"); ?></textarea>
                         </div>
                         <div class="col-md-12">
                             <button type="submit" name="UpdatePrimaryData" class="btn btn-md btn-success"><i class="fa fa-check-circle"></i> Update Details</button>
                         </div>
                     </div>
                 </div>
             </div>
         </form>
     </div>
     <hr>
     <div class="col-md-10">
         <h6 class="app-heading">Address Details</h6>
     </div>
     <div class='col-md-2'>
         <button type='button' onclick="Databar('AddMoreAddress')" class='btn btn-sm btn-block btn-danger'><i class='fa fa-plus'></i> Add More</button>
     </div>
     <div class="col-md-12">
         <div class='row'>
             <?php
                $UserId = $REQ_UserId;
                $AddressSQL = "SELECT * FROM user_addresses where UserAddressUserId='$REQ_UserId' ORDER BY UserAddressId DESC";
                $GetAllAddressRecords = _DB_COMMAND_($AddressSQL, true);
                if ($GetAllAddressRecords != null) {
                    foreach ($GetAllAddressRecords as $Address) { ?>
                     <form class='col-md-6 mb-2' action="<?php echo CONTROLLER; ?>" method="POST">
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