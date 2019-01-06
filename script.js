function oldUpdateChat() {
    (async () => {
        class HTTPError extends Error { }

        let response = await fetch('./chat.txt', {
            method: 'GET',
            headers: {
                'content-type': 'application/text'
            }
        });

        if (!response.ok) {
            throw new HTTPError('Fetch error:', response.statusText);
        }

        let chat = await response.text();

        console.log(chat);

        let lines = chat.split(/\r\n|\n/);
        
        var newChat = '';

        lines.forEach((line) => {
            
        });

        for (let index = 0; index < lines.length; index++) {
            const line = lines[index];
            newChat = newChat + "<div class='aMessage'>" + line + "</div>";
        }

        document.getElementById('messages').innerText = newChat;
    })();
}

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

        document.getElementById('messages').innerHTML = chat;
    })();
}

setInterval(updateChat, 1000);