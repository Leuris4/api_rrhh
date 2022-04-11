<?php
class Request {
 
    private $connection;
 
    function __construct() {
        require_once 'DbConnection.php';
        $db = new DbConnection();
        $this->connection = $db->connect();
    }
 
    function getuser($param){
	    $sql=$this->connection->prepare("SELECT * FROM usuario WHERE USUARIO=:user AND CONTRASENA=:pass");
	    $sql->bindParam(':user', $param["user"]);
	    $sql->bindParam(':pass', $param["pass"]);
        $sql->execute();
        $res = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $res; 
        $sql->close();
        $connection->close();
	}
   

}
?>