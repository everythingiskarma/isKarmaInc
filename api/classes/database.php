<?php

class Database {

    protected $host;
    protected $username;
    protected $password;
    protected $database;

    public function __construct() {
        $this->host = "localhost";
        $this->username = "iskarmac_udbhav";
        $this->password = "g37wir3d";
        //$this->password = "&~n;lL__L#Uu";
        switch ($_POST['api']) {
            case 'authenticator':
                $this->database = "iskarmac_users";
            break;

            case '':
                $this->database = "iskarmac_";
            break;

          default:
            // code...
            break;
        }
    }
}

?>
