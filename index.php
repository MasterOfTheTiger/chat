<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy: frame-ancestors 'none'", false);
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>MOTT Chat</title>
    <link rel="shortcut icon" type="image/png" href="chat.png"/>
    <link href="style.css" rel="stylesheet" />
</head>
<body>
    <div id="information">
        <p><strong>Note:</strong> all times are in UTC.</p>
    </div>
    <div id="messages">
        <?php
        $chat = fopen("chat.txt", "a+") or die("Error upon opening file");
        while(!feof($chat)) {
          echo "<div class=\"aMessage\">" . fgets($chat) ."</div>";
        }
        echo fread($chat,filesize("chat.txt"));
        fclose($chat);
        ?>
    </div>
    <form action="post.php" method="POST">
        <p>Name:</p>
        <input type="text" name="name" <?php if ($_SESSION['name'] !== null) {echo 'value=' . $_SESSION['name'];} ?> />
        <p>Message</p>
        <input type="text" id="message" name="message" autofocus />
        <input type="submit" value="Post Message" />
        <br /><br />
    </form>
    <footer>
        <a href="http://chat.mtiger.xyz">MOTT Chat</a> code &copy; MasterOfTheTiger 2018, 2019. <a href="https://github.com/MasterOfTheTiger/chat">See this project on GitHub</a>
    </footer>

    <script src="script.js"></script>
</body>
</html>
