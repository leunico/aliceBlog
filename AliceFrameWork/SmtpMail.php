<?php

/*  
 *  邮件发送类
 *  支持发送纯文本邮件和HTML格式的邮件，可以多收件人，多抄送，多秘密抄送
 *  @leunico 
 */
 
namespace AliceFrameWork;

class SmtpMail { 

    private $_userName;
    private $_password;
    protected $_sendServer;
    protected $_port=25;
    protected $_from;
    protected $_to;
    protected $_cc;
    protected $_bcc;
    protected $_subject;
    protected $_body;
    protected $_attachment;
    protected $_isPlain=false; //是否是纯文本邮件
    protected $_socket;
    protected $_errorMessage;
    protected $debug=false; //是否开启调试
 
    public function __construct($server=EMAIL_SMTP, $username=EMAIL_ADDRESS, $password=EMAIL_PASSWORD, $port=25) {
        
        $u = explode('@',$username);
        $username = $u[0];
        $this->_sendServer = $server;
        $this->_port = $port;
        if(!empty($username)) {
            $this->_userName = base64_encode($username);
        }
        if(!empty($password)) {
            $this->_password = base64_encode($password);
        }
        return true;
        
    }
 
    public function send($to,$title,$content,$from=EMAIL_ADDRESS){//var_dump($this->_userName);var_dump($this->_password);exit();
        
        $this->_from = $from;
        $this->setReceiver($to);
        $this->setMailInfo($title,$content);
        return $this->sendMail();
        
    }
 
    public function setReceiver($to) {
        
        if(isset($this->_to)) {
            if(is_string($this->_to)) {
                $this->_to = array($this->_to);
                $this->_to[] = $to;
                return true;
            }elseif(is_array($this->_to)) {
                $this->_to[] = $to;
                return true;
            }else {
                return false;
            }
        }else {
            $this->_to = $to;
            return true;
        }
        
    }
 
    public function setCc($cc) {
        
        if(isset($this->_cc)) {
            if(is_string($this->_cc)) {
                $this->_cc = array($this->_cc);
                $this->_cc[] = $cc;
                return true;
            }elseif(is_array($this->_cc)) {
                $this->_cc[] = $cc;
                return true;
            }else {
                return false;
            }
        }else {
            $this->_cc = $cc;
            return true;
        }
        
    }
 
    public function setBcc($bcc) {
        
        if(isset($this->_bcc)) {
            if(is_string($this->_bcc)) {
                $this->_bcc = array($this->_bcc);
                $this->_bcc[] = $bcc;
                return true;
            }elseif(is_array($this->_bcc)) {
                $this->_bcc[] = $bcc;
                return true;
            }else {
                return false;
            }
        }else{
            $this->_bcc = $bcc;
            return true;
        }
        
    }
 
    public function setMailInfo($subject, $body, $isPlain=false, $attachment="") {
        
        $this->_subject = $subject;
        $this->_body = $body;
        $this->_isPlain = $isPlain;
        if(!empty($attachment)) {
            $this->_attachment = $attachment;
        }
        return true;
        
    }
 
    public function sendMail() {
        
        $command = $this->getCommand();
        $this->socket();         
        foreach ($command as $value) {
            if($this->sendCommand($value[0], $value[1])) {
                continue;
            }else{
                return false;
            }
        }        
        $this->close(); //其实这里也没必要关闭，smtp命令：QUIT发出之后，服务器就关闭了连接，本地的socket资源会自动释放
        //echo 'Mail OK!';
        return true;
        
    }
 
    public function error(){
        
        if(!isset($this->_errorMessage)) {
            $this->_errorMessage = "";
        }
        return $this->_errorMessage;
        
    }
 
