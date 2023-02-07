<?php

class Comment
{

    private $id;
    private $idEvent;
    private $loginUser;
    private $content;
    private $addDate;

    public function __construct($idEvent, $loginUser, $content, $id = 0)
    {
        $this->id = $id;
        $this->idEvent = $idEvent;
        $this->loginUser = $loginUser;
        $this->content = $content;
    }


    public function getId()
    {
        return $this->id;
    }


    public function getIdEvent()
    {
        return $this->idEvent;
    }


    public function getLoginUser()
    {
        return $this->loginUser;
    }


    public function getContent()
    {
        return $this->content;
    }


    public function getAddDate()
    {
        return $this->addDate;
    }


}