<?php
require __DIR__ . "/../acm/SysFileAutoLoader.php";
require __DIR__ . "/../acm/SystemReqHandler.php";

$FetchRegistrations = _DB_COMMAND_("SELECT * FROM bookings ORDER BY bookingId DESC", true);
if ($FetchRegistrations != null) {
    foreach ($FetchRegistrations as $booking) {
        $BookingAckCode = $booking->BookingAckCode;
        $bookingId = $booking->bookingId;

        //testing
        UPDATE("UPDATE registrations SET RegCustomRefId='$bookingId' where RegAcknowledgeCode='$BookingAckCode'");
    }
}
