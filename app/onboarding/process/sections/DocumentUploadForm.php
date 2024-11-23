<div class='row'>
    <div class='col-md-12'>
        <div class='shadow-sm p-2 b-r-1'>
            <form class='row' action='<?php echo CONTROLLER; ?>' method='POST' enctype="multipart/form-data">
                <?php echo FormPrimaryInputs(true, [
                    "UserId" => $UserId,
                    "OnboardingId" => $OnBoardingRequestedBy
                ]); ?>
                <div class="col-md-12 text-center">
                    <p class="p-2 text-danger"><?php echo REQUIRED; ?> mark input fields are mandatory, please upload relevant documents per document type, documents submitted here can't be updated, its only updated by HR after final submission!</p>
                </div>
                <div class='col-md-4 form-group'>
                    <div class="shadow-sm p-2 b-r-1">
                        <h4 class='app-heading'>Upload Profile Photo </h4>
                        <?php
                        $CheckProfilePhoto = FETCH($UserSQL, "UserProfileImage");
                        if ($CheckProfilePhoto == "default.png") { ?>
                            <?php echo UploadImageInput("UserProfileImage", "ProfileImage", "image/*", true, "form-control", "", "Upload Passport size photo <span class='text-secondary'>(image: png, jpeg)</span>" . REQUIRED); ?>
                        <?php } else { ?>
                            <h6>Profile Photo</h6>
                            <img src="<?php echo GetUserImage($UserId); ?>" class="imgrpreview">
                        <?php } ?>
                    </div>
                </div>
                <div class='col-md-4 form-group'>
                    <div class="shadow-sm p-2 b-r-1">
                        <h4 class='app-heading'>Upload ID & Address Proof</h4>
                        <?php
                        $PanCardStatus = FETCH($UserDocumentSQL . " and UserDocumentName='PANCARD'", "UserDocumentFile");
                        if ($PanCardStatus == null) { ?>
                            <?php echo UploadImageInput("PanCard", "pancard", "image/*", true, "form-control", "", "Pan Card <span class='text-secondary'>(image: png, jpeg)</span>" . REQUIRED); ?>
                        <?php } else { ?>
                            <h6>Pan Card</h6>
                            <img src="<?php echo STORAGE_URL . "/teams/documents/$UserId/" . $PanCardStatus; ?>" class="imgrpreview">
                        <?php }
                        $AadhaarCardStatus = FETCH($UserDocumentSQL . " and UserDocumentName='ADHAAR-CARD'", "UserDocumentFile");
                        if ($AadhaarCardStatus == null) { ?>
                            <?php echo UploadImageInput("AdhaarCard", "adharcard", "image/*", true, "form-control", "", "Adhaar Card <span class='text-secondary'>(image: png, jpeg)</span>" . REQUIRED); ?>
                        <?php } else { ?>
                            <hr>
                            <h6>Aadhaar Card</h6>
                            <img src="<?php echo STORAGE_URL . "/teams/documents/$UserId/" . $AadhaarCardStatus; ?>" class="imgrpreview">
                        <?php } ?>
                    </div>
                </div>
                <div class='col-md-4 form-group'>
                    <div class="shadow-sm p-2 b-r-1">
                        <h4 class='app-heading'>Other Documents</h4>
                        <div class="form-group">
                            <label>10th Mark sheet <span class='text-secondary'> <?php echo REQUIRED; ?> (any: image, docs, pdf)</span></label>
                            <input type='FILE' required name='10_TH_CERTIFICATE' class='form-control'>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>12th Mark sheet <span class='text-secondary'> <?php echo REQUIRED; ?> (any: image, docs, pdf)</span></label>
                            <input type='FILE' required name='12_TH_CERTIFICATE' class='form-control'>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Diploma/Degree/Graduation <span class='text-secondary'>(Optional) (any: image, docs, pdf)</span></label>
                            <input type='FILE' name='GRADUATION_CERTIFICATE' class='form-control'>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Upload Resume <span class='text-secondary'>(Optional) (any: image, docs, pdf)</span></label>
                            <input type='FILE' name='SUBMITTED_RESUME' class='form-control'>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Cancel Cheque <span class='text-secondary'>(Optional) (any: image, docs, pdf)</span></label>
                            <input type='FILE' name='CANCEL_CHEQUE' class='form-control'>
                        </div>
                        <br>
                        <h4 class='app-sub-heading'>Upload Multiple Other Documents</h4>
                        <div class="form-group">
                            <label>Other Documents <span class='text-secondary'>(any: image, docs, pdf)</span></label>
                            <input type='FILE' name='OTHER_DOCUMENTS[]' multiple="" class='form-control'>
                        </div>
                    </div>
                </div>
                <div class='col-md-12 text-right'>
                    <hr>
                    <a href="?back_to=4" class='btn btn-md btn-default'><i class='fa fa-angle-left'></i> Back to Previous</a>
                    <button type='submit' name='CONTINUE_FOR_LOGIN_AND_SECURITY' class='btn btn-success'>Upload & Continue <i class='fa fa-angle-right'></i></button>
                </div>
            </form>
        </div>
    </div>
</div>