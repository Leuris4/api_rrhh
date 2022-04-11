<?php
    class DbConnection {
 
        private $connection;

        function connect() {
            include_once 'DbParams.php';
    
            try {
                $this->connection = new PDO(
                    'mysql:host=' .
                    HOST.';dbname='.
                    DBNAME.';charset=utf8', 
                    DBUSERNAME, 
                    DBPASSWORD);
    
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                return $this->connection;
    
            } catch(PDOException $ex) {
                echo 'Hmmm... Something went wrong! Try it later';
                exit;
            }
            
        }
     
    }
?>