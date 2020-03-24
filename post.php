<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy: frame-ancestors 'none'", false);
header("Content-Type: application/json; charset=UTF-8");
session_start();

function scrub($input) {
    $splitted = explode('<', $input);
    $splitted = implode('&lt;', $splitted);
    $splitted = explode('>', $splitted);
    $splitted = implode('&gt;', $splitted);
    return $splitted;
}

// Process the data as JSON if using POST -- otherwise it should do something else, I haven't decided yet
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $data = json_decode(file_get_contents("php://input"), false);
    print_r($data);
}

// Cast the object to an array
$data = (array) $data;

date_default_timezone_set("UTC");
$chat = fopen('chat.txt', 'a') or die('Error upon opening file');

$name = 'anonymous';
if ($_POST['name'] !== '') {
    $name = $data['name'];
}

// Scrub user input
$message = scrub($data['message']);
$name = scrub($name);
$name = explode(' ', $name);
$name = implode('_', $name);

$_SESSION['name'] = $name;

// Add metadata to message
$text = '"' . $message . '" posted by ' . $name . ' on ' . date("Y-m-d"). ' at ' . date("H:i:s") . "\n";

if ($message !== '') {
    $status = 'Success!';
    fwrite($chat, $text);
}
else {
    $status = 'Error. No message';
}

echo $status

fclose($chat);
?>
