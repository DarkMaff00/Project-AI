const search = document.querySelector('input[placeholder="search event"]')
const eventContainer = document.querySelector(".events");
search.addEventListener('keyup', function (event) {
    if (event.key === "Enter") {
        event.preventDefault();

        const data = {search: this.value};

        fetch("/search", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (events) {
            eventContainer.innerHTML = '<p id="page-title">My events</p>';
            loadEvents(events);
        });
    }
});

function loadEvents(events) {
    events.forEach(event => {
        createEvent(event);
    });
}

function createEvent(event) {
    const template = document.querySelector("#event-template");

    const clone = template.content.cloneNode(true);

    const organizer = clone.querySelector('#organizer');
    organizer.innerHTML = event.id_organizer;
    const name = clone.querySelector('#event-title');
    name.innerHTML = event.name;
    const description = clone.querySelector('#description');
    description.innerHTML = event.description;
    const place = clone.querySelector('#place');
    place.innerHTML = "Place: " + event.place;
    const date = clone.querySelector('#date');
    date.innerHTML = "Date: " + event.eventDate;
    const time = clone.querySelector('#time');
    time.innerHTML = "Time: " + event.eventTime;
    const type = clone.querySelector('#type');
    if(event.type !== ""){
        type.innerHTML = "Type: " + event.type;
    } else {
        type.remove();
    }
    const number = clone.querySelector('#maxNumber');
    number.innerHTML = "Number of participants: " + event.participants +"/" + event.maxNumber;
    const id = clone.querySelector('#event-1');
    id.id = event.id;

    eventContainer.appendChild(clone);
}