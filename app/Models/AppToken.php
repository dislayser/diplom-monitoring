<?php
class Token{
    public $type; // Несколько разных видов токенов GET POST AUTH ADMIN ..
    public $token;

    public function __construct($type = "POST"){
        $this->type = $type;
        $this->token = null;
    }

    //Создание хэшированного токена
    public function get($type = null){
        if ($type === null) {
            $type = $this->type;
        }else{
            $this->type = $type;
        }

        if (!isset($_SESSION['tokens'][$type])){
            $_SESSION['tokens'][$type] = uniqid('', true);
        }

        $this->token = password_hash($_SESSION['tokens'][$type], PASSWORD_DEFAULT);

        return $this->token;
    }

    //Удаление токена
    public function del($type = null){
        if ($type === null) {
            $type = $this->type;
        }
        if (isset($_SESSION['tokens'][$type])){
            unset($_SESSION['tokens'][$type]);
        }
        return $this;
    }

    //Проверка токена
    public function verify($token, $type = null){
        if ($type === null) {
            $type = $this->type;
        }
        return password_verify($_SESSION['tokens'][$type], $token);
    }

    //Возвращает поле с токеном - для удобства
    public function field($type = null){
        if ($type === null) {
            $type = $this->type;
        }
        return '<input type="hidden" value="'.htmlspecialchars($this->get($type)).'" name="token['.$type.']" id="token['.$type.']">';
    }

}
?>