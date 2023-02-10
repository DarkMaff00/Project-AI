<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Event.php';

class EventRepository extends Repository
{
    public function getEvent(int $id)
    {
        $stmt = $this->database->connect()->prepare(
            'SELECT * FROM public.events WHERE id = :id
             ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($event == null) {
            header("Refresh:0, http://$_SERVER[HTTP_HOST]/");
        }

        return new Event (
            $event['name'],
            $event['description'],
            $event['place'],
            $event['eventDate'],
            $event['eventTime'],
            $event['type'],
            $event['maxNumber'],
            $event['access'],
            $event['id_organizer'],
            $event['id']
        );
    }

    public function addEvent(Event $event)
    {
        $stmt = $this->database->connect()->prepare(
            'INSERT INTO events (name, description, place, "eventDate", "eventTime", type, "maxNumber", access, id_organizer) 
                    VALUES  (?,?,?,?,?,?,?,?,?)
                    ');

        $stmt->execute([
            $event->getName(),
            $event->getDescription(),
            $event->getEventPlace(),
            $event->getEventDate(),
            $event->getEventTime(),
            $event->getEventType(),
            $event->getMaxNumber(),
            $event->getAccess(),
            $event->getOrganizer()
        ]);
    }

    public function deleteEvent(int $id)
    {
        $stmt = $this->database->connect()->prepare('
           DELETE FROM events WHERE id=:id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function addToEvent(int $id, string $login)
    {
        $stmt = $this->database->connect()->prepare('
        INSERT INTO user_events (login_user, id_event)
        VALUES (?,?)');

        $stmt->execute([
            $login,
            $id
        ]);
    }

    public function checkIfAssigned(int $id, string $login): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM user_events
        WHERE login_user = ? AND id_event = ?');

        $stmt->execute([
            $login,
            $id
        ]);

        $result = $stmt->fetch();

        if ($result) {
            return true;
        }

        return false;
    }

    public function checkUserLimit(int $eventId): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT number_of_attendees, "maxNumber" FROM event_attendees WHERE id = ?');

        $stmt->execute([$eventId]);

        $result = $stmt->fetch();

        if ($result['number_of_attendees'] >= ($result['maxNumber'])) {
            return false;
        }

        return true;
    }

    public function numberOfParticipants(int $id)
    {
        $stmt = $this->database->connect()->prepare('
        SELECT number_of_attendees FROM event_attendees WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();

    }

    public function leaveEvent(int $id, string $login)
    {
        $stmt = $this->database->connect()->prepare('
        DELETE FROM user_events WHERE id_event = ? AND login_user = ?');

        $stmt->execute([
            $id,
            $login
        ]);
    }

    public function getEvents(string $login, string $role): array
    {

        $result = [];
        if ($role == 'ADMIN') {
            $stmt = $this->database->connect()->prepare('
        SELECT * FROM events
        ');
            $stmt->execute();
        } else {
            $stmt = $this->database->connect()->prepare('
        SELECT * from events
        LEFT JOIN user_events ue on events.id = ue.id_event AND ue.login_user = ?
        WHERE ue.login_user = ? OR events.id_organizer = ?
        ');
            $stmt->execute([
                $login,
                $login,
                $login
            ]);
        }

        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($events as $event) {
            $result[] = new Event(
                $event['name'],
                $event['description'],
                $event['place'],
                $event['eventDate'],
                $event['eventTime'],
                $event['type'],
                $event['maxNumber'],
                $event['access'],
                $event['id_organizer'],
                $event['id']
            );
        }
        return $result;
    }

    public function getEventByTitle(string $login, string $role, string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        if ($role == 'ADMIN') {
            $stmt = $this->database->connect()->prepare('
        SELECT events.*, count(user_events.id_event)+1 as participants FROM events 
        LEFT JOIN user_events on events.id = user_events.id_event
        WHERE LOWER(events.name) LIKE :search OR LOWER(events.description) LIKE :search OR LOWER(events.type) LIKE :search
        GROUP BY events.id
        ');
        } else {
            $stmt = $this->database->connect()->prepare('
        SELECT events.*, count(ue.id_event)+1 as participants FROM events
        LEFT JOIN user_events ue on events.id = ue.id_event
        WHERE (ue.login_user = :login OR events.id_organizer = :login)
        AND (LOWER(events.name) LIKE :search OR LOWER(events.description) LIKE :search OR LOWER(events.type)  LIKE :search)
        GROUP BY events.id
        ');
            $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        }
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}