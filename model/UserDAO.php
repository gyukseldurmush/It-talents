<?php

namespace model;
include_once "PDO.php";

class UserDAO{
    public function getUserByEmail($email){

        $pdo=getPDO();
        $sql="SELECT * FROM users WHERE email=?;";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_OBJ);

    }

    public function getUserById($id){

        $pdo=getPDO();
        $sql="SELECT * FROM users WHERE id=?;";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_OBJ);

    }

    public function add(User $user){
        $db = getPDO();
        $params = [];
        $params[] = $user->getEmail();
        $params[] = $user->getPassword();
        $params[] = $user->getFirstName();
        $params[] = $user->getLastName();
        $params[] = $user->getAge();
        $params[] = $user->getPhoneNumber();
        $params[] = $user->getRole();
        $params[]=$user->getSubscription();
        $sql = "INSERT INTO users (email, password, first_name,last_name,age,phone_number,role,subscription,date_created) VALUES (?, ?, ?,?,?,?,?,?,now());";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $user->setId($db->lastInsertId());

    }



    public function update(User $user){
        $db = getPDO();
        $params = [];
        $params[] = $user->getEmail();
        $params[] = $user->getPassword();
        $params[] = $user->getFirstName();
        $params[] = $user->getLastName();
        $params[] = $user->getAge();
        $params[] = $user->getPhoneNumber();
        $params[]=$user->getSubscription();
        $params[] = $user->getId();

        $sql = "UPDATE users SET email=?, password=?, first_name=?,last_name=?,age=?,phone_number=?,subscription=? WHERE id=? ;";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);


    }

}