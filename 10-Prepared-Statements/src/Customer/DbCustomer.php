<?php
namespace Customer;

class DbCustomer
{
  public string $host;
  private string $admUser;
  private string $admPass;
  private string $dbName;
  public string $driver;
  public string $table;
  public $com;

  public function __construct ($driver,$host,$admUser,$admPass,$dbName,$table){
    $this->host = $host;
    $this->admUser = $admUser;
    $this->admPass = $admPass;
    $this->dbName = $dbName;
    $this->driver = $driver;
    $this->table = $table;
    
  }

  public function dbConnect(){
    try{
      $this->com = new PDO($this->driver.':host='.$this->host.';dbname='.$this->dbName,$this->admUser,$this->admPass);
      //$this->com = new \PDO($this->driver.':host='.$this->host,$this->admUser,$this->admPass);
    }
    catch(PDOException $e){
      die ('ERROR: Connection can not be stablised ' . $e->getMessage());
    }
  }
  public function dbCreate(){
    try{
      $this->com->exec("CREATE DATABASE IF NOT EXISTS ".$this->dbName.";");
    }
    catch(PDOException $e){
      die("ERROR: DB can not be created " . $e-getMessage());
    }
  }
  public function tableCreate(){
    $sql ="CREATE table ".$this->dbName.".".$this->table."(
     ID INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
     Name VARCHAR( 50 ) NOT NULL,
     Lastname VARCHAR( 50 ) NOT NULL,
     Company VARCHAR( 50 ) NOT NULL,
     Country VARCHAR( 50 ) NOT NULL);" ;
     $this->com->exec($sql);
     
 }
  public function DbAddUser($name,$lastname,$Company,$Country){
    try{
    $sql="INSERT INTO ".$this->dbName.".".$this->table."
    (Name, Lastname, Company,Country)
    VALUES (:name,:lastname,:Company,:Country)";
    $stmt = $this->com->prepare($sql);
    $stmt->bindParam(':name',$name);
    $stmt->bindParam(':lastname',$lastname);
    $stmt->bindParam(':Company',$Company);
    $stmt->bindParam(':Country',$Country);
    $stmt->execute();
   }
   catch (PDOException $e)
   {
   die("ERROR: Can not add User " . $e-getMessage());
   } 
 }
 public function StoredProcedure(){
     try{
     $users = $this->com->query('CALL GetUsers()');
     return $users->fetch(PDO::FETCH_ASSOC);
     }
     catch(PDOException $e){
      die("ERROR: storedProcedure GetUsers() " . $e-getMessage());
     }
  
  }
 
}
?>
