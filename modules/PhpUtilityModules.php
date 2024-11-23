<?php
//return check, uncheck, selected or not selected

function ReturnSelectionStatus($Value = null)
{
    if ($Value == true || $Value == 1 || $Value == "1" || $Value == "Active" || $Value == "active" || $Value === 1 || $Value === "1") {
        return "checked";
    } else {
        return "";
    }
}
