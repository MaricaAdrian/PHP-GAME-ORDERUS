<?php 

    class Database {

        private $user = 'root';
        private $pass = '';
        private $host = 'localhost';
        private $dbname = 'orderus';
        protected $dbc = '';

        function __construct() {
            try {
                $this->dbc = new PDO('mysql:host=' . $this->host .';dbname=' . $this->dbname, $this->user, $this->pass);
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }
    

?>

