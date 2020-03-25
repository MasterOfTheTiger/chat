<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy: frame-ancestors 'none'", false);
session_start();

$chat = fopen("chat.txt", "a+") or die("Error upon opening file");
while(!feof($chat)) {
    echo "<div class=\"message\">" . fgets($chat) ."</div>";
}

fclose($chat);
?>
