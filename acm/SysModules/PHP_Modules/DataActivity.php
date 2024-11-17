<?php
//remove space
function RemoveSpace($string)
{
    $string = str_replace(' ', '_', $string);
    if ($string == null) {
        return null;
    } else {
        return $string;
    }
}
//remove special characters
function RemoveAllSpecialCharacters($string)
{
    $string = str_replace(' ', '_', $string);
    if ($string == null) {
        return null;
    } else {
        return $string;
    }
}

function removeSpecialCharacter($string, $charToRemove)
{
    // Use str_replace to remove the specified character
    $cleanedString = str_replace($charToRemove, '', $string);
    return $cleanedString;
}

//lowercase all words
function LowerCase($string)
{
    $string = strtolower($string);
    if ($string == null) {
        return null;
    } else {
        return $string;
    }
}

//uppercase all words
function UpperCase($string)
{
    $string = strtoupper($string);
    if ($string == null) {
        return null;
    } else {
        return $string;
    }
}

//GET numbers from strings
function GetNumbers($strings)
{
    if ($strings == null) {
        $return = 0;
    } else {
        $return = intval(preg_replace('/[^0-9]+/', '', $strings), 10);
    }

    return $return;
}

//get string without numbers
function GetStrings($string, $replace = null)
{
    if ($string == null) {
        $returns = "";
    } else {
        $paragraph = $string;
        $special_chars = array("@", "#", "$", "&", "*", "%", "-", "_", "|", "/", "=", "\"", "(", ")", "\"", "\"", "!", "^", "`", "~", ";", ":", "'", "?", "<", ">", ".");

        if ($replace == null) {
            $returns = preg_replace('/\d+/', '', $string);
        } else {
            $returns = str_replace($special_chars, $replace, $paragraph);
        }
    }

    return $returns;
}

//show only limited characters
function LimitText($text, $start, $end)
{
    $LimitText = substr($text, $start, $end) . "...";
    $TotalStringVarChar = strlen($LimitText);
    if ($TotalStringVarChar > $end) {
        $LimitText = substr($text, $start, $end) . "...";
    } else {
        $LimitText = substr($text, $start, $end);
    }
    return $LimitText;
}

//get first word of string
function FirstWord($string)
{
    $start = 0;
    $end = 1;

    $LimitText = substr($string, $start, $end);
    $TotalStringVarChar = strlen($LimitText);
    if ($TotalStringVarChar > $end) {
        $LimitText = substr($string, $start, $end);
    } elseif ($TotalStringVarChar == 0 || $TotalStringVarChar == null || $TotalStringVarChar == "." || $TotalStringVarChar == " ") {
        $LimitText = "O";
    } else {
        $LimitText = substr($string, $start, $end);
    }
    return $LimitText;
}

//replace all variables
function UpperCaseSimilarVariables($DataWhereVariableExits, $ReplaceMatchingPattern)
{
    // Step 1: Retrieve the content from POST


    // Step 2: Define a regular expression to find all variables (assumes variables start with $)
    $special_chars = array(
        "@" => '/\@\w+/',
        "#" => '/\#\w+/',
        "$" => '/\$\w+/',
        "&" => '/\&\w+/',
        "*" => '/\*\w+/',
        "%" => '/\%w+/',
        "-" => '/\-\w+/',
        "_" => '/\_\w+/',
        "|" => '/\|\w+/',
        "/" => '/\/\w+/',
        "=" => '/\=\w+/',
        "\"" => '/\\"\w+/',
        "(" => '/\(\w+/',
        ")" => '/\)\w+/',
        "!" => '/\!\w+/',
        "^" => '/\^\w+/',
        "`" => '/\`\w+/',
        "~" => '/\~\w+/',
        ";" => '/\;\w+/',
        ":" => '/\:\w+/',
        "'" => '/\'\w+/',
        "?" => '/\?\w+/',
        "<" => '/\<\w+/',
        ">" => '/\>\w+/',
        "." => '/\.\w+/'
    );

    foreach ($special_chars as $Key => $SpecialChars) {
        if ($Key == $ReplaceMatchingPattern) {
            $pattern = $SpecialChars;
        }
    }

    // Step 3: Use preg_replace_callback to convert all variable names to uppercase
    $uppercaseContent = preg_replace_callback($pattern, function ($matches) {
        // Step 4: Convert the matched variable to uppercase
        return strtoupper($matches[0]);
    }, $DataWhereVariableExits);

    return $uppercaseContent;
}
