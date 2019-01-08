window.onload = function() {
    if (Notification.permission === 'granted') {
        
    } else {
        Notification.requestPermission().then(function (result) {
            console.log(result);
            if (Notification.permission === 'granted') {
                var notification = new Notification('MOTT Chat', { body: 'Notifications are now enabled. Prepare to be updated!'});
                setTimeout(notification.close.bind(notification), 4000);
            }
        });
    }
    
}

let chatCache = document.getElementById('messages').innerHTML;

const updateChat = function () {
    (async () => {
        class HTTPError extends Error { }

        let response = await fetch('getchat.php', {
            method: 'GET',
            headers: {
                'content-type': 'application/text'
            }
        });

        if (!response.ok) {
            throw new HTTPError('Fetch error:', response.statusText);
        }

        let chat = await response.text();

        if (chat == chatCache) {
            
        } else {
            document.getElementById('messages').innerHTML = chat;
            var notification = new Notification('MOTT Chat', { body: 'There is a new message!', icon: 'chat.png ' });
            setTimeout(notification.close.bind(notification), 4000);
            console.log('Not the same, sending notification.')
            chatCache = chat;
        }
    })();
}

setInterval(updateChat, 1500);