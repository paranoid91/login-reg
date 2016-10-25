<?php

class DB{

    private $_link;
    private static $_instance = null;
    //input data
    private $_inputData = [];
    //prefix for table
    private $_pref;
    //table fields
    private $_fields = ["name", "surname", "middlename", "pass", "mail", "city", "mob_number",
                    "phone_number", "gender", "education", "work_exp", "add_info", "birth_date", "photo"];

    //connect to database
    private function __construct()
    {
        try{
            $this->_link = new PDO( Config::DB_DRIVER .":dbname=" . Config::DB_NAME .";host=". Config::DB_HOST .
                ";charset=" . Config::DB_CHARSET,Config::DB_USER, Config::DB_PASSWORD);
            $this->_pref = Config::DB_PREF;
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    //get only one instance of class
    public static function getInstance()
    {
        if(!isset(self::$_instance))
        {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    
    //get input data
    public function getInput($input, $mode)
    {
        foreach($input as $key => $val)
        {
            $this->_inputData[$key] = clearStr($val);
        }

        if($mode == "add")
        {
            $this->addUser();
        }

    }

    //add user
    private function addUser()
    {
        //implode fields array to string --> (name, username...)
        $fields = implode(",", $this->_fields);
        $prep_values = [];

        //here we make -> VALUES(:name, :surname...) for prepare statement
        foreach ($this->_fields as $value)
        {
            $prep_values[] = ':'. $value;
        }

        //password hash
        $this->_inputData["pass"] = $this->createHash($this->_inputData["pass"]);

        //make date of birth string
        $this->_inputData["birth_date"] = $this->createBirthDate($this->_inputData["day"],
                $this->_inputData["month"], $this->_inputData["year"]);

        //gender
        $this->_inputData["gender"] = (int)$this->_inputData["gender"];
        (isset($_SESSION["photo"])) ? $this->_inputData["photo"] = $_SESSION["photo"] : $this->_inputData["photo"] = "";

        $values = implode(",", $prep_values);
        $query = "INSERT INTO ".$this->_pref."users ({$fields}) VALUES({$values})";

        $stmt = $this->_link->prepare($query);
        if(!$stmt){
            die("Failed to connect database");
        }
        //bind params to each value
        $val_array = explode(",", $values);
        if(isset($_SESSION["photo"]))
            unset($_SESSION["photo"]);


        foreach($val_array as $key => $val)
        {
            $input_key = (substr($val, 1));
            $stmt->bindParam($val, $this->_inputData[$input_key]);
            echo "<pre>"; var_dump($this->_inputData[$input_key]);
        }
        
        $stmt->execute();
        addSuccessMsg($GLOBALS["trans"]["reg_suc"]);
        redirect("Login");
    }

    public function getSessionInfo($id)
    {
        $stmt = $this->_link->prepare("SELECT * FROM {$this->_pref}user_session WHERE user_id = :user_id");
        $stmt->bindParam(":user_id", $id);
        $stmt->execute();
        $data = $stmt->fetch();
        if(!$data)
            return false;
        return $data;
    }
    
    //create password hash
    private function createHash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    //date of birth to string
    private function createBirthDate($day, $month, $year)
    {
        $date = "";
        (strlen($day) > 1) ? $date .= $day : $date .= "0" . $day;
        (strlen($month) > 1) ? $date .= "." . $month : $date .= ".0" . $month;
        $date .= ".{$year}";
        unset($this->_inputData["day"]);
        unset($this->_inputData["month"]);
        unset($this->_inputData["year"]);
        return $date;
    }

    public function getUser($id=false, $mail=false)
    {
        $row = [];

        if($id != false && $mail == false){
            $row["data"] = $id;
            $row["column"] = "id";
        }

        elseif ($mail != false && $id == false){
            $row["data"] = $mail;
            $row["column"] = "mail";
        }

        $stmt = $this->_link->prepare("SELECT * FROM ". $this->_pref ."users WHERE {$row['column']} = :{$row['column']}");
        $stmt->bindParam(":{$row['column']}", $row["data"]);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;
    }

    //get user session
    public function getUserSess($user_id, $code, $remember=false)
    {
        $stmt = $this->_link->prepare("SELECT * FROM {$this->_pref}user_session WHERE user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $data = $stmt->fetch();
        if($data == false){
            $this->_link->query("INSERT INTO {$this->_pref}user_session(user_id,code_sess,user_agent_sess) 
              VALUES('{$user_id}', '{$code}', '{$_SERVER['HTTP_USER_AGENT']}')");
        }else{
            $this->_link->query("UPDATE {$this->_pref}user_session SET code_sess = '{$code}',
                user_agent_sess = '{$_SERVER['HTTP_USER_AGENT']}' WHERE user_id = '{$user_id}'");
        }

        //set cookie if user select remember me
        if($remember == true){
            setcookie("user", $user_id, time()+3600*24*7);
            setcookie("code", $code, time()+3600*24*7);
        }
        $_SESSION["user_id"] = $user_id;
        $_SESSION["code"] = $code;
        redirect("Profile");
    }

    //count num rows
    public function checkRow($row, $getUser = false)
    {
        $row = clearStr($row);
        $stmt = $this->_link->prepare("SELECT * FROM ". $this->_pref ."users WHERE mail = :email");
        $stmt->bindParam(":email", $row);
        $stmt->execute();
        $user = $stmt->fetch();

        if($getUser == true)
        {
            if($user != false)
            {
                return $user;
            }
            return false;
        }
        
        return ($stmt->fetch() == false) ? false : true;
    }

    //close connection
    public function __destruct()
    {
        $this->_link = null;
    }
}