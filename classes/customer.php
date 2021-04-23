<?php
class Customer {
    public $id;
    public $name;
    public $email;
    public $address = array();

    function set_id($id) {
        $this->id = $id;
    }

    function get_id() {
        return $this->id;
    }

    function set_name($name) {
        $this->name = $name;
    }

    function get_name() {
        return $this->name;
    }

    function set_email($email) {
        $this->email = $email;
    }

    function get_email() {
        return $this->email;
    }

    function add_address($address) {
        array_push($this->address, $address);
    }

    function get_address() {
        for($i = 0; $i < count($this->address); $i++) {
            echo $this->address[$i] . "<br>";
        }
    }

    function clear_address() {
        for($i = 0; $i < count($this->address); $i++) {
            unset($this->address[$i]);
        }
    }
}