<?php
session_start();

function scrub($input) {
    $splitted = explode('<', $input);
    $splitted = implode('&lt;', $splitted);
    $splitted = explode('>', $splitted);
    $splitted = implode('&gt;', $splitted);
    return $splitted;
}

date_default_timezone_set("America/New_York");
$chat = fopen('chat.txt', 'a') or die('Error upon opening file');
$name = 'anonymous';
if ($_POST['name'] !== '') {
    $name = $_POST['name'];
}

// Scrub user input
$message = scrub($_POST['message']);
$name = scrub($_POST['name']);

$_SESSION['name'] = $_POST['name'];

// Add metadata to message
$text = '"' . $message . '" posted by ' . $name . ' at ' . date("Y/m/d H:i:s") . '<br />';

fwrite($chat, $text);
fclose($chat);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Posted to MOTT Chat</title>
</head>
<body>
    <div>
        <h1>Success!</h1>
        <p>Your message was posted! Click <a href="index.php">here</a> to return.</p>
    </div>
</body>
</html>
