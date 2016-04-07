<?php namespace app\Controller;

use AliceFrameWork\View;
use AliceFrameWork\Request;

class Article extends Controller
{
    public static function show()
    {
        $fields = Request::getRequest('page', 'int');
        $page = isset($fields) && $fields > 0 ? $fields : 1;
        $ret = $scree = array();
        $article = self::$models->Article;
        if (Request::getRequest('num', 'str') || Request::getRequest('recommend_type', 'int')) {
            $scree['keyword'] = Request::getRequest('keyword', 'str');
            $scree['num'] = Request::getRequest('num', 'str');
            $scree['recommend_type'] = Request::getRequest('recommend_type', 'int');
            $ret['scree'] = $scree;
            $ret['ArticleList'] = $article->getArticleList($page, $scree);
        } else {
            $ret['ArticleList'] = $article->getArticleList($page);
        }
        $ret['pageNav'] = @array_pop($ret['ArticleList']);
        View::Transmit('admin/articles', $ret);
    }
    
    public static function my_show($id)
    {
        $ret = array();
        $article = self::$models->Article;
        $fields = Request::getRequest('page', 'int');
        $page = isset($fields) && $fields > 0 ? $fields : 1;
        $ret['ArticleList'] = $article->getArticleList_My($page, $id);
        $ret['pageNav'] = @array_pop($ret['ArticleList']);
        View::Transmit('admin/article_my', $ret);
    }
    
    public static function delete($id)
    {
        $article = self::$models->Article;
        $result = $article->delArticle(self::$models->make('Qiniu', array('lzxya')), $id);
        $result ? View::AdminMessage('goback', '删除成功') : View::AdminErrorMessage('goback', '删除失败');
    }
    
    public static function add()
    {
        $ret = $fields = array();
        $ret['loginInfo'] = Request::getSession('admin_user_login');
        if (Request::getRequest('dosubmit', 'str')) {
            adminController::is_admin();
            $article = self::$models->Article;
            $tagmodel = self::$models->Tag;
            $fields['title'] = Request::getRequest('title', 'str');
            $fields['seo_title'] = Request::getRequest('seo_title', 'str');
            $fields['seo_description'] = Request::getRequest('seo_description', 'str');
            $fields['seo_keywords'] = Request::getRequest('seo_keywords', 'str');
            $fields['author'] = Request::getRequest('author', 'str');
            $fields['description'] = Request::getRequest('description', 'str');
            $fields['tag'] = Request::getRequest('tag', 'str');
            $fields['mid'] = Request::getRequest('mid', 'str');
            $fields['recommend_type'] = Request::getRequest('recommend_type', 'int');
            $fields['content'] = self::ToolContent(Request::getRequest('content', 'str'));
            $fields['uid'] = $ret['loginInfo']['id'];
            $fields['good_num'] = $fields['bad_num'] = 0;
            $fields['ctime'] = time();
            $fields['image'] = $article->getArticleImage($fields['content'], 0);
            $tags = explode('|', $fields['tag']);
            foreach ($tags as $tag) {
                $tagInfo = $tagmodel->getTagByTag($tag);
                if (!empty($tagInfo)) {
                    $tagInfo['num']++;
                    $tagmodel->editTag($tagInfo['id'], $tagInfo, '');
                } else {
                    $tagFields['tag'] = $tag;
                    $tagFields['num'] = 1;
                    $tagmodel->setTag($tagFields);
                }
            }
            $result = $article->InsertArticle($fields);
            $result ? View::AdminMessage('admin/articles', '添加成功') : View::AdminErrorMessage('goback', '添加失败');
        }
        $ret['blogMenuList'] = getClass('article_class');
        View::Transmit('admin/article_add', $ret);
    }
    
    public static function edit($type, $id)
    {
        $ret = $fields = array();
        $article = self::$models->Article;
        if (Request::getRequest('dosubmit', 'str')) {
            $tagmodel = self::$models->Tag;
            $fields['title'] = Request::getRequest('title', 'str');
            $fields['seo_title'] = Request::getRequest('seo_title', 'str');
            $fields['seo_description'] = Request::getRequest('seo_description', 'str');
            $fields['seo_keywords'] = Request::getRequest('seo_keywords', 'str');
            $fields['author'] = Request::getRequest('author', 'str');
            $fields['description'] = Request::getRequest('description', 'str');
            $fields['tag'] = Request::getRequest('tag', 'str');
            $fields['mid'] = Request::getRequest('mid', 'str');
            $fields['recommend_type'] = Request::getRequest('recommend_type', 'int');
            $fields['content'] = self::ToolContent(Request::getRequest('content', 'str'));
            $fields['clicks'] = Request::getRequest('clickst', 'int');
            $fields['good_num'] = Request::getRequest('good_num', 'int');
            $fields['bad_num'] = Request::getRequest('bad_num', 'int');
            $fields['top'] = Request::getRequest('top', 'int') ? '1' : '0';
            $fields['image'] = $article->getArticleImage($fields['content'], 0);
            $tags = explode('|', $fields['tag']);
            foreach ($tags as $tag) {
                $tagInfo = $tagmodel->getTagByTag('tag', $tag);
                if (empty($tagInfo)) {
                    $tagFields['tag'] = $tag;
                    $tagFields['num'] = 1;
                    $tagmodel->setTag($tagFields);
                }
            }
            $result = $article->editArticle($id, $fields);
            $result ? View::AdminMessage('admin/articles', '修改成功') : View::AdminErrorMessage('goback', '修改失败');
        }
        $ret['blogMenuList'] = getClass('article_class');
        $ret['articles'] = $article->getOneArticle('id', $id);
        View::Transmit($type == '1' ? 'admin/article_edit' : 'admin/article_myedit', $ret);
    }
    
    public static function baiduSite()
    {
        if (Request::getRequest('dosubmit', 'str')) {
            $fields = Request::getRequest('pushbaidu', 'array');
            $api = BAIDU_SITE_API;
            $ch = curl_init();
            $options = array(CURLOPT_URL => $api, CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_POSTFIELDS => implode('
', $fields), CURLOPT_HTTPHEADER => array('Content-Type: text/plain'));
            curl_setopt_array($ch, $options);
            $result = curl_exec($ch);
            strpos($result, 'success') ? View::AdminMessage('goback', '成功推送' . $result) : View::AdminErrorMessage('goback', '推送失败' . $result);
        }
        View::Transmit('admin/baidusite');
    }
    
    public static function ToolContent($content)
    {
        $contentOne = htmlspecialchars_decode($content);
        $contentOne = preg_replace('#<pre.*?>#', '<pre><code class="language-css">', $contentOne);
        return preg_replace('#</pre>#', '</code></pre>', $contentOne);
    }
    
}
