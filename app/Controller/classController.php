<?php namespace app\Controller;

use AliceFrameWork\View;
use AliceFrameWork\Request;

class classController extends Controller
{
    public function index()
    {
        View::AdminErrorMessage('goback', '非法入口,邪灵退散！！！');
    }
    
    private static function ClassData($class)
    {
        $fields = Request::getRequest('page', 'int');
        $page = isset($fields) && $fields > 0 ? $fields : 1;
        $article = self::$models->Article;
        $mem = self::$models->Memcache;
        $configclass = getClass();
        $meunclass = $configclass['menu_class'];
        $articleclass = $configclass['article_class'];
        if (empty($meunclass[$class]) && empty($articleclass[$class])) {
            View::AdminErrorMessage('goback', '入口错误误误！');
        }
        $ret = $mem->get('classController_ClassData_' . $class . $page);
        $memc = $class;
        if (!empty($meunclass[$class]) && is_array($meunclass[$class])) {
            $class = $meunclass[$class];
            array_shift($class);
            $class = array_flip($class);
        }
        if (empty($ret)) {
            $ret = array();
            $ret['articleClassList'] = $article->getArticleClassList($class, $page);
            $ret['pageNav'] = @array_pop($ret['articleClassList']);
            $mem->set('classController_ClassData_' . $memc . $page, $ret);
        }
        $ret['meunclass'] = $meunclass;
        $ret['articleclass'] = $articleclass;
        $ret['nav'] = $class;
        View::Transmit('newclassshow', $ret);
    }
    
    //>>>导航入口控制扩展
    public function timewait()
    {
        $ret = array();
        $diary = self::$models->Diary;
        $ret['timewait'] = $diary->getTimewiatIndex();
        View::Transmit('twait', $ret);
    }
    
    public function articlebox()
    {
        $mem = self::$models->Memcache;
        $article = self::$models->Article;
        $ret = $mem->get('classController_articlebox');
        if (empty($ret)) {
            $ret = array();
            $ret['articleClassList'] = $article->getArticleBox();
            $mem->set('classController_articlebox', $ret, 12 * 3600);
        }
        View::Transmit('articlebox', $ret);
    }
    
    public function meclass()
    {
        View::Transmit('aboutme');
    }
    
    public function me()
    {
        View::Transmit('aboutme');
    }
    
    public function liuy()
    {
        View::Transmit('liuy');
    }
    
    public function php()
    {
        self::ClassData('php');
    }
    
    public function music()
    {
        self::ClassData('music');
    }
    
    public function js()
    {
        self::ClassData('js');
    }
    
    public function backend()
    {
        self::ClassData('backend');
    }
    
    public function laravel()
    {
        self::ClassData('laravel');
    }
    
    public function left()
    {
        self::ClassData('left');
    }
    
    public function linux()
    {
        self::ClassData('linux');
    }
    
    public function game()
    {
        self::ClassData('game');
    }
    
    public function book()
    {
        self::ClassData('book');
    }
    
    public function acbili()
    {
        self::ClassData('acbili');
    }
    
    public function jishu()
    {
        self::ClassData('jishu');
    }
    
    public function python()
    {
        self::ClassData('python');
    }
    
    /*public function kaiyuan(){
      self::ClassData('kaiyuan');         
      }*/
      
    public function like()
    {
        self::ClassData('like');
    }
    
}
