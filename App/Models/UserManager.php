<?php

/**
 * Manage user
 */
class UserManager
{

  private $db;

  public function __construct(PDO $db)
  {
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->db = $db;
  }

  /**
   * Add new user into the dabatase
   * @param User $user User infos from request form
   */
  public function add(User $user){
    $sql = "INSERT INTO users(name, email, message, requestDate)
            VALUES(:name, :email, :message, NOW())";
    $query = $this->db->prepare($sql);
    $query->execute([
      'name' => $user->name(),
      'email' => $user->email(),
      'message' => $user->message()
    ]);
  }


  /**
   * [update description]
   * @param  int $id       [description]
   * @param  string $password [description]
   * @param  string $confirm  [description]
   */
  public function update($id, $password, $confirm = null){
    if($confirm === "confirm"){
      $sql = "UPDATE users SET password = :password, confirm = 1
              WHERE id = :id";
    }else {
      $sql = "UPDATE users SET password = :password, accept = 1
              WHERE id = :id";
    }
    $query = $this->db->prepare($sql);
    $query->execute([
      'id' => $id,
      'password' => $password,
    ]);
  }

  /**
   * [getList description]
   * @param  [type] $idArticle [description]
   * @param  [type] $type      [description]
   * @return [type]            [description]
   */
  public function getList($type = null)
  {

    switch ($type) {
      case 'new':
        $and = " WHERE accept = 0 ";
        break;
      case 'accepted':
        $and = " WHERE accept = 1 ";
        break;
      case 'confirmed':
        $and = " WHERE confirm = 1 ";
        break;
      default:
        $and = " ";
        break;
    }

    $sql = "SELECT * FROM users";
    $sql .= $and;
    $sql .= "ORDER BY id ASC";
    $query = $this->db->query($sql);
    $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class);
    $userList = $query->fetchAll();

    $query->closeCursor();
    return $userList;
  }

  public function getUser($id)
  {
    $sql = "SELECT * FROM users WHERE id = $id";
    $query = $this->db->query($sql);
    $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class);
    $user = $query->fetch();

    $query->closeCursor();
    return $user;
  }

  public function getUserByMail($email)
  {
    $sql = "SELECT * FROM users WHERE email = :email AND accept = 1";
    $query = $this->db->prepare($sql);
    $query->execute([
      'email' => $email,
    ]);
    $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class);
    $user = $query->fetch();

    $query->closeCursor();
    return $user;
  }

  public function acceptRequest($id, $pass)
  {
    $sql = "UPDATE users SET password = :password, accept = 1
            WHERE id = :id";
    $query = $this->db->prepare($sql);
    $query->execute([
      'id' => $id,
      'password' => $pass,
    ]);

  }

  /**
   * Count failed connection from same ip
   */
  public function connect($ip){
    $query = $this->db->prepare('SELECT COUNT(*) FROM connect where ip = :ip');
    $query->execute(['ip' => $ip,]);
    $connect = $query->fetchColumn();

    $query->closeCursor();
    return $connect;
  }

  /**
   * Insert into connect everytime there is a failed connection from same ip
   */
  public function failconnect($ip, $iduser){
    $query = $this->db->prepare("INSERT INTO connect(ip, iduser, dateconnect) VALUES(:ip, :iduser, NOW())");
    $query->execute(['ip' => $ip, 'iduser' => $iduser
  ]);
  }

  /**
   * Delete failed connection
   */
  public function restoreconnect($ip, $iduser){
    $sql = "DELETE FROM connect WHERE ip = :ip AND iduser = :iduser";
    $query = $this->db->prepare($sql);
    $query->execute([
      'ip' => $ip,
      'iduser' => $iduser,
    ]);
  }

  /**
   * Delete current line from the table and create a new one
   * @param [type] $email    Email of the user
   * @param [type] $selector Selector
   * @param [type] $token    Token to be hashed before insert
   * @param [type] $expire   Expire date of the request
   */
  public function resetPass($email, $selector, $token, $expire){
    $sql = "DELETE FROM passreset WHERE email = :email";
    $query = $this->db->prepare($sql);
    $query->execute([
      'email' => $email,
    ]);

    $hashtoken = password_hash($token, PASSWORD_DEFAULT);

    $sql = "INSERT INTO passreset(email, selector, token, expire)
    VALUES(:email, :selector, :token, :expire)";
    $query = $this->db->prepare($sql);
    $query->execute([
      'email' => $email,
      'selector' => $selector,
      'token' => $hashtoken,
      'expire' => $expire,
    ]);

    $query->closeCursor();
  }

  /**
   * Check for pending reset request with exprire date after current date
   * @param [type] $selector Selector
   * @param [type] $date     Current date
   */
  public function getResetPass($selector, $date){
    $sql = "SELECT * FROM passreset WHERE selector = :selector AND expire >= :current";
    $query = $this->db->prepare($sql);
    $query->execute([
      'selector' => $selector,
      'current' => $date,
    ]);
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $getresetpass = $query->fetch();

    $query->closeCursor();
    return $getresetpass;
  }

  /**
   * Delete line from passreset table for user with selector in param
   */
  public function deletePassReset($selector){
    $sql = "DELETE FROM passreset WHERE selector = :selector";
    $query = $this->db->prepare($sql);
    $query->execute([
      'selector' => $selector,
    ]);
  }

}
