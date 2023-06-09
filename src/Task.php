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
    $query = "
      SELECT
        *
      FROM
        table;
    ";
    ** To connect to DB example: $statement = $this->db->query($query) or $this->db->prepare($statement);
    ** To Fetch result $statement->fetchAll(\PDO::FETCH_ASSOC);
    ** Reference https://www.php.net/manual/es/class.pdostatement.php
    ** don't forget to check for errors
    */
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode(array('message' => 'Your request response'));
    return $response;
  }

  private function getTask($id)
  {
    // start your logic here
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode(array('message' => 'Your request response'));
    return $response;
  }

  private function createTask()
  {
    // start your logic here
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode(array('message' => 'Your request response'));
    return $response;
  }

  private function updateTask($id)
  {
    // start your logic here
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode(array('message' => 'Your request response'));
    return $response;
  }

  private function deletetask($id)
  {
    // start your logic here
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode(array('message' => 'Your request response'));
    return $response;
  }

  public function find($id)
  {
    // start your logic here
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode(array('message' => 'Your request response'));
    return $response;
  }

  private function notFoundResponse()
  {
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    return $response;
  }
}