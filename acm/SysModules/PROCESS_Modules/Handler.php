<?php


//controller request
function CONTROLLER($controllername = null)
{

    if ($controllername == null) {
        $controller = CONTROLLER;
    } else {
        $controller = DOMAIN . "/handler/" . $controllername;
    }

    return $controller;
}

//Request Handler
function RequestHandler($Response, array $results)
{
    RESPONSE($Response, $results['true'], $results['false']);
}

//Handler Delete Requests
function DeleteReqHandler($valid, array $Requestings, array $feedback = [false])
{
    $access_url = SECURE($_GET['access_url'], "d");
    $CheckStatus = SECURE($_GET["$valid"], "d");

    if ($CheckStatus == true) {
        foreach ($Requestings as $key => $value) {
            $Response = DELETE_FROM("$key", "$value");
        }
    } else {
        $Response = false;
    }
    return RESPONSE($Response, $feedback['true'], $feedback['false']);
}

//function HandleInvalidData()
function HandleInvalidData($Data, $redirectto)
{
    if ($Data == null || $Data == '' || $Data == false || $Data == " ") {
        header("location: $redirectto");
    }
}
