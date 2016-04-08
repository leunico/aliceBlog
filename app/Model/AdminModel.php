<?php namespace app\Model;

use AliceFrameWork\Example;

class ArticleModel
{
    private $example;
    
    public function __construct()
    {
        $this->example = new Example('info_article');
    }
    
    public function getArticleList($page, $scree = array())
    {
        if (empty($scree)) {
            return $this->example->Data('a.* ,COUNT(b.id) AS count')->Join('info_comment', 'LEFT', 'a.id=b.aid')->where('', '')->group('a.id')->order('ctime', 'DESC')->Paginate($page, 10);
        } else {
            $order = $scree['num'] ? $scree['num'] : 'ctime';
            $key = array();
            if ($scree['recommend_type'] == 1 || $scree['recommend_type'] == 2) {
                $whereleft = 'recommend_type';
                $whereright = $scree['recommend_type'];
            } else {
                if ($scree['recommend_type'] == 3) {
                    $whereleft = 'top';
                    $whereright = 1;
                } else {
                    $whereleft = '';
                    $whereright = '';
                }
            }
            if ($scree['keyword'] !== '') {
                $whereleft = array($whereleft, 'title');
                $whereright = array($whereright, '%' . $scree['keyword'] . '%');
                $key = array('=', 'LIKE');
            }
            return $this->example->Data('a.* ,COUNT(b.id) AS count')->Join('info_comment', 'LEFT', 'a.id=b.aid')->where($whereleft, $whereright, $key)->group('a.id')->order($order, 'DESC')->Paginate($page, 10, $scree);
        }
    }
    
    public function getArticleList_My($page, $id)
    {
        return $this->example->Data('a.* ,COUNT(b.id) AS count')->Join('info_comment', 'LEFT', 'a.id=b.aid')->where('uid', $id)->group('a.id')->order('ctime', 'DESC')->Paginate($page, 10);
    }
    
    public function getArticleClassList($class, $page)
    {
        if (is_array($class)) {
            return $this->example->Data('a.* ,COUNT(b.id) AS comcount')->Join('info_comment', 'LEFT', 'a.id=b.aid')->where('a.mid', implode('\',\'', $class), 'IN')->group('a.id')->order('ctime', 'DESC')->Pageindex($page, 10);
        } else {
            return $this->example->Data('a.* ,COUNT(b.id) AS comcount')->Join('info_comment', 'LEFT', 'a.id=b.aid')->where('a.mid', $class)->group('a.id')->order('ctime', 'DESC')->Pageindex($page, 10);
        }
    }
    
    public function getArticleTagShow($tag, $page)
    {
        return $this->example->Data('a.* ,COUNT(b.id) AS comcount')->Join('info_comment', 'LEFT', 'a.id=b.aid')->where('tag', $tag, 'LIKE')->group('a.id')->order('ctime', 'DESC')->Pageindex($page, 10);
    }
    
    public function getNewArticleList()
    {
        return $this->example->Data('ctime,image,title,id')->where('', '')->order('ctime', 'DESC')->get(6);
    }
    
    public function getCommentArticleList()
    {
        return $this->example->Data('a.ctime,a.image,a.title,a.id,COUNT(b.id) AS count')->Join('info_comment', 'INNER', 'a.id=b.aid')->group('b.aid')->order('count', 'DESC')->get(6);
    }
    
    public function getArticleShow($id)
    {
        $result = $this->getOneArticle('id', $id);
        if (empty($result)) {
            return FALSE;
        }
        $result['next'] = $this->example->Data('title,id')->where('ctime', $result['ctime'], '>')->order('ctime', 'ASC')->get(1);
        $result['oneone'] = $this->example->Data('title,id')->where('ctime', $result['ctime'], '<')->order('ctime', 'DESC')->get(1);
        return $result;
    }
    
    public function getPushArticleList()
    {
        return $this->example->Data('ctime,image,title,id')->where('recommend_type', 2, '<')->order(array('recommend_type', 'ctime'), array('DESC', 'DESC'))->get(6);
    }
    
    public function getArticleRelevant($mid, $id)
    {
        return $this->example->Data('image,title,id')->where(array('mid', 'id'), array($mid, $id), array('=', '!='))->order('good_num', 'DESC')->get(4);
    }
    
    public function InsertArticle($fields)
    {
        return $this->example->Insert($fields)->change();
    }
    
    public function updatePlus($id, $type)
    {
        return $this->example->query('UPDATE info_article SET `' . $type . '` = `' . $type . "` + 1 WHERE id={$id}");
    }
    
    public function editArticle($id, $fields)
    {
        return $this->example->Update($fields)->where('id', $id)->change();
    }
    
    public function getOneArticle($type, $value)
    {
        return $this->example->Find($type, $value);
    }
    
    public function delArticle($thumb, $id)
    {
        $article = $this->example->Find('id', $id);
        $image = $this->getarticleImage($article['content'], 'ALL');
        if (!empty($image)) {
            $this->delArticleImage($thumb, $image);
        }
        return $this->example->Delete()->where('id', $id)->change();
    }
    
    public function delArticleImage($thumb, $image)
    {
        $imgs = array();
        if (YUN_IMAGE) {
            foreach ($image as $val) {
                $qiniuimg = explode('/', $val);
                $img = explode('?', $qiniuimg[3]);
                $thumb->Delete($img[0]);
            }
        } else {
            foreach ($image as $val) {
                $jinshanimg = explode('/', $val);
                $img = explode('@', $jinshanimg[3]);
                $imgs[] = $img[0];
            }
            $thumb->Delete($imgs);
        }
    }
    
    public function getArticleImage($content, $order = 'ALL')
    {
        $pattern = '/<img.*?src=[\\\'|"](.*?(?:[\\.gif|\\.jpg|\\.png]))[\\\'|"].*?[\\/]?>/';
        preg_match_all($pattern, $content, $match);
        if (isset($match[1]) && !empty($match[1])) {
            if ($order === 'ALL') {
                return $match[1];
            }
            if (is_numeric($order) && isset($match[1][$order])) {
                $img = explode('@', $match[1][$order]);
                return YUN_IMAGE ? $img[0] . '?imageView2/1/w/210/h/140' : $img[0] . '@base@tag=imgScale&q=100&w=230';
            }
        }
        return '';
    }
    
    public function getArticleBox()
    {
        $resulta = $this->example->Data('FROM_UNIXTIME( ctime,\'%Y-%m\' ) AS pubtime, COUNT( * ) AS count')->group('pubtime')->order('ctime', 'DESC')->get();
        $resultb = $this->example->Data('FROM_UNIXTIME( a.ctime,\'%Y-%m\' ) AS pubtime, COUNT( b.id ) AS count, a.title, a.id, a.ctime')->Join('info_comment', 'LEFT', 'a.id = b.aid')->group('a.id')->get();
        $result = array();
        foreach ($resulta as $ret) {
            foreach ($resultb as $val) {
                if ($ret['pubtime'] == $val['pubtime']) {
                    $result[$ret['pubtime']][] = $val;
                }
            }
        }
        return $result;
    }
    
}
