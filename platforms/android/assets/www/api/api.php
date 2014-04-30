<?php

class api {
    var $link;

    /*Инициализация Mysql соединения*/
    public function mysql_init($host,$username,$password,$dbname){
    $link = mysqli_connect($host,$username,$password,$dbname) or die("Error " . mysqli_error($link));
    $this->link = $link;
        return $link;
    }

    /*Отправить sql запрос*/
    private function query($query) {
        $result = mysqli_query($this->link, $query);

        if (mysqli_num_rows($result) != 0){
        return  mysqli_fetch_assoc($result);
    }else{
        return false;
        }
    }
    /*Проверка пароля на длину*/
    private function isPasswordTooLong($password)
    {
        return strlen($password) > 4096;
    }
    /*Проверка валидности email*/
    private  function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    /*Соединить соль с паролем*/
    private  function mergePasswordAndSalt($password, $salt)
    {
        if (empty($salt)) {
            return $password;
        }
        return $password.'{'.$salt.'}';
    }
    /*Проверка пароля*/
    private function comparePassword($user_password,$salted_password,$salt) {
        $salted = $this -> mergePasswordAndSalt($user_password,$salt);
        $digest = hash('sha512', $salted, true);
        for ($i = 1; $i < 5000; $i++) {
            $digest = hash('sha512', $digest.$salted, true);
        }
        return  base64_encode($digest) == $salted_password ;
    }

    /*Добавить токен в базу
    uid - id пользователя*/
    private function add_token($uid){
        $token = bin2hex(hash('sha512',rand(),true));
        $this -> query("INSERT INTO user_session(uid,token) VALUES ($uid,'".$token."')");
        return $token;
    }
    /*Проверить токен на валидность
    При успешном прохождении вернуть uid*/
    public function check_token($token){
        $check = $this -> query("SELECT `uid`,`timestamp` FROM `user_session` WHERE `token` = '".$token."'");
        if ($check && (time() - $check['timestamp'] < 86400)){
            return $check['uid'];
        }else{
            return false;
        }
    }

    public function ActionApi($get_array) {
       // return ($this -> login_app($get_array['login'],$get_array['password']));
        return ($this -> login_app($get_array['login'],$get_array['password']));
    }



    public function login_app($email,$password){
    if ($this -> validateEmail($email) && !($this -> isPasswordTooLong($password)) ) {
    $user = $this -> query("SELECT `password`,`salt`,`id` FROM `acme_user` where email = '".$email."'");

        if ($user == false) {return json_encode(array("state" => "error"));}
        if ( $this -> comparePassword($password,$user['password'],$user['salt']) ){
          $token =  $this -> add_token($user['id']);
            return json_encode(array("state" =>"success","token" => $token ) );
        }else{
            return json_encode(array("state" => "error"));
        }
    }
   }

    public function load_point_list() {
        return 0;
    }
    public  function load_point_info($id_point) {
        return 0;
    }
    public  function get_balance(){
        return 0;
    }
    public  function check_code($code){
        return 0;
    }

}
?>