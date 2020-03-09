<?php
  

  function die_r($value){
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    die();
  }



class Database{

  public $isConnect;
  protected $datab;

  // Connect To Database
  public function __construct($username ='mysql', $password='mysql', $host='localhost' , $dbname='phptwo', $options = []){

    $this->isConnect = true;
    try {
      $this->datab = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options); // Подключение к базе данных 
      $this->datab->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Устанавливает  атрибут для объекта PDO. Информация с php.net ERRMODE_EXCEPTION - выбрасывает исключение
      $this->datab->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Дефолный фетч мод,  Выводит в виде ассоциативного массива 
    } catch (PDOException $e) {
        throw new Exception($e->getMessage()); // Вывод ошибки если не удалось подключиться к базе данных
    }

  }

  // Get All Rows
  public function getAll($table){

    try{
      $stmt = $this->datab->prepare("SELECT * FROM  $table"); // Подготавливаем запрос, указывая $table как переменную
      $stmt->execute(); // Выполняем запрос
      return $stmt->fetchAll(); // Поулчаем результаты

    } catch(PDOException $e) {
      throw new Exception($e->getMessage()); // Вывод ошибки если не удалось подключиться к базе данных
    }

  }
  
  // Get One Row
  public function getOne($table, $id){

    try{
      $stmt = $this->datab->prepare("SELECT * FROM $table WHERE id=$id LIMIT 1"); // Подготавливаем запрос, указывая $table как переменную
      $stmt->execute(); // Выполняем запрос
      return $stmt->fetchAll(); // Поулчаем результаты

    } catch(PDOException $e) {
      throw new Exception($e->getMessage()); // Вывод ошибки если не удалось подключиться к базе данных
    }

  }


  // Insert in Row
  public function insert($table,$date){
    try{
      $sql = "INSERT INTO `$table` (`name`, `lastname`, `age`) VALUES (?,?,?)";
      $stmt = $this->datab->prepare($sql);
      $stmt = $this->datab->execute($date);
    } catch(PDOException $e) {
      throw new Exception($e->getMessage()); // Вывод ошибки если не удалось подключиться к базе данных
    }
  }


  // Delete
  public function delete($table, $id){
    try{
      $stmt = $this->datab->prepare("DELETE FROM $table WHERE id=$id LIMIT 1"); // Подготавливаем запрос, указывая $table как переменную
      $stmt->execute(); // Выполняем запрос
      return $stmt->fetchAll(); // Поулчаем результаты
    } catch(PDOException $e) {
      throw new Exception($e->getMessage()); // Вывод ошибки если не удалось подключиться к базе данных
    }
  }



}





  
  $db = new Database();
  
  $getTable = $db->getAll('product');
  $rowOne = $db->getOne('product', 4);
  // $insRow = $db->insert('product',  'newtab', 23, 312); // Выдает ошибку
  $delRow = $db->delete('product',4); // Удаляем но выдает ошибку
?>