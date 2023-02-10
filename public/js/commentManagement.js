const commentContainer = document.querySelector(".comments");
const addCommentButton = document.querySelector("#add-comment");

document.addEventListener('DOMContentLoaded', function () {
    fetch("/comments/" + eventId, {
        method: "GET",
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(function (response) {
        return response.json();
    }).then(function (comments) {
        loadEvents(comments);
    });
}, true);

function loadEvents(comments) {
    comments.forEach(comment => {
        createEvent(comment);
    });
}

function createEvent(comment) {
    const template = document.querySelector("#comment-template");

    const clone = template.content.cloneNode(true);

    const author = clone.querySelector('#comment-author');
    author.innerHTML = comment.login_user;
    const date = clone.querySelector('#comment-date');
    date.innerHTML = comment.add_date;
    const content = clone.querySelector('#comment-text');
    content.innerHTML = comment.content;
    const id = clone.querySelector('#comment-1');
    id.id = comment.id;

    commentContainer.appendChild(clone);
}

addCommentButton.addEventListener("click", function(event) {
    event.preventDefault();
    const content = document.querySelector('input[name="content"]').value;
    fetch("/addComment/" + eventId, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "content": content
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                messagesDiv.innerHTML = data.error;
            } else {
                window.location.reload();
            }
        });
});

addFriendButton.addEventListener('mouseover', function () {
    this.style.cursor = 'pointer';
});
