const APPNAME = "MOTT Chat"

// Get notification access
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

// Some API-related functions for sending data to the server

const sendMessage = function (name, message) {
    (async () => {
	const data = {
	    'name': name,
	    'message': message
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

    })();
}

// Variables for state-saving

let chatCache = document.getElementById('messages').innerHTML;

// Chat updater that is in between DOM and API

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

        chat = await response.text();

	if (chat.replace(/\s/g,'') == chatCache.replace(/\s/g,'')) {

	} else {
            document.getElementById('messages').innerHTML = chat;
            let chatEl = document.createElement('html');
            chatEl.innerHTML = chat;
            chatEl = chatEl.getElementsByClassName('message');

            let theLength = chatEl.length;
	    lastName = chatEl[theLength - 2].getElementsByTagName('name')[0].innerText;
            let lastMessage = chatEl[theLength - 2].getElementsByTagName('message')[0].innerText;
            var notification = new Notification(lastName, { body: lastMessage, icon: 'chat.png ' });
            setTimeout(notification.close.bind(notification), 5000);
            chatCache = chat;

	    localizeTime();
	}
    }
    )();
}

// The DOM stuff that interacts with the web stuff

setInterval(updateChat, 2500);

const message = function () {
    let name = document.getElementById('name').value;
    let message = document.getElementById('message').value;

    if (message == '') {
	return
    }

    sendMessage(
	name,
	message
    );
    document.getElementById('message').value = '';
}

// Other DOM stuff

const localizeTime = function () {
    let chatroomEl = document.getElementById('messages');

    let messages = chatroomEl.getElementsByClassName('message');
    console.log(messages)

    let container = document.createElement('div');

    for (let i = 0; i < messages.length-1; i++) {
	m = messages[i].innerHTML;

	let stringTime = m.split('<date>')[1].split('</date>')[0];
	let time = new Date(stringTime);
	time = convertUTCDateToLocalDate(time).toLocaleString();
	console.log(time);

	messageEl = document.createElement('div');
	messageEl.className = 'message';
	messageEl.innerHTML = m.split(stringTime).join(time);

	container.appendChild(messageEl)
    }

    document.getElementById('messages').innerHTML = container.innerHTML;
}

// Copied from https://stackoverflow.com/questions/6525538/convert-utc-date-time-to-local-date-time/18330682#18330682
function convertUTCDateToLocalDate(date) {
    var newDate = new Date(date.getTime()+date.getTimezoneOffset()*60*1000);

    var offset = date.getTimezoneOffset() / 60;
    var hours = date.getHours();

    newDate.setHours(hours - offset);

    return newDate;   
}


// Manage keypresses

const node = document.getElementById('message');
node.addEventListener("keyup", function(event) {
    if (event.key === "Enter") {
        message();
    }
});

