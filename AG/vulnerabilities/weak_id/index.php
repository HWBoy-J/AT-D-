<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = '漏洞：弱会话 ID';
$page[ 'page_id' ] = 'weak_id';
$page[ 'help_button' ]   = 'weak_id';
$page[ 'source_button' ] = 'weak_id';
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

require_once DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/weak_id/source/{$vulnerabilityFile}";

$page[ 'body' ] .= <<<EOF
<div class="body_padded">
    <h1>漏洞：弱会话 ID</h1>
    <p>
        每次点击按钮时，将设置一个名为 dvwaSession 的新 cookie。<br />
    </p>
    <form method="post">
        <input type="submit" value="生成" />
    </form>
</div>
$html

EOF;

/*
也许可以显示这个，但我认为它不是必需的
if (isset ($cookie_value)) {
    $page[ 'body' ] .= <<<EOF
新的 cookie 值是 $cookie_value
EOF;
}
*/

dvwaHtmlEcho( $page );

?>

