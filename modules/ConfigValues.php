<?php
//get configuration values different from global and primary required details
function AllUserLevels($ColumnName)
{
    $returnValues = []; //return as empty array
    $GetAllConfigLeveles = _DB_COMMAND_("SELECT $ColumnName, config_user_level_name, config_user_level_id  FROM config_user_levels where config_user_level_status='1' ORDER BY config_user_level_order_by DESC", true);
    if ($GetAllConfigLeveles != null) {
        foreach ($GetAllConfigLeveles as $Levels) {
            $returnValues[$Levels->config_user_level_id] = $Levels->$ColumnName . "- (" . $Levels->config_user_level_name . ")";
        }
    } else {
        $returnValues = [];
    }
    return $returnValues;
}

//function to show user level name and short name
function GetUserLevel($LevelId = null)
{
    $LevelSQL = "SELECT * FROM config_user_levels where config_user_level_id='$LevelId'";

    if ($LevelId == null) {
        $Result = "NA";
    } else {
        $LevelName = FETCH($LevelSQL, "config_user_level_name");
        $ShortName = FETCH($LevelSQL, "config_user_level_short_name");

        $Result = $ShortName . " (" . $LevelName . ")";
    }
    return $Result;
}
