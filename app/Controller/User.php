<?php

namespace app\Controller;

use app\Model\UserModel;
use AliceFrameWork\View;
use AliceFrameWork\Request;


class User{
	 
	 public static function show(){
        
        $fields = Request::getRequest('page', 'int');       
        $page = isset($fields) && $fields > 0 ? $fields : 1;
        $ret  = $scree = array();                 
        $ret['userList'] = UserModel::getUserList($page);            
        $ret['pageNav'] = @array_pop($ret['userList']);
		View::Transmit('admin/users',$ret);
        
    }
   
    public static function block($id,$type){
	   
        $fields['is_block'] = $type;
		$result = UserModel::setUserBlock($id,$fields);
		$result ? View::AdminMessage('admin/users','操作成功') : View::AdminErrorMessage('goback','操作失败');
                   	   
    }
	
	public static function delete($id){
       
        $result = UserModel::delUser($id);
		$result ? View::AdminMessage('admin/users','删除成功') : View::AdminErrorMessage('goback','删除失败');                   
        
    }
	
	public static function add(){
        
		$ret = $fields = array();        
        if(Request::getRequest('dosubmit', 'str')){           
            adminController::is_admin();                  
            $fields['username'] = Request::getRequest('username', 'str');           
            $fields['email'] = Request::getRequest('email', 'str');           
            $fields['newpw'] = Request::getRequest('newpw', 'str');           
            $fields['newpw_a'] = Request::getRequest('newpw_a', 'str');                      
            $fields['wxname'] = $fields['openid'] = 'Not wechat';                      
            $fields['ctime'] = time();                                                                   
            $fields['password'] = md5($fields['newpw_a']);
			if(UserModel::getOneUser('email',$fields['email'])) View::AdminErrorMessage('goback','邮箱已经存在了！');  
            unset($fields['newpw']);
			unset($fields['newpw_a']);           
            $result = UserModel::InsertUser($fields);
			$result ? View::AdminMessage('admin/users','添加成功') : View::AdminErrorMessage('goback','添加失败');
        }
	    View::Transmit('admin/user_add',$ret);      
        
    }  
	
	public static function edit($type,$id){
      
	    $ret = $fields = array(); 
	    $ret['users'] = UserModel::getOneUser($type,$id);     
        if(Request::getRequest('dosubmit', 'str')){                        
            $fields['username'] = Request::getRequest('username', 'str');            
            $fields['email'] = Request::getRequest('email', 'str');                                    
            $fields['password'] = Request::getRequest('oldpw', 'str');            
            $fields['newpw'] = Request::getRequest('newpw', 'str');            
            $fields['newpw_a'] = Request::getRequest('newpw_a', 'str');            
            if( empty($fields['password']) && empty($fields['newpw'])){            
                $fields['password'] = $ret['users']['password'];                
                unset($fields['newpw']);                
                unset($fields['newpw_a']); //echo "改昵称";var_dump($fields);                                            
            }else{
                $password = $ret['users']['password'];              
                if($password !== md5($fields['password'])) View::AdminErrorMessage('admin/user_edit','原始密码不正确');               
                $fields['password'] = md5($fields['newpw_a']);                
                unset($fields['newpw']);                
                unset($fields['newpw_a']); //echo "改密码";var_dump($fields);
            }            
            $result = UserModel::editUser($id,$fields);
            if($result){               
                if( $fields['username'] !== $ret['users']['username']){                   
                    $session = Request::getSession('admin_user_login');                    
                    $session['username'] = $fields['username'];                    
                    Request::setSession('admin_user_login', $session);
					UserModel::editArticleAuthor($fields['username'],$id);                    
                }                
                View::AdminMessage('goback','修改成功');                
            }else{
                View::AdminErrorMessage('goback','修改失败');                
            }
       }
	   View::Transmit('admin/user_edit',$ret);      
        
    }
	
	
	
	
	
}