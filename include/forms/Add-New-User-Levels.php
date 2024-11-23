<section class="pop-section hidden" id="AddUserLevels">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Add User Level</h4>
                </div>
            </div>
            <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                <?php echo FormPrimaryInputs(true); ?>
                <div class="col-md-4 form-group">
                    <?php echo LABEL("Level Name", true); ?>
                    <input type='text' name='config_user_level_name' class="form-control" required>
                </div>
                <div class="col-md-4 form-group">
                    <?php echo LABEL("Level Short Name", true); ?>
                    <input type='text' name='config_user_level_short_name' class="form-control" required>
                </div>
                <div class="col-md-4 form-group">
                    <?php echo LABEL("Yearly Target", true); ?>
                    <input type='number' name='config_user_level_yearly_target' class="form-control" required>
                </div>
                <div class="col-md-4 form-group">
                    <?php echo LABEL("Order By", true); ?>
                    <input type='number' min='1' name='config_user_level_order_by' class="form-control" required>
                </div>
                <div class="col-md-4 form-group">
                    <?php echo LABEL("Level Status", true); ?>
                    <select name='config_user_level_status' class="form-control" required>
                        <?php echo InputOptionsWithKey(
                            [
                                "0" => "Inactive", "1" => "Active", "" => "Select Status"
                            ],
                            ""
                        ); ?>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <?php echo LABEL("Select Upper Level", true); ?>
                    <select name='config_user_upper_level' class="form-control">
                        <?php
                        $AllUserLevels = _DB_COMMAND_("SELECT config_user_level_id, config_user_level_name, config_user_level_short_name, config_user_level_yearly_target from config_user_levels ORDER BY config_user_level_id DESC", true);
                        if ($AllUserLevels == null) {
                            echo "<option value=''>No Upper Level Found!</option>";
                        } else {
                            foreach ($AllUserLevels as $Level) {
                                echo "<option value='" . $Level->config_user_level_id . "'>" . $Level->config_user_level_name . " @ " . $Level->config_user_level_short_name . " - Rs." . $Level->config_user_level_yearly_target . "/yearly </option>";
                            }
                        } ?>
                    </select>
                </div>

                <div class='col-md-12 text-right'>
                    <hr>
                    <button type='submit' name='SaveUserLevels' class='btn btn-primary'>Add Level</button>
                    <button type='reset' class='btn btn-default'>Reset</button>
                    <button type='button' class='btn btn-default' onclick='Databar("AddUserLevels")'>Cancel</button>
                </div>
            </form>
        </div>
    </div>
</section>