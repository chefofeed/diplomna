<?php

require_once 'mysql_model.php';

class USER extends Mysql_model {

//	private $conn;
//	
    public function __construct() {
        $this->table = 'tbl_users';
//        error_log(var_export($this->conn, true));
//        error_log(get_class($this->conn));
        parent::__construct();
    }

    public function runQuery($sql) {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

//    public function lasdID() {
//        $stmt = $this->conn->lastInsertId();
//        return $stmt;
//    }

    public function register($uname, $email, $upass, $code) {
        try {
            $password = md5($upass);
            $stmt = $this->conn->prepare("INSERT INTO tbl_users(userName,userEmail,userPass,tokenCode) 
			                                             VALUES(:user_name, :user_mail, :user_pass, :active_code)");
            $stmt->bindparam(":user_name", $uname);
            $stmt->bindparam(":user_mail", $email);
            $stmt->bindparam(":user_pass", $password);
            $stmt->bindparam(":active_code", $code);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function login($email, $upass) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
            $stmt->execute(array(":email_id" => $email));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() == 1) {
                if ($userRow['userStatus'] == "Y") {
                    if ($userRow['userPass'] == md5($upass)) {
                        $_SESSION['userSession'] = $userRow['userID'];
                        return true;
                    } else {
                        header("Location: index.php?error");
                        exit;
                    }
                } else {
                    header("Location: index.php?inactive");
                    exit;
                }
            } else {
                header("Location: index.php?error");
                exit;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function is_logged_in() {
        if (isset($_SESSION['userSession'])) {
            return true;
        }
    }

    public function redirect($url) {
        header("Location: $url");
    }

    public function logout() {
        session_destroy();
        $_SESSION['userSession'] = false;
    }

    function send_mail($email, $message, $subject) {
        require_once('mailer/class.phpmailer.php');
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->AddAddress($email);
        //$mail->Username="your_gmail_id_here@gmail.com";
        $mail->Username = "heroesname1992@gmail.com";
        //$mail->Password="your_gmail_password_here"; 
        $mail->Password = "heroesname";
        //$mail->SetFrom('your_gmail_id_here@gmail.com','POll page');
        $mail->SetFrom('heroesname1992@gmail.com', 'POll page');
        //$mail->AddReplyTo("your_gmail_id_here@gmail.com","POll page");
        $mail->AddReplyTo("heroesname1992@gmail.com", "POll page");
        $mail->MsgHTML($message);
        $mail->Send();
    }
    
    function getUser(){
        return $_SESSION['userSession'];
    }

}
