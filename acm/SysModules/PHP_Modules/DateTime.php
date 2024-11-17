<?php
//date formates
function DATE_FORMATES($format, $date)
{
    $newdateformate = $date;
    if ($date == null  || $date == "" || $date == "0000-00-00" || $date == " ") {
        $newdateformate = "No Update";
    } else {
        date_default_timezone_set("Asia/Kolkata");
        $newdateformate = date("$format", strtotime($date));
    }
    return $newdateformate;
}

/**
 * Current Date time 
 * You can call any of these date, time, or both at same time via CONSTANT DECLARATION METHOD
 */
date_default_timezone_set("Asia/Kolkata");
DEFINE("CURRENT_DATE_TIME", date('Y-m-d h:i:s A'));
DEFINE("CURRENT_DATE", date('Y-m-d'));
DEFINE("CURRENT_TIME", date('H:i'));

//function get minutes from two time
function GetMinutes($time2, $time1)
{
    if (strtotime($time1) > strtotime($time2)) {
        list($time1, $time2) = array($time2, $time1);
    }

    $diff_seconds = strtotime($time2) - strtotime($time1);
    $diff_minutes = round($diff_seconds / 60);

    // Example value
    $hours = floor($diff_minutes / 60);
    $remaining_minutes = $diff_minutes % 60;

    if ($diff_minutes == 0) {
        $diff_minute = "Time Over";
    } elseif ($diff_minutes > 0) {
        $hours = abs($hours);
        $remaining_minutes = abs($remaining_minutes);

        $diff_minute = $hours . " hr " . $remaining_minutes . " min over";
    } elseif ($diff_minutes < 0) {
        $diff_minute = $hours . " hr " . $remaining_minutes . " min left";
    }

    return $diff_minute;
}


//converts seconds into hours, minute and seconds
function GetDurations($second)
{

    if ($second == 0 || $second == null) {
        $results = "0 sec";
    } else {
        $hours = floor($second / 3600);  // Calculate hours
        $minutes = floor(($second % 3600) / 60);  // Calculate minutes
        $seconds = $second % 60;  // Calculate seconds

        // Format the results
        $results = '';
        if ($hours > 0) {
            $results .= $hours . " hr ";
        }
        if ($minutes > 0) {
            $results .= $minutes . " min ";
        }
        if ($seconds > 0) {
            $results .= $seconds . " sec";
        }
    }
    return $results;
}

/**
 * @FutureDates()
 * @param string $date:currentDate formate date('Y-m-d')
 * @param string $monthCount: 1, 6, 12 
 */
function FutureDates($date, $monthCount)
{
    // Convert the passed date string to a DateTime object
    $dateObj = new DateTime($date);

    // Clone the original date to calculate different future dates
    $oneMonthLater = clone $dateObj;
    $sixMonthsLater = clone $dateObj;
    $twelveMonthsLater = clone $dateObj;

    // Modify the cloned dates to get the future dates
    $oneMonthLater->modify('+1 month');
    $sixMonthsLater->modify('+6 months');
    $twelveMonthsLater->modify('+12 months');


    if ($monthCount == 12) {
        return $twelveMonthsLater->format('Y-m-d');
    } else if ($monthCount == 6) {
        return $sixMonthsLater->format('Y-m-d');
    } else {
        return $oneMonthLater->format('Y-m-d');
    }
}
