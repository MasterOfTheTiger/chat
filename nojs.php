<!--The legacy interface that supports lack of JS -->
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
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div id="information">
        <p><strong>Note:</strong> all times are in UTC.</p>
    </div>
    <div id="messages">
        <?php
        $chat = fopen("chat.txt", "a+") or die("Error upon opening file");
        while(!feof($chat)) {
          echo "<div class=\"message\">" . fgets($chat) ."</div>";
        }
        echo fread($chat,filesize("chat.txt"));
        fclose($chat);
        ?>
    </div>
    <input type="button" value="Refresh" onclick="history.go(0)" />
    <form action="post.php" method="POST">
        <p>Name:</p>
        <input type="text" name="name" <?php if ($_SESSION['name'] !== null) {echo 'value=' . $_SESSION['name'];} ?> />
        <p>Message</p>
        <input type="text" id="message" name="message" autofocus />
        <input type="submit" value="Send" />

        <!-- These don\'t actually get displayed to the user, but they are sent along with the request-->
        <input type="checkbox" name="type" value="nojs" style="display:none" checked/>
        <br /><br />
    </form>
    <footer>
         <a href="#">MOTT Chat</a> code &copy; MasterOfTheTiger 2018, 2019, 2020. <a href="https://github.com/masterofthetiger/chat">See source code</a>
    </footer>
</body>
</html>
