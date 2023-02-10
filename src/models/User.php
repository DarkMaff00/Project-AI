<?php

class User
{
    private $email;
    private $login;
    private $password;
    private $firstname;
    private $surname;
    private $country;
    private $city;

    private $role;


    public function __construct(string $email, string $login, string $password, string $firstname, string $surname, string $country, string $city, string $role = 'USER')
    {
        $this->email = $email;
        $this->login = $login;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->country = $country;
        $this->city = $city;
        $this->role = $role;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city)
    {
        $this->city = $city;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role)
    {
        $this->role = $role;
    }


    public function setEmail(string $email)
    {
        $this->email = $email;
    }


    public function getLogin(): string
    {
        return $this->login;
    }


    public function setLogin(string $login)
    {
        $this->login = $login;
    }


    public function getPassword(): string
    {
        return $this->password;
    }


    public function setPassword(string $password)
    {
        $this->password = $password;
    }


}