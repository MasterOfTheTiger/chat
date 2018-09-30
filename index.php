<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>MOTT Chat</title>
</head>
<body>
    <div id="messages">
        <?php
        $chat = fopen("chat.txt", "a+") or die("Error upon opening file");
        while(!feof($chat)) {
          echo fgets($chat) ."<br />";
        }
        echo fread($chat,filesize("chat.txt"));
        fclose($chat);
        ?>
    </div>
    <form action="post.php" method="POST">
        <p>Name:</p>
        <input type="text" name="name" />
        <p>Message</p>
        <textarea name="message" rows="4" cols="50"></textarea>
        <br />
        <input type="submit" value="Post Message" />
    </form>
    <footer>
        &copy; MasterOfTheTiger 2018
    </footer>
</body>
</html>
