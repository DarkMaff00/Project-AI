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
        if (!$event) {
            throw new UnexpectedValueException();
        }

        return new Event (
            $event['name'],
            $event['description'],
            $event['mode'],
            $event['event-place'],
            $event['eventDate'],
            $event['eventTime'],
            $event['event-type'],
            $event['maxNumber'],
            $event['access'],
            $event['id_organizer']
        );
    }

    public function addEvent(Event $event)
    {
        $stmt = $this->database->connect()->prepare(
            'INSERT INTO events (name, description, mode, place, "eventDate", "eventTime", type, "maxNumber", access, id_organizer) 
                    VALUES  (?,?,?,?,?,?,?,?,?,?)
                    ');

        $stmt->execute([
            $event->getName(),
            $event->getDescription(),
            $event->getMode(),
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
        SELECT "maxNumber", (
            SELECT COUNT(*)
            FROM user_events
            WHERE id_event = ?
        ) as assigned
        FROM events
        WHERE id = ?');

        $stmt->execute([
            $eventId,
            $eventId
        ]);

        $result = $stmt->fetch();

        if ($result['assigned'] >= ($result['maxNumber']-1)) {
            return false;
        }

        return true;
    }

    public function leaveEvent(int $id, string $login){
        $stmt = $this->database->connect()->prepare('
        DELETE FROM user_events WHERE id_event = ? AND login_user = ?');

        $stmt->execute([
            $id,
            $login
        ]);
    }
}