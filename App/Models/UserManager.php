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
    $sql .= "ORDER BY requestDate DESC";
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
    $sql = "SELECT * FROM users WHERE email = :email";
    $query = $this->db->prepare($sql);
    $query->execute([
      'email' => $email,
    ]);
    $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class);
    $user = $query->fetch();

    $query->closeCursor();
    return $user;
  }

  public function acceptRequest($id, $pass, $token)
  {
    $sql = "UPDATE users SET password = :password, accept = 1, token = :token
            WHERE id = :id";
    $query = $this->db->prepare($sql);
    $query->execute([
      'id' => $id,
      'password' => $pass,
      'token' => $token
    ]);

  }

}
