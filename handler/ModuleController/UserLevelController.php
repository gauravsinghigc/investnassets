<?php

//save user levels
if (isset($_POST['SaveUserLevels'])) {
    $config_user_levels = [
        "config_user_level_name" => $_POST['config_user_level_name'],
        "config_user_level_short_name" => $_POST['config_user_level_short_name'],
        "config_user_level_yearly_target" => $_POST['config_user_level_yearly_target'],
        "config_user_level_created_at" => CURRENT_DATE_TIME,
        "user_user_level_updated_at" => CURRENT_DATE_TIME,
        "config_user_level_created_by" => LOGIN_UserId,
        "config_user_level_updated_by" => LOGIN_UserId,
        "config_user_level_status" => $_POST['config_user_level_status'],
        "config_user_level_order_by" => $_POST['config_user_level_order_by'],
        "config_user_upper_level" => $_POST['config_user_upper_level'],
    ];

    //check if level already exists
    $AlreadyExits = CHECK("SELECT * FROM  config_user_levels where  config_user_level_short_name='" . $_POST['config_user_level_short_name'] . "'");
    if ($AlreadyExits == null) {
        $Save = INSERT("config_user_levels", $config_user_levels);
    } else {
        $Save = false;
    }
    RESPONSE($Save, "User level details are saved successfully!", "Unable to save user level details at the moment!");

    //update user levels
} elseif (isset($_POST['UpdateUserLevels'])) {
    $config_user_level_id = SECURE($_POST['config_user_level_id'], "d");

    $config_user_levels = [
        "config_user_level_name" => $_POST['config_user_level_name'],
        "config_user_level_short_name" => $_POST['config_user_level_short_name'],
        "config_user_level_yearly_target" => $_POST['config_user_level_yearly_target'],
        "user_user_level_updated_at" => CURRENT_DATE_TIME,
        "config_user_level_updated_by" => LOGIN_UserId,
        "config_user_level_status" => $_POST['config_user_level_status'],
        "config_user_level_order_by" => $_POST['config_user_level_order_by'],
        "config_user_upper_level" => $_POST['config_user_upper_level'],
    ];
    $Save = UPDATE_DATA("config_user_levels", $config_user_levels, "config_user_level_id ='$config_user_level_id'");
    RESPONSE($Save, "User level details are updated successfully!", "Unable to update user level details at the moment!");

    //remove user level
} elseif (isset($_GET['remove_user_config_levels'])) {
    $config_user_level_id = SECURE($_GET['config_user_level_id'], "d");
    DeleteReqHandler("remove_user_config_levels", [
        "config_user_levels" => "config_user_level_id='$config_user_level_id'"
    ], [
        "true" => "User level is removed successfully!",
        "false" => "Unable to remove user level!"
    ]);
}
