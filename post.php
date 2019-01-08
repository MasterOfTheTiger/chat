<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy: frame-ancestors 'none'", false);
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
$name = scrub($name);
$name = explode(' ', $name);
$name = implode('_', $name);

$_SESSION['name'] = $name;

// Add metadata to message
$text = '"' . $message . '" posted by ' . $name . ' at ' . date("Y/m/d H:i:s") . "\n";

if ($message !== '') {
	$status = 'Success!';
    fwrite($chat, $text);
    header('Location: index.php#message');
}
else {
	$status = 'Error. No message';
}

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
        <h1><?php echo $status ?></h1>
        <p>Click <a href="index.php">here</a> to return.</p>
    </div>
</body>
</html>
