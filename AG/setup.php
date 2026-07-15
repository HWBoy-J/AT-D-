<?php

define('DVWA_WEB_PAGE_TO_ROOT', '');
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup(array());

$page = dvwaPageNewGrab();
$page['title'] = '数据库设置';
$page['page_id'] = 'setup';

if (isset($_POST['create_db'])) {
    // Anti-CSRF
    if (array_key_exists("session_token", $_SESSION)) {
        $session_token = $_SESSION['session_token'];
    } else {
        $session_token = "";
    }

    checkToken($_REQUEST['user_token'], $session_token, 'setup.php');

    if ($DBMS == 'MySQL') {
        include_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/DBMS/MySQL.php';
    } elseif ($DBMS == 'PGSQL') {
        // include_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/DBMS/PGSQL.php';
        dvwaMessagePush('PostgreSQL 目前尚未完全支持。');
        dvwaPageReload();
    } else {
        dvwaMessagePush('错误：选择的数据库无效。请检查配置文件的语法。');
        dvwaPageReload();
    }
}

// Anti-CSRF
generateSessionToken();

$database_type_name = "未知 - 该网站可能现在已损坏";
if ($DBMS == 'MySQL') {
    $database_type_name = "MySQL/MariaDB";
} elseif ($DBMS == 'PGSQL') {
    $database_type_name = "PostgreSQL";
}

$page['body'] .= "
<div class=\"body_padded\">
    <h1>数据库设置 <img src=\"" . DVWA_WEB_PAGE_TO_ROOT . "dvwa/images/spanner.png\" /></h1>

    <p>点击下面的“创建 / 重置数据库”按钮以创建或重置您的数据库。<br />
    如果出现错误，请确保在：<em>" . realpath(getcwd() . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.inc.php") . "</em> 中具有正确的用户凭据。</p>

    <p>如果数据库已经存在，<em>将会被清空并重置数据</em>。<br />
    您还可以随时重置管理员凭据（“<em>admin</em> // <em>password</em>”）。</p>
    <hr />
    <br />

    <h2>设置检查</h2>

    {$SERVER_NAME}<br />
    <br />
    {$DVWAOS}<br />
    <br />
    PHP 版本：<em>" . phpversion() . "</em><br />
    {$phpDisplayErrors}<br />
    {$phpDisplayStartupErrors}<br />
    {$phpURLInclude}<br />
    {$phpURLFopen}<br />
    {$phpGD}<br />
    {$phpMySQL}<br />
    {$phpPDO}<br />
    <br />
    后端数据库：<em>{$database_type_name}</em><br />
    {$MYSQL_USER}<br />
    {$MYSQL_PASS}<br />
    {$MYSQL_DB}<br />
    {$MYSQL_SERVER}<br />
    {$MYSQL_PORT}<br />
    <br />
    {$DVWARecaptcha}<br />
    <br />
    {$DVWAUploadsWrite}<br />
    {$bakWritable}
    <br />
    <br />
    <i><span class=\"failure\">红色状态</span>表示在尝试完成某些模块时将会出现问题。</i><br />
    <br />
    如果您在 <i>allow_url_fopen</i> 或 <i>allow_url_include</i> 上看到禁用，请在您的 php.ini 文件中设置以下内容并重启 Apache。<br />
    <pre><code>allow_url_fopen = On
allow_url_include = On</code></pre>
    这些设置仅在文件包含实验中需要，因此除非您想进行这些实验，否则可以忽略它们。

    <br /><br /><br />

    <!-- 创建数据库按钮 -->
    <form action=\"#\" method=\"post\">
        <input name=\"create_db\" type=\"submit\" value=\"创建 / 重置数据库\">
        " . tokenField() . "
    </form>
    <br />
    <hr />
</div>";

dvwaHtmlEcho($page);

?>
