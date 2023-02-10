<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $value)
    {
        $stmt = $this->database->connect()->prepare(
            'SELECT * FROM public.users WHERE md5(email) = :email OR login = :login
             ');
        $stmt->bindParam(':email', $value, PDO::PARAM_STR);
        $stmt->bindParam(':login', $value, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            return null;
        }

        $stmt2 = $this->database->connect()->prepare('
        SELECT * FROM public.user_details WHERE id =  :id');
        $stmt2->bindParam(':id', $user['id_user_details'], PDO::PARAM_INT);
        $stmt2->execute();

        $details = $stmt2->fetch(PDO::FETCH_ASSOC);
        if (!$details) {
            throw new UnexpectedValueException();
        }


        return new User (
            $user['email'],
            $user['login'],
            $user['password'],
            $details['firstname'],
            $details['surname'],
            $details['country'],
            $details['city'],
            $user['role']
        );
    }

    public function addUser(User $user)
    {
        $db = $this->database->connect();
        $stmt = $db->prepare('INSERT INTO user_details(firstname, surname, country, city) 
                VALUES (?,?,?,?) RETURNING id;');
        $stmt->execute([
            $user->getFirstname(),
            $user->getSurname(),
            $user->getCountry(),
            $user->getCity()
        ]);
        $id = $db->lastInsertId();

        $stmt = $this->database->connect()->prepare('INSERT INTO users(login, id_user_details, email, password,role) 
                VALUES (?,?,?,?,?)');
        $stmt->execute([
            $user->getLogin(),
            $id,
            $user->getEmail(),
            $user->getPassword(),
            $user->getRole()
        ]);
    }

    public function deleteUser($login)
    {
        $stmt = $this->database->connect()->prepare('
           SELECT id_user_details FROM users WHERE login =:login
        ');
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
        $detailsId = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->database->connect()->prepare('
           DELETE FROM users WHERE login=:login
        ');
        $stmt->bindParam(':login', $login, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $this->database->connect()->prepare('
           DELETE FROM user_details WHERE id=:id
        ');
        $stmt->bindParam(':id', $detailsId['id_user_details'], PDO::PARAM_INT);
        $stmt->execute();
    }

    public function changePassword($login, $password)
    {
        $stmt = $this->database->connect()->prepare('
        UPDATE users SET password= :password WHERE login = :login
        ');

        $stmt->bindValue(':password', $password);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function checkIfLoginExists($login): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM users WHERE login = :login
        ');
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() == 0;
    }

    public function checkIfAlreadyFriends($requesterLogin, $addresserLogin): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM friendship WHERE ("requesterLogin" = :requesterLogin AND "AddresserLogin" = :addresserLogin)
        OR ("requesterLogin" = :addresserLogin AND "AddresserLogin" = :requesterLogin)
        ');
        $stmt->bindParam(':requesterLogin', $requesterLogin, PDO::PARAM_STR);
        $stmt->bindParam(':addresserLogin', $addresserLogin, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() == 0;
    }

    public function addFriend($yourLogin, $friendLogin)
    {
        $stmt = $this->database->connect()->prepare('
        INSERT INTO friendship 
        VALUES (?,?)');

        $stmt->execute([
            $yourLogin,
            $friendLogin
        ]);
    }

    public function getFriends(string $login, string $role): array
    {

        $result = [];
        if ($role == 'ADMIN') {
            $stmt = $this->database->connect()->prepare('
        SELECT * FROM users
        ');
            $stmt->execute();
        } else {
            $stmt = $this->database->connect()->prepare('
        SELECT DISTINCT users.*
    FROM users
    JOIN friendship f ON users.login = f."AddresserLogin" OR users.login = f."requesterLogin"
    WHERE ( "AddresserLogin" = ? OR "requesterLogin" = ? ) AND users.login != ?
        ');
            $stmt->execute([
                $login,
                $login,
                $login
            ]);
        }

        $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($friends as $friend) {
            $stmt2 = $this->database->connect()->prepare('
        SELECT * FROM public.user_details WHERE id =  :id');
            $stmt2->bindParam(':id', $friend['id_user_details'], PDO::PARAM_INT);
            $stmt2->execute();

            $details = $stmt2->fetch(PDO::FETCH_ASSOC);
            $result[] = new User(
                $friend['email'],
                $friend['login'],
                $friend['password'],
                $details['firstname'],
                $details['surname'],
                $details['country'],
                $details['city'],
                $friend['role']
            );
        }
        return $result;
    }
}