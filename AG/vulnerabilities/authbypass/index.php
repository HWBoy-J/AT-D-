<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = '漏洞：授权绕过';
$page[ 'page_id' ] = 'authbypass';
$page[ 'help_button' ]   = 'authbypass';
$page[ 'source_button' ] = 'authbypass';
dvwaDatabaseConnect();

$method            = 'GET';
$vulnerabilityFile = '';
switch( dvwaSecurityLevelGet() ) {
    case 'low':
        $vulnerabilityFile = 'low.php';
        break;
    case 'medium':
        $vulnerabilityFile = 'medium.php';
        break;
    case 'high':
        $vulnerabilityFile = 'high.php';
        break;
    default:
        $vulnerabilityFile = 'impossible.php';
        $method = 'POST';
        break;
}

require_once DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/authbypass/source/{$vulnerabilityFile}";

$page[ 'body' ] .= '
<div class="body_padded">
    <h1>漏洞：授权绕过</h1>

    <p>该页面仅应由管理员用户访问。您的挑战是使用其他用户（例如 <i>gordonb</i> / <i>abc123</i>）访问功能。</p>

    <div class="vulnerable_code_area">
    <div style="font-weight: bold;color: red;font-size: 120%;" id="save_result"></div>
    <div id="user_form"></div>
    <p>
        欢迎来到用户管理器，请尽情更新用户的详细信息。
    </p>
    ';

$page[ 'body' ] .= "
<script src='authbypass.js'></script>

<table id='user_table'>
    <thead>
        <th>ID</th>
        <th>名字</th>
        <th>姓氏</th>
        <th>更新</th>
    </thead>
    <tbody>
    </tbody>
</table>

<script>
    populate_form();
</script>
";

$page[ 'body' ] .= '
        ' . 
        $html
        . '
    </div>
</div>';

dvwaHtmlEcho( $page );

?>

