window.onload = function() {
    if (Notification.permission === 'granted') {
	console.log("We have notifications!")
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

        if (chat.replace(/\s/g,'') == chatCache.replace(/\s/g,'')) {

        } else {
            document.getElementById('messages').innerHTML = chat;
            let chatEl = document.createElement('html');
            chatEl.innerHTML = chat;
            chatEl = chatEl.getElementsByClassName('aMessage');
            let theLength = chatEl.length;
            let lastMessage = chatEl[theLength - 2].innerHTML;
            var notification = new Notification('MOTT Chat', { body: lastMessage, icon: 'chat.png ' });
            setTimeout(notification.close.bind(notification), 4000);
            chatCache = chat;
        }
    })();
}

const sendMessage = function () {
    (async () => {
	const data = {
	    'name': document.getElementById('name').value,
	    'message': document.getElementById('message').value
	};
	console.log(data)
	
	class HTTPError extends Error { };

	let response = await fetch('post.php', {
	    method: 'POST',
	    headers: {
		'Accept': 'application/json',
		'Content-Type': 'application/json'
	    },
	    body: JSON.stringify(data)
	});

	if (!response.ok) {
            throw new HTTPError('Fetch error:', response.statusText);
        }

	
	let text = await response.text();

	console.log(text);

    })();
}

setInterval(updateChat, 2500);
