<?php
namespace Model;

/**
 * @file
 * It contains the connection file code of MVC blogs.
 */

/**
 * Class for connection of model classes with database.
 */
class Connect
{
  protected $servername;
  protected $username;
  protected $password;
  protected $db;
  protected $con;

  /**
   * Constructor to make connection with the database.
   */
  function __construct()
  {
    $this->servername = "localhost";
    $this->username = "root";
    $this->password = "";
    $this->db = 'blog';
    $this->con =new \mysqli($this->servername, $this->username, $this->password, $this->db);
    if ($this->con->connect_error) {
      die("Connection failed: " . $this->con->connect_error);
    }
  }

  /**
   * Destructor for closing the connection with database.
   */
  function __destruct() {
    $this->con->close();
  }

}

?>
