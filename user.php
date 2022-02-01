<?php
class User{

    private $id;
    public $login;
    public $password;
    public $email;
    public $firstname;
    public $lastname;

    function __construct(){
        $this->bdd = mysqli_connect('localhost','root','root','classes');
        mysqli_set_charset($this->bdd, 'utf8');
        return $this -> bdd;
    }

    public function register($login, $password, $email, $firstname, $lastname){
        $query = mysqli_query($this->bdd, "INSERT INTO utilisateurs( login, password, email, firstname, lastname) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')");
        echo'<table>
        <thead>
            <th>id</th>
            <th>login</th>
            <th>password</th>
            <th>email</th>
            <th>Firstname</th>
            <th>Lastname</th>
        </thead>
        <tbody>
            <td>'.$login.'</td>
            <td>'.$password.'</td>
            <td>'.$email.'</td>
            <td>'.$firstname.'</td>
            <td>'.$lastname.'</td>
        </tbody>
    </table>';
    }
    public function connect($login, $password){
        $query = mysqli_query($this->bdd,"SELECT * FROM utilisateurs WHERE login = '$login' AND password = '$password'");
        $user = mysqli_fetch_all($query, MYSQLI_ASSOC);
        if(count($user) > 0){
            session_start();
            $_SESSION['user'] = [
                'id' => $user[0]['id'],
                'login' => $user[0]['login'],
                'password' => $user[0]['password'],
                'email' => $user[0]['email'],
                'firstname' => $user[0]['firstname'],
                'lastname' => $user[0]['lastname'],
            ];
        }
    }
    public function disconnect(){
        session_start();
        session_destroy();
    }
    public function delete(){
        $query = mysqli_query($this->bdd, 'DELETE FROM utilisateurs WHERE 20');
        session_destroy();
    }
    public function update($login, $password, $email, $firstname, $lastname){
        $query = mysqli_query($this->bdd, "UPDATE utilisateurs SET login= '$login',password= '$password',email= '$email',firstname = '$firstname',lastname= '$lastname'");
    }
    public function isConnected(){
        if(!empty($_SESSION['user'])){
            return true;
        }
        else{
            return false;
        }
    }
    public function getAllinfos(){

        echo'<table>
                <thead>
                    <th>id</th>
                    <th>login</th>
                    <th>password</th>
                    <th>email</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                </thead>
                <tbody>
                    <td>'.$_SESSION['user']['id'].'</td>
                    <td>'.$_SESSION['user']['login'].'</td>
                    <td>'.$_SESSION['user']['password'].'</td>
                    <td>'.$_SESSION['user']['email'].'</td>
                    <td>'.$_SESSION['user']['firstname'].'</td>
                    <td>'.$_SESSION['user']['lastname'].'</td>
                </tbody>
            </table>';
    }
    public function getLogin(){
        return $this->login;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getFirstname(){
        return $this->firstname;
    }
    public function getLastname(){
        return $this->lastname;
    }

}
$personne = new User;
$personne->register('remi-g','rg', 'remig@wanadoo.fr', 'remi', 'garguilo');
$personne->connect('remi-g','rg');
echo $personne->isConnected();
echo $personne->getAllinfos();
?>