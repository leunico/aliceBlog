<?php namespace app\Controller;

class Controller
{
    protected static $models;
    
    public function __construct($model)
    {
        //注册！
        $model->Index = 'app\Model\IndexModel';
        $model->Admin = 'app\Model\AdminModel';
        $model->User = 'app\Model\UserModel';
        $model->Article = 'app\Model\ArticleModel';
        $model->Comment = 'app\Model\CommentModel';
        $model->Diary = 'app\Model\DiaryModel';
        $model->Tag = 'app\Model\TagModel';
        $model->Memcache = 'AliceFrameWork\Memcache';
        $model->WeixinClass = 'AliceFrameWork\weixin\WeixinClass';
        $model->Weixin = 'AliceFrameWork\weixin\Weixin';
        $model->JinShan = 'AliceFrameWork\JinShan';
        $model->Qiniu = 'AliceFrameWork\Qiniu';
        $model->SmtpMail = 'AliceFrameWork\SmtpMail';
        self::$models = $model;
    }
    
}
