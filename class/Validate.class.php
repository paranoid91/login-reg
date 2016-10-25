<?php

//validation class

class Validate{

	//required fields
	private $_required = [];

	//input from post
	private $_input = [];

	// validate mode - login or register
	private $_mode;

	public $errors = [];

	public function __construct($mode, $post_input)
	{
		//set mode
		$this->_mode = $mode;

		foreach($post_input as $name => $val)
		{
			//escape Input data
			$this->_input[$name] = strip_tags($val);
			$_SESSION[$name] = strip_tags($val);
		}
		//check for mode(login or register)
		if($this->_mode == "Registration")
		{
			$this->_required = [
				"name", "surname", "middlename", "pass", "pass-rep", "month", "day", "year",
				"mail", "gender"
			];

			$this->validateReg();
		}
		elseif($this->_mode == "Login")
		{
			$this->_required = [
				"mail", "pass"
			];

			$this->validateLogin();
		}

	}

	//execute necessary methods to validate registration
	private function validateReg()
	{
		//first check for required fields
		$this->isEmpty();
		//check names
		$this->checkNames($this->_input["name"], $this->_input["surname"], $this->_input["middlename"]);
		//check password
		$this->checkPassword($this->_input["pass"]);
		//check passwords matches
		$this->checkPasswords($this->_input["pass"], $this->_input["pass-rep"]);
		//check mail
		$this->checkMail($this->_input["mail"]);
		//check if email exists
		$this->checkIfEmailExist();
		//check gender
		$this->checkGender($this->_input);
		//check birth date
		$this->checkBirthDate($this->_input["day"], $this->_input["month"], $this->_input["year"]);
		//check city
		$this->checkCity($this->_input["city"]);
		//check phone numbers
		$this->checkPhoneNum($this->_input["phone_number"], $this->_input["mob_number"]);
		//check text areas
		$this->checkTextAreas($this->_input["education"], $this->_input["work_exp"], $this->_input["add_info"]);
		//validate photo
		$this->validPhoto();
		//check errors array
		$this->checkErrors();
		
		$this->removePost();
		//remove input data from session
		foreach($this->_input as $key => $val)
		{
			removeValue($key);
		}

		//add user to database
		$db = DB::getInstance();
		$db->getInput($this->_input, "add");
		
	}
	
	private function checkErrors()
	{
		if(count($this->errors) > 0)
		{
			saveErrorMsg($this->errors);
			redirect($this->_mode);
		}
	}

	//execute necessary methods to validate login
	private function validateLogin()
	{
		$this->isEmpty();
		$this->checkIfEmailExist(true);
		$this->checkErrors();

		$this->login();
		//remove input data from session
		foreach($this->_input as $key => $val)
		{
			removeValue($key);
		}
	}

	//check if required fields are filled
	private	function isEmpty()
	{
		foreach($this->_required as $field)
		{
			if (!filter_has_var(INPUT_POST, $field)) {
				$this->errors[] = $GLOBALS["trans"]["fillinreq"];
				break;
			}
		}
	}

	//check password
	private function checkPassword($password)
	{
		if(!$this->validPassword($password))
		{
			$this->errors[] = $GLOBALS["trans"]["pass_err"];
		}
	}

	//check name, middlename, surname
	private function checkNames($name, $surname, $middlname)
	{
		if(!$this->validName($name))
			$this->errors[] = "{$GLOBALS["trans"]["invalid"]} {$GLOBALS["trans"]["name"]}";
		if(!$this->validName($surname))
			$this->errors[] = "{$GLOBALS["trans"]["invalid"]} {$GLOBALS["trans"]["surname"]}";
		if(!$this->validName($middlname))
			$this->errors[] = "{$GLOBALS["trans"]["invalid"]} {$GLOBALS["trans"]["midname"]}";
	}

	//validate names
	private function validName($name)
	{
		if(!preg_match("/^[a-zA-Z\'\-]{2,50}$/", $name))
			return false;
		return true;
	}

	//validate password - at least 8 chars, both cases
	private function validPassword($password)
	{
		if(strlen($password) < 8)
			return false;
		if(!preg_match("/\d/",$password))
			return false;
		if(!preg_match("/[a-z]/i",$password))
			return false;
		return true;
	}

	private function checkPasswords($pass, $rpass)
	{
		if(!$this->matchPasswords($pass, $rpass))
		{
			$this->errors[] = $GLOBALS["trans"]["rep_pass_err"];
		}
	}

	//check if passwords match each other
	private function matchPasswords($pass, $rpass)
	{
		return ($pass === $rpass) ? true : false;
	}

	private function checkMail($email)
	{
		if(!$this->validMail($email))
		{
			$this->errors[] = $GLOBALS["trans"]["mail_err"];
			return false;
		}
		return true;
	}

	
	
	//validate email
	private function validMail($email){
		if((strlen($email)<6) or (!preg_match("/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-.]+$/", $email)))
			return false;
		return true;
	}

