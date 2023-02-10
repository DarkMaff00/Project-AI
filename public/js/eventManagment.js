const messagesDiv = document.querySelector('.messages');
const eventId = window.location.pathname.split('/').pop();
const deleteIcons = document.querySelectorAll('.change-icons');
const leaveButton = document.getElementById("leave-event");
const addFriendButton = document.querySelector("#add-friend");

document.querySelectorAll('.event-manage').forEach(element => {
    element.style.cursor = 'pointer';
    element.addEventListener('click', function () {
        const eventId = this.id;
        window.location.href = `http://localhost:8080/eventInfo/${eventId}`;
    });
    element.addEventListener('mouseenter', function () {
        this.style.cursor = 'pointer';
    });
});
document.querySelectorAll('img').forEach(img => {
    const src = img.getAttribute('src');
    img.setAttribute('src', '../' + src);
});


deleteIcons.forEach(function(icon) {
    icon.addEventListener('mouseover', function () {
        this.style.cursor = 'pointer';
    });
});

deleteIcons.forEach(icon => {
    icon.addEventListener('click', function () {

        fetch("/deleteEvent/" + eventId, {
            method: "DELETE",
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    messagesDiv.innerHTML = data.error;
                } else {
                    window.location.href = 'http://localhost:8080/events';
                }
            });
    });
});

leaveButton.addEventListener("click", function() {
    fetch("/leaveEvent/" + eventId, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                messagesDiv.innerHTML = data.error;
            } else {
                window.location.href = "http://localhost:8080/events";
            }
        });
});

leaveButton.addEventListener('mouseover', function () {
    this.style.cursor = 'pointer';
});

addFriendButton.addEventListener("click", function(event) {
    event.preventDefault();
    const friendLogin = document.querySelector("input[name='login-friend']").value;
    fetch("/addToEvent/" + eventId, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "login-friend": friendLogin
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                messagesDiv.innerHTML = data.error;
            } else {
                messagesDiv.innerHTML = data.message;
            }
        });
});

addFriendButton.addEventListener('mouseover', function () {
    this.style.cursor = 'pointer';
});