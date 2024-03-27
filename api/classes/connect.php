<?php
// moved the database.php file outside the root directory for security
require_once "../../database.php";

class Connect extends Database {

    public $report = array();
    private static $instance = null;
    protected $connection;

    protected function __construct() {
        // Initialize the database connection
        parent::__construct();
        $this->connect();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect() {
        // Check if database connection parameters are defined
        if (empty($this->host) || empty($this->username) || empty($this->password) || empty($this->database)) {
            $this->report[] = array(
                'api' => 'Connect',
                'action' => 'connect-database > verify-connection-parameters',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Database connection parameters are missing or invalid.</e>',
                'resolution' => 'verify-credentials-in-database-class'
            );
            return false;
        }

        // Create a new MySQLi instance
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        // Check connection
        if ($this->connection->connect_error) {
            $this->report[] = array(
                'api' => 'Connect',
                'action' => 'connect-database > establish-connection',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to establish database connection! ' . $this->connection->connect_error . '</e>',
                'resolution' => 'verify-credentials-and-retry-db-connection'
            );
            return false;
        } else {
            $this->report[] = array(
                'api' => 'Connect',
                'action' => 'connect-database > establish-connection',
                'result' => true,
                //'message' => '<s><b class="icon-done-all"></b>Database connection established!</s>',
                'advice' => 'perform-required-database-action'
            );
            return true;
        }
    }

    // Prevent cloning of the object
    private function __clone() {}

    // Prevent unserialization of the object
    public function __wakeup() {}

    public function getConnection() {
        if ($this->connection === null || !$this->isConnected()) {
            // Attempt to reconnect or throw an exception
            $this->connect();
        }
        return $this->connection;
    }

    public function isConnected() {
        // Check if the connection object is valid and ping the server
        return $this->connection instanceof mysqli && $this->connection->ping();
    }
}

?>
