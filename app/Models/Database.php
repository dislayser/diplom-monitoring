<?php
class Database {

    //Авторизационные данные
    private $db_name;   // имя базы данных
    private $db_user;   // имя пользователя
    private $db_pass;   // пароль

    //Настройки подключения
    private $driver;    // драйвер базы данных например mysql
    private $host;      // адрес сервера базы данных
    private $options;   // настройки PDO

    //Данные по умолчанию
    public $limit;
    public $offset;
    public $cur_page;
    public $orderBy;
    public $sortCol;
    private $col_deny;  //не используется

    //Главный файл подключения [Объект PDO]
    private $conn;

    //Переменные для выборки
    public $table;      //База с котрой сейчас работаем
    public $where;      //Строка where для выборки
    public $sql;        //Текущий запрос
    public $params;     //Текущие параметры

    //Переменная для получения данных последнего запроса
    public $data;

    //Конструктор класса
    public function __construct($db_name, $db_user, $db_pass,
        $limit = 25, $cur_page = 1, $offset = 0, $orderBy = 'DESC', $sortCol = 'id', $driver = "mysql", $host = "localhost",
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]) {
        //Авторизационные данные
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;

        //Настройки подключения
        $this->driver = $driver;
        $this->host = $host;
        $this->options = $options;

        //Данные по умолчанию
        $this->limit = (int)$limit;
        $this->cur_page = (int)$cur_page;
        $this->offset = (int)$offset;

        $this->orderBy = $orderBy;
        $this->sortCol = $sortCol;
    }

    //Метод соединения с бд
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->db_user, $this->db_pass, $this->options);
        } catch(PDOException $e) {
            die("Ошибка соединения с базой данных: " . $e->getMessage());
        }

        return $this->conn;
    }

    //Получение оффсета
    private function getOffset(){
        $this->cur_page = (int)$this->cur_page;
        $this->offset = $this->limit * ($this->cur_page - 1);
        return $this;
    }
    //Получение лимита строк
    private function getLimit(){
        $this->limit = (int)$this->limit;

        //Задаем ограничения для LIMIT например от 1 до 100
        $limit_min = 1;
        $limit_max = 100;

        $this->limit = min(max($limit_min, $this->limit), $limit_max);
        return $this;
    }
    
    //возвращает строку с отбором WHERE - без параметров
    private function where($params = []){
        $where = "";
        if (!empty($params)) {
            $where .= " WHERE";
            $conditions = [];
            foreach ($params as $key => $value) {
                if (is_array($value)) {
                    $conditionsArr = [];
                    foreach ($value as $v) {
                        if (strpos($v, '%') === 0) {
                            $conditionsArr[] = "$key LIKE ?";
                        } else {
                            $conditionsArr[] = "$key = ?";
                        }
                        $bindings[] = $v;
                    }
                    $conditions[] = '(' . implode(" OR ", $conditionsArr) . ')';
                } else {
                    if (strpos($value, '%') === 0) {
                        $conditions[] = "$key LIKE ?";
                    } else {
                        $conditions[] = "$key = ?";
                    }
                    $bindings[] = $value;
                }
            }
            $where .= " " . implode(" AND ", $conditions);
        }
        
        return $where;
    }

    //Для новой записи - возвращает ID новой записи
    public function insert($table, $params){
        if (!empty($params)){
            $columns = implode(", ", array_keys($params));
            $values = implode(", ", array_fill(0, count($params), "?"));
        
            $sql = "INSERT INTO $table ($columns) VALUES ($values)";
            
            try {
                $query = $this->conn->prepare($sql);
                $query->execute(array_values($params));
            } catch (PDOException $e) {
                //При ошибки запроса, запись в логи ошибок
                $this->error_log($e->getMessage(), $params);
                //errors_db_log($e->getMessage(), $params);
                //exit;
            }

            $this->data = $this->conn->lastInsertId();
        
            return $this;
        }
    }

    //Для обновления значений
    public function update($table, $id, $params) {
        try {
            // Подготавливаем список параметров для обновления
            $placeholders = [];
            $updateParams = [];
            foreach ($params as $key => $value) {
                $placeholders[] = "$key = ?";
                $updateParams[] = $value;
            }
            // Добавляем параметр id
            $updateParams[] = $id;
    
            // Формируем SQL запрос
            $sql = "UPDATE $table SET " . implode(", ", $placeholders) . " WHERE id = ?";
    
            // Подготавливаем и выполняем запрос
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($updateParams);
    
            // Возвращаем true в случае успешного выполнения запроса
            return true;
        } catch(PDOException $e) {
            // Обработка ошибок запроса
            // Например, можно записать ошибку в логи
            $this->error_log($e->getMessage(), $params);
            return false; // Возвращаем false в случае ошибки
        }
    }    

    //Для уничтожения записей
    public function delete($table, $params){
        $sql = "DELETE FROM $table";
        $sql .= $this->where($params);
        
        try {
            $query = $this->conn->prepare($sql);
            $query->execute(array_values($params));
        } catch (PDOException $e) {
            //При ошибки запроса, запись в логи ошибок
            $this->error_log($e->getMessage(), $params);
            //errors_db_log($e->getMessage(), $params);
            //exit;
        }
        return $this;
    }

    //Для множественной выборки строк
    public function select($table = null, $params = []){

        $sql  = "SELECT * FROM $table";

        $sql .= $this->where($params);

        $this->getOffset();
        $this->getLimit();

        $sql .= " ORDER BY $this->sortCol $this->orderBy";
        $sql .= " LIMIT $this->limit OFFSET $this->offset";
        //echo $sql;

        $query = $this->conn->prepare($sql);
        $query->execute(array_values($params));
        $this->data = $query->fetchAll();

        return $this;
    }
    
    //Для получени только одной строки - например пользоваля по его id;
    public function select_one($table = null, $params = []){
        $sql  = "SELECT * FROM $table";

        $sql .= $this->where($params);

        $sql .= " ORDER BY $this->sortCol $this->orderBy";

        $query = $this->conn->prepare($sql);
        $query->execute(array_values($params));
        $this->data = $query->fetch();

        return $this;
    }

    //Функция запроса для получения данных о колонках таблицы
    public function describe($table){
        $sql = "DESCRIBE $table";

        try {
            $query = $this->conn->prepare($sql);
            $query->execute();
            $this->data = $query->fetchAll();
        }catch (PDOException $e) {
            //При ошибки запроса, запись в логи ошибок
            $this->error_log($e->getMessage());
        }
        
        return $this;
    }

    //Колличество строк в таблице
    public function count($table = null, $params = []){

        $sql = "SELECT COUNT(*) FROM $table";

        $sql .= $this->where($params);

        $this->getOffset();

        $query = $this->conn->prepare($sql);
        $query->execute(array_values($params));
        $this->data = $query->fetch();

        return $this;
    }

    //Просто запрос в бд
    public function sql_request($query, $params = []) {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch(PDOException $e) {
            // Обработка ошибок запроса
            // Например, можно записать ошибку в логи
            $this->error_log($e->getMessage(), $params);
            return false; // Возвращаем false в случае ошибки
        }
    }

    //Просто запрос в бд на получение данных
    public function sql_request_select($sql, $params = []){
        try{
            $query = $this->conn->prepare($sql);
            $query->execute(array_values($params));
            $this->data = $query->fetchAll();
            return $this;
        }  catch(PDOException $e) {
            // Обработка ошибок запроса
            // Например, можно записать ошибку в логи
            $this->error_log($e->getMessage(), $params);
            return false; // Возвращаем false в случае ошибки
        }
    }

    //Для вывода массива
    public function tt(){
        if (!empty($this->data)) {
            echo '<pre>';
            print_r($this->data);
            echo '</pre>';
        }
    }

    //Для записи ошибок - возможно стоит сделать это за классом
    private function error_log($error, $params_data = []){
        print_r($error);
        $post = [
            'id_user' => $_SESSION['id'],
            'url' => $_SERVER['REQUEST_URI'],
            'error' => $error,
            'params' => json_encode($params_data),
        ];
        
        return $this->insert('errors', $post);
    }
}
?>
