<?php
/*  
 *  通用方法文件
 *  @leunico 
 */

function Route($GoUrl)
{
    $Url = $GoUrl ? HTTP_ROOT . $GoUrl : HTTP_ROOT . 'index';
    return $Url;
}
function EscapeString($value)
{
    $value = strval($value);
    $value = trim($value); //删除前后空格
    $value = htmlspecialchars($value); //html转义        
    return $value;
}
function Auth($user)
{
    $key = 'admin_user_login';
    $loginInfo = isset($_SESSION[SESSION_PRE . $key]) ? $_SESSION[SESSION_PRE . $key] : '';
    return $loginInfo[$user] ? $loginInfo[$user] : '';
}
function getClass($class = '')
{
    $config = require(ROOT_PATH . '/config/menuclass.php');
    return $class ? $config[$class] : $config;
}
function wordTime($time)
{
    $time = (int) substr($time, 0, 10);
    $int  = time() - $time;
    $str  = '';
    if ($int <= 2) {
        $str = sprintf('刚刚', $int);
    } elseif ($int < 60) {
        $str = sprintf('%d秒前', $int);
    } elseif ($int < 3600) {
        $str = sprintf('%d分钟前', floor($int / 60));
    } elseif ($int < 86400) {
        $str = sprintf('%d小时前', floor($int / 3600));
    } elseif ($int < 2592000) {
        $str = sprintf('%d天前', floor($int / 86400));
    } else {
        $str = date('Y-m-d H:i:s', $time);
    }
    return $str;
}
function EmojiH($msg)
{
    $emoji = array(
        ':mrgreen:',
        ':razz:',
        ':smile:',
        ':oops:',
        ':grin:',
        ':lol:',
        ':neutral:',
        ':idea:',
        ':wink:',
        ':?:',
        ':arrow:',
        ':sad:',
        ':cry:',
        ':eek:',
        ':surprised:',
        ':???:',
        ':cool:',
        ':mad:',
        ':twisted:',
        ':roll:',
        ':evil:',
        ':!:'
    );
    $emojiUrl = array(
        '<img src="/public/img/smilies/icon_mrgreen.gif">',
        '<img src="/public/img/smilies/icon_razz.gif">',
        '<img src="/public/img/smilies/icon_smile.gif">',
        '<img src="/public/img/smilies/icon_redface.gif">',
        '<img src="/public/img/smilies/icon_biggrin.gif">',
        '<img src="/public/img/smilies/icon_lol.gif">',
        '<img src="/public/img/smilies/icon_neutral.gif">',
        '<img src="/public/img/smilies/icon_idea.gif">',
        '<img src="/public/img/smilies/icon_wink.gif">',
        '<img src="/public/img/smilies/icon_question.gif">',
        '<img src="/public/img/smilies/icon_arrow.gif">',
        '<img src="/public/img/smilies/icon_sad.gif">',
        '<img src="/public/img/smilies/icon_cry.gif">',
        '<img src="/public/img/smilies/icon_eek.gif">',
        '<img src="/public/img/smilies/icon_surprised.gif">',
        '<img src="/public/img/smilies/icon_confused.gif">',
        '<img src="/public/img/smilies/icon_cool.gif">',
        '<img src="/public/img/smilies/icon_mad.gif">',
        '<img src="/public/img/smilies/icon_twisted.gif">',
        '<img src="/public/img/smilies/icon_roll.gif">',
        '<img src="/public/img/smilies/icon_evil.gif">',
        '<img src="/public/img/smilies/icon_exclaim.gif">'
    );
    $msg = str_replace($emoji, $emojiUrl, $msg);
    return $msg;
}
function getImage($content, $order = 'ALL')
{
    $pattern = "/<img.*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
    preg_match_all($pattern, $content, $match);
    if (isset($match[1]) && !empty($match[1])) {
        if ($order === 'ALL') {
            return $match[1];
        }
        if (is_numeric($order) && isset($match[1][$order])) {
            return $match[1][$order];
        }
    }
    return '';
}
function AuthComment($type)
{
    $getsession = Auth($type);
    if (!empty($getsession)) {
        return $getsession;
    } else {
        $key = 'comment_author_' . $type;
        $getcookie = isset($_COOKIE[COOKIE_PRE . $key]) ? $_COOKIE[COOKIE_PRE . $key] : '';
        return $getcookie;
    }
}
function Is_email($email)
{
    $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
    return preg_match($pattern, $email);
}
function AjaxError($ErrMsg)
{
    header('HTTP/1.1 405 Method Not Allowed');
    echo $ErrMsg;
    exit;
}
function NotFound()
{
    header('HTTP/1.1 404 Not Found'); //运营
    header("status: 404 Not Found");
    exit();
}
