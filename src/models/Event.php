<?php

class Event
{
    private $name;
    private $description;
    private $eventPlace;
    private $eventDate;
    private $eventTime;

    private $eventType;
    private $maxNumber;
    private $access;

    private $organizer;
    private $id;

    public function __construct($name, $description, $eventPlace,$eventDate, $eventTime, $eventType, $maxNumber, $access, $organizer, $id = 0)
    {
        $this->name = $name;
        $this->description = $description;
        $this->eventPlace = $eventPlace;
        $this->eventType = $eventType;
        $this->eventDate = $eventDate;
        $this->eventTime = $eventTime;
        $this->maxNumber = $maxNumber;
        $this->access = $access;
        $this->organizer = $organizer;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }


    public function getOrganizer()
    {
        return $this->organizer;
    }

    public function getEventPlace()
    {
        return $this->eventPlace;
    }

    public function setEventPlace($eventPlace)
    {
        $this->eventPlace = $eventPlace;
    }

    public function getEventType()
    {
        return $this->eventType;
    }

    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getEventDate()
    {
        return $this->eventDate;
    }

    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;
    }

    public function getEventTime()
    {
        return $this->eventTime;
    }

    public function setEventTime($eventTime)
    {
        $this->eventTime = $eventTime;
    }


    public function getMaxNumber()
    {
        return $this->maxNumber;
    }

    public function setMaxNumber($maxNumber)
    {
        $this->maxNumber = $maxNumber;
    }

    public function getAccess()
    {
        return $this->access;
    }

    public function setAccess($access)
    {
        $this->access = $access;
    }


}