	//check if email exists
	private function checkIfEmailExist($login = false)
	{
		$db = DB::getInstance();
		$res = $db->checkRow($this->_input["mail"], true);

		if($login == true)
		{
			if($res == false){
				$this->errors[] = $GLOBALS["trans"]["nouser"];
				return false;
			}

			if(password_verify($this->_input["pass"], $res["pass"])){
				return true;
			}
			$this->errors[] = $GLOBALS["trans"]["incpass"];
			return false;
		}
		else
		{
			if($res == true){
				$this->errors[] = $GLOBALS["trans"]["mailtaken"];;
				return false;
			}
		}
	}
	
	//validate phone numbers
	private function checkPhoneNum($phone, $mob)
	{
		if(strlen($phone) > 0)
		{
			if(!preg_match("/^\d{6,30}$/", $phone))
			{
				$this->errors[] = $GLOBALS["trans"]["phone_err"];
			}
		}
		if(strlen($mob) > 0)
		{
			if(!preg_match("/^\d{6,30}$/", $mob))
			{
				$this->errors[] = $GLOBALS["trans"]["mob_err"];
			}
		}
	}

	//check education, work_exp and about text areas
	private function checkText($text)
	{
		if(strlen($text) > 1000)
			return false;
		return true;
	}

	private function checkGender($input)
	{
		if(!array_key_exists("gender", $input))
		{
			$this->errors[] = $GLOBALS["trans"]["selectgender"];
		}
	}

	private function login()
	{
		$db = DB::getInstance();
		$user = $db->getUser(false, $this->_input["mail"]);
		$code = randStr(40);
		$db->getUserSess($user["id"], $code, (isset($this->_input["remember"])) ? true : false);
	}

	//validate date of birth
	private function checkBirthDate($day, $month, $year)
	{
		$day = clearInt($day);
		$year = clearInt($year);
		$month = clearInt($month);

		if($day > 31 || $day < 1)
		{
			$this->errors[] = $GLOBALS["trans"]["day_err"];
		}
		if($year > 2016 || $year < 1900)
		{
			$this->errors[] = $GLOBALS["trans"]["month_err"];
		}
		if($month > 12 || $month < 1)
		{
			$this->errors[] = $GLOBALS["trans"]["year_err"];
		}
	}

	//validate city
	private function checkCity($city)
	{
		if(!empty($city) && strlen($city) > 0)
		{
			if(!preg_match("/^[a-zA-Z\'\-\s]{2,60}$/", $city))
			{
				$this->errors[] = $GLOBALS["trans"]["city_err"];
			}
		}
	}

	private function removePost()
	{
		if(isset($this->_input["pass-rep"]))
			unset($this->_input["pass-rep"]);
		if(isset($this->_input["reg"]))
			unset($this->_input["reg"]);
		if(isset($this->_input["token"]))
			unset($this->_input["token"]);
	}

	//check texts areas
	private function checkTextAreas($edu, $work, $about)
	{
		if(strlen($edu) > 0 && strlen($edu) > 1000)
		{
			$this->errors[] = "{$GLOBALS["trans"]["education"]} {$GLOBALS["trans"]["area_err"]}";
		}
		if(strlen($work) > 0 && strlen($work) > 1000)
		{
			$this->errors[] = "{$GLOBALS["trans"]["work"]} {$GLOBALS["trans"]["area_err"]}";
		}
		if(strlen($about) > 0 && strlen($about) > 1000)
		{
			$this->errors[] = "{$GLOBALS["trans"]["additional"]} {$GLOBALS["trans"]["area_err"]}";
		}
	}

	
	//validate photo
	private function validPhoto()
	{
		if(isset($_FILES["photo"]) && !empty($_FILES["photo"]["name"]))
		{
			//check image size
			if($_FILES["photo"]["size"] == 0)
			{
				$this->errors[] = $GLOBALS["trans"]["max_size"];
				return false;
			}

			if(file_exists($_FILES['photo']['tmp_name']) && is_uploaded_file($_FILES['photo']['tmp_name']))
			{
				$blacklist = [".php", ".phtml", ".php3", ".php4", ".pl", ".PL", ".sh"];
				$accepted = [".png", ".jpg", ".jpeg", ".gif"];

				//check if file is image
				if(($_FILES['photo']['type'] != "image/gif") && ($_FILES['photo']['type'] != "image/jpeg") &&
					($_FILES['photo']['type'] != "image/png") && ($_FILES['photo']['type'] != "image/pjpeg"))
				{
					$this->errors[] = $GLOBALS["trans"]["img_ext_err"];
					return false;
				}

				//check if file is php script
				foreach ($blacklist as $extn)
				{
					if(preg_match("/$extn\$/i", $_FILES['photo']['name'])) {
						$this->errors[] = $GLOBALS["trans"]["img_ext_err"];
						return false;
					}
				}

				//check if file is image extension
				$dash = "|";
				foreach($accepted as $ext)
				{
					if(preg_match('/^.*\.('.$dash.')$/i', $ext))
					{
						$this->errors[] = $GLOBALS["trans"]["img_ext_err"];
						return false;
					}
				}

				$img = "img/" . basename($_FILES['photo']['name']);

				if (move_uploaded_file($_FILES['photo']['tmp_name'], $img)) {
					$_SESSION["photo"] = $img;
					return true;
				} else {
					$this->errors[] = $GLOBALS["trans"]["upl_fail"];
					return false;
				}
			}
		}
	}

}