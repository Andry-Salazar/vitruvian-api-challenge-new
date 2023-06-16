<?php
namespace Src;

class Task {
  private $db;
  private $requestMethod;
  private $taskId;

  public function __construct($db, $requestMethod, $taskId)
  {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->taskId = $taskId;
  }

  public function processRequest()
  {
    switch ($this->requestMethod) {
      case 'GET':
        if ($this->taskId) {
          $response = $this->getTask($this->taskId);
        } else {
          $response = $this->getAllTask();
        };
        break;
      case 'POST':
        $response = $this->createTask();
        break;
      case 'PUT':
        $response = $this->updateTask($this->taskId);
        break;
      case 'DELETE':
        $response = $this->deleteTask($this->taskId);
        break;
      default:
        $response = $this->notFoundResponse();
        break;
    }
    header($response['status_code_header']);
    if ($response['body']) {
      echo $response['body'];
    }
  }

  private function getAllTask()
  {
    // start your logic here
    /*
    EXAMPLE
    
    ** To connect to DB example: 
    ** To Fetch result 
    ** Reference https://www.php.net/manual/es/class.pdostatement.php
    ** don't forget to check for errors
    */
    $query = "
      SELECT
        *
      FROM
        todo;
    ";

    $statement = $this->db->query($query);
    $result  = $statement->fetchAll(\PDO::FETCH_ASSOC);

    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
  }

  private function getTask($id)
  {
    $data = $this->find($id);
    // start your logic here
     if(!$data) {
      return $this->notFoundResponse();
    }

    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($data);
    return $response;
  }

  private function createTask()
  {
   
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data)) {
      $query = "
      INSERT INTO
        todo (`name`, `description`, `autor`,`is_complete`)
        VALUES(:name, :description, :autor, :is_complete);
      ";
      $statement = $this->db->prepare($query);
      $statement->execute(array(':name' => $data['name'],':description' => $data['description'], ':autor' => $data['autor'], ':is_complete' => $data['is_complete']));
      
      $id = $this->db->lastInsertId();

      $response = $this->getTask($id);
      $response['status_code_header'] = 'HTTP/1.1 201 Created';

      return $response;
    }

    $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
    $response['body'] = json_encode(array('message'=> 'Error loading data'));
    return $response;
  }

  private function updateTask($id)
  {
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data) && isset($data) != null) {
      $query = "
      UPDATE
        todo
       SET 
       name = :name,
       description = :description,
       autor = :autor,
       is_complete = :is_complete
        WHERE 
          id = :id
      ";    
      $statement = $this->db->prepare($query);
      $statement->execute(array(':id'=> $id,':name' => $data['name'],':description' => $data['description'], ':autor' => $data['autor'], ':is_complete' => $data['is_complete']));
      
      $response['status_code_header'] = 'HTTP/1.1 202 Update';
      $response['body'] = json_encode(array('message'=> 'Task Update'));
      return $response;
    }

    $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
    $response['body'] = json_encode(array('message'=> 'You Should fill all the fields'));
    return $response;
  }

  private function deletetask($id)
  {
    $data = $this->find($id);

    if (!$data) {
      return $this->notFoundResponse(); 
    }
    $query = "
    DELETE
    FROM
      todo
    WHERE id = :id
    ";

   $statement = $this->db->prepare($query);
   $statement->execute(array(':id'=> $id));

    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($data);
    return $response;
  }

  public function find($id)
  {
    $query = "
      SELECT
        *
      FROM
        todo
      WHERE id = $id;
    ";

    $statement = $this->db->query($query);
    $result  = $statement->fetchAll(\PDO::FETCH_ASSOC);
    return empty($result) ? null : $result[0];
  }

  private function notFoundResponse()
  {
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    return $response;
  }
}