<?php
function UserLevelDetails($id, $column)
{
    $CheckUsers = CHECK("SELECT $column FROM config_user_levels where config_user_level_id='$id'");
    if ($CheckUsers == null) {
        return null;
    } else {
        $GetData = FETCH("SELECT $column FROM config_user_levels where config_user_level_id='$id'", "$column");
        return $GetData;
    }
}
