<?php
class Gladiator{
    private $id;
    private $username = "";
    private $health;
    private $attack;
    private $defence;
    private $level;
    
    function __construct($id, $username, $health, $attack, $defence, $level) {
        $this->id = $id;
        $this->username = $username;
        $this->health = $health;
        $this->attack = $attack;
        $this->defence = $defence;
        $this->level = $level;
    }

    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getHealth() {
        return $this->health;
    }

    function getAttack() {
        return $this->attack;
    }

    function getDefence() {
        return $this->defence;
    }

    function getLevel() {
        return $this->level;
    }


}

?>