    protected function getCommand() {
        
        $command = array(
                array("HELO sendmail\r\n", 250),
                array("AUTH LOGIN\r\n", 334),
                array($this->_userName . "\r\n", 334),
                array($this->_password . "\r\n", 235),
                array("MAIL FROM:<" . $this->_from . ">\r\n", 250)
                );
        $header = "MIME-Version:1.0\r\n";
        if($this->_isPlain) {
            $header .= "Content-type:text/plain;charset=utf-8\r\n";
        }else{
            $header .= "Content-type:text/html;charset=utf-8\r\n";
        }
        //设置发件人
        $header .= "FROM:test<" . $this->_from . ">\r\n";
        //设置收件人
        if(is_array($this->_to)) {
            $count = count($this->_to);
            for($i=0; $i<$count; $i++){
                $command[] = array("RCPT TO:<" . $this->_to[$i] . ">\r\n", 250);
                $header .= "TO:<" . $this->_to[$i] . ">\r\n";
            }
        }else{
            $command[] = array("RCPT TO:<" . $this->_to . ">\r\n", 250);
            $header .= "TO:<" . $this->_to . ">\r\n";
        }
        //设置抄送
        if(isset($this->_cc)) {
            if(is_array($this->_cc)) {
                $count = count($this->_cc);
                for($i=0; $i<$count; $i++){
                    $command[] = array("RCPT TO:<" . $this->_cc[$i] . ">\r\n", 250);
                    $header .= "CC:<" . $this->_cc[$i] . ">\r\n";
                }
            }else{
                $command[] = array("RCPT TO:<" . $this->_cc . ">\r\n", 250);
                $header .= "CC:<" . $this->_cc . ">\r\n";
            }            
        }
        //设置秘密抄送
        if(isset($this->_bcc)) {
            if(is_array($this->_bcc)) {
                $count = count($this->_bcc);
                for($i=0; $i<$count; $i++){
                    $command[] = array("RCPT TO:<" . $this->_bcc[$i] . ">\r\n", 250);
                    $header .= "BCC:<" . $this->_bcc[$i] . ">\r\n";
                }
            }else{
                $command[] = array("RCPT TO:<" . $this->_bcc . ">\r\n", 250);
                $header .= "BCC:<" . $this->_bcc . ">\r\n";
            }
        }
        $header .= "Subject:" . $this->_subject ."\r\n\r\n";
        $body= $this->_body . "\r\n.\r\n";
        $command[] = array("DATA\r\n", 354);
        $command[] = array($header, "");
        $command[] = array($body, 250);
        $command[] = array("QUIT\r\n", 221);
        return $command;
        
    }
 
    protected function sendCommand($command, $code) {
        echo $this->debug ? 'Send command:' . $command . ',expected code:' . $code . '<br />' : '';
        //发送命令给服务器
        try{
            if(socket_write($this->_socket, $command, strlen($command))){
 
                //当邮件内容分多次发送时，没有$code，服务器没有返回
                if(empty($code))  {
                    return true;
                }
                //读取服务器返回
                $data = trim(socket_read($this->_socket, 1024));
                echo $this->debug ? 'response:' . $data . '<br /><br />' : ''; 
                if($data) {
                    $pattern = "/^".$code."/";
                    if(preg_match($pattern, $data)) {
                        return true;
                    }else{
                        $this->_errorMessage = "Error:" . $data . "|**| command:";
                        return false;
                    }
                }else{
                    $this->_errorMessage = "Error:" . socket_strerror(socket_last_error());
                    return false;
                }
            }else{
                $this->_errorMessage = "Error:" . socket_strerror(socket_last_error());
                return false;
            }
        }catch(Exception $e) {
            $this->_errorMessage = "Error:" . $e->getMessage();
        }
        
    }
 
    protected function readFile() {
        
        if(isset($this->_attachment) && file_exists($this->_attachment)) {
            $file = file_get_contents($this->_attachment);
            return base64_encode($file);
        }else {
            return false;
        }
        
    }

    private function socket() {
        
        if(!function_exists("socket_create")) {
            $this->_errorMessage = "Extension sockets must be enabled";
            return false;
        }
        //创建socket资源
        $this->_socket = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));      
        if(!$this->_socket) {
            $this->_errorMessage = socket_strerror(socket_last_error());
            return false;
        }
        socket_set_block($this->_socket);//设置阻塞模式 
        //连接服务器
        if(!socket_connect($this->_socket, $this->_sendServer, $this->_port)) {
            $this->_errorMessage = socket_strerror(socket_last_error());
            return false;
        }
        socket_read($this->_socket, 1024);         
        return true;
        
    }
 
    private function close() {
        
        if(isset($this->_socket) && is_object($this->_socket)) {
            $this->_socket->close();
            return true;
        }
        $this->_errorMessage = "No resource can to be close";
        return false;
        
    }
    
}