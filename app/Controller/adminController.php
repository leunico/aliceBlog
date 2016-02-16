<?php

namespace app\Controller;

use app\Model\AdminModel;
use app\Model\UserModel;
use AliceFrameWork\View;
use AliceFrameWork\Request;
use AliceFrameWork\weixin\Weixin;

class adminController{

    protected $sessionId = 'admin_user_login';
    	
    #>>>后台权限控制！
	public function __construct(){
        
        $controller =  Request::getController();        
        if ( $controller !== 'login' && $controller !== 'logingo' && $controller !== 'wxlogin'){                        
            $loginInfo = Request::getSession($this->sessionId);            
            if (empty($loginInfo) || empty($loginInfo['username']) || empty($loginInfo['id'])) {               
                View::AdminErrorMessage('admin/login', '对不起，你还没有登录！', '_top');
            }            
            if(!empty($loginInfo['block']) && $loginInfo['block'] == '1') {                
                Request::delSession($this->sessionId);                
                View::AdminErrorMessage('', '你的帐号被管理员拉黑了！');
            }            
        }
        
	}
	
    #>>>管理权限控制
    public static function is_admin($id=''){
        
        $loginInfo = Request::getSession('admin_user_login');        
        $result = AdminModel::getByUserId($loginInfo['id']);        
        if($id !== ''){            
            $article = AdminModel::getByArticleId($id);            
            if($article['uid'] !== $loginInfo['id'] && $result['is_admin'] == '0') View::AdminErrorMessage('goback', '你没有这篇文章的操作权限！');            
            return $result['is_admin'];            
        }else{        
            if($result['is_admin'] == '0') View::AdminErrorMessage('goback', '对不起，你没有这个操作的权限！');            
        }
        
	}
	
	#>>>对登录的操作
	public function login(){
		
        $loginInfo = Request::getSession($this->sessionId);
        if (!empty($loginInfo) && !empty($loginInfo['username']) && !empty($loginInfo['id'])) {            
            View::AdminMessage('admin/index', '您已经登录了!');
        }
        $ret = array(); //生成微信登录用的二维码
        $weixinObj = new Weixin();
        $ret['scene_id'] = rand(100,999); //不安全，小博客就不考虑这么多了
        $ret['wximage'] = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$weixinObj ->get_code_image($ret['scene_id']);
        View::Transmit('admin/login',$ret);
        
	}
    
    public function loginout() {
        
        Request::delSession($this->sessionId);        
        View::AdminMessage('admin/login', "退出后台成功!");
        
    }
	
	public function logingo(){        
        
		if(Request::getRequest('dosubmit', 'str')) {            
            $email = Request::getRequest('email', 'str');            
            $password = md5(Request::getRequest('password', 'str'));                                  
            $result = AdminModel::getByUser($email);//var_dump($result);exit();            
            if($result['is_block'] == '1') View::AdminErrorMessage('admin/login', 'sorry,你的帐号被管理员拉黑！');
			if (isset($result) && $result['password'] == $password) {               
                $session = array();                
                $session['id'] = $result['id'];               
                $session['username'] = $result['username'];                
                $session['type'] = 'pc';                
                $session['block'] = $result['is_block'];                
                $session['email'] = $result['email'];                
                Request::setSession($this->sessionId, $session);//var_dump($_SESSION);                
                View::jsJump('/admin/index');                
            } else {                 
                View::AdminErrorMessage('admin/login', '密码or帐号错误，登录后台失败!');
            }
        }
		
	}
       	
    public function wxlogin(){
        
        if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {           
            header('Allow: POST');               
            header('HTTP/1.1 405 Method Not Allowed');               
            header('Content-Type: text/plain');               
            exit('Illegal request!');
        }
        $scene_id = $_POST['scene_id'] ? intval($_POST['scene_id']):'';        
        $result = UserModel::getweixinUser($scene_id);
        if(!empty($result)){       
            $result_u = UserModel::getOneUser('openid',$result['openid']);
            UserModel::delweixinUser($scene_id);
            $session = array();                
            $session['id'] = $result_u['id'];                
            $session['username'] = $result_u['username'];          
            $session['type'] = 'pc';          
            $session['block'] = $result_u['is_block'];            
            $session['email'] = $result_u['email'];                
            Request::setSession($this->sessionId, $session);                        
            echo 'sucess';          
        }else{                  
            echo '请扫描二维码！';       
        }
        
    }
	
	public function index(){
				
        View::Transmit('admin/index');
        
    }
	
    public function wxindex(){
		
        //这里可以对微信登录用户进行一些操作~~~
        View::jsJump('/admin/index');
        
    }
    
	#>>>对用户的操作
    public function user_edit(){
		
        $loginInfo = Request::getSession($this->sessionId);        
        User::edit('id',$loginInfo['id']);
		
    }
    
    public function users(){
        
        self::is_admin();        
        User::show();
		
	}
    
    public function user_block($id){
        
        self::is_admin();        
        User::block($id,$type='1');
		
	}
    
    public function user_unblock($id){
        
        self::is_admin();        
        User::block($id,$type='0');
		
	}
    
    public function user_delete($id){
        
        self::is_admin();        
        User::delete($id);		
		
	}
    
    public function user_add(){
        
        User::add();		
		
	}	
	
	#>>>对文章的操作
    public function articles(){
        
        Article::show();				
	}
    
    public function article_my($id=''){
        
        $loginInfo = Request::getSession($this->sessionId);        
        $tid = ($id == "" ? $loginInfo['id'] : $id);        
        Article::my_show($tid);		
		
	}
    
    public function article_add(){
        
        Article::add();				
	}
    
    public function article_edit($id){
        
        $type = self::is_admin($id);        
        Article::edit($type,$id);		
		
	}
    
    public function article_delete($id){
        
        self::is_admin($id);        
        Article::delete($id);		
		
	}
	
	#>>>对标签的操作
    public function tags(){
     
        Tag::tags();
        
    }
    
    public function tag_edit($id){
        
        self::is_admin();        
        Tag::tag_edit($id);		
		
	}
    
    public function tag_delete($id){
        
        self::is_admin();        
        Tag::tag_delete($id);		
		
	}
	
	#>>>对评论的操作
    public function comments(){
        
        Comment::comments();
        
    }
    
    public function comment_edit($id){
        
        self::is_admin();        
        Comment::comment_edit($id);
        
    }
    
    public function comment_delete($id){
        
        self::is_admin();       
        Comment::comment_delete($id);
        
    }
	
	#>>>对时光旅行的操作
    public function timewaits(){
        
        Diary::timewaits();
        
    }
    
    public function timewait_add(){
        
        self::is_admin();        
        Diary::timewait_add();
        
    }
    
    public function timewait_edit($id){
        
        self::is_admin();        
        Diary::timewait_edit($id);
        
    }
    
    public function timewait_delete($id){
        
        self::is_admin();       
        Diary::timewait_delete($id);
        
    }
    
    public function setorder(){
        
        $loginInfo = Request::getSession('admin_user_login');        
        $result = AdminModel::getByUserId($loginInfo['id']);
        if($result['is_admin'] == '0'){
            echo "error";
        }else{
            echo Diary::setorder();
        }           
        
    }
	
	#>>>首页推送
    public function pushs(){
        
        self::is_admin();
        Diary::pushs();       
        
    }
	
	#>>>更新缓存
	public function mem_updata(){
		
		self::is_admin();
		AdminModel::MemUpdata();
		
	}
	
	#>>>百度推送
    public function go_baidu(){
         
        self::is_admin();        
        Article::baiduSite();	
        
    }
		
	
}