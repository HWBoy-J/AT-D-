<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = '漏洞：SQL 注入';
$page[ 'page_id' ] = 'sqli';
$page[ 'help_button' ]   = 'sqli';
$page[ 'source_button' ] = 'sqli';

dvwaDatabaseConnect();

$method            = 'GET';
$vulnerabilityFile = '';
switch( dvwaSecurityLevelGet() ) {
    case 'low':
        $vulnerabilityFile = 'low.php';
        break;
    case 'medium':
        $vulnerabilityFile = 'medium.php';
        $method = 'POST';
        break;
    case 'high':
        $vulnerabilityFile = 'high.php';
        break;
    default:
        $vulnerabilityFile = 'impossible.php';
        break;
}

require_once DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/sqli/source/{$vulnerabilityFile}";

$page[ 'body' ] .= "
<div class=\"body_padded\">
    <h1>漏洞：SQL 注入</h1>

    <div class=\"vulnerable_code_area\">";
if( $vulnerabilityFile == 'high.php' ) {
    $page[ 'body' ] .= "点击 <a href=\"#\" onclick=\"javascript:popUp('session-input.php');return false;\">这里更改您的 ID</a>。";
}
else {
    $page[ 'body' ] .= "
        <form action=\"#\" method=\"{$method}\">
            <p>
                用户 ID:";
    if( $vulnerabilityFile == 'medium.php' ) {
        $page[ 'body' ] .= "\n                <select name=\"id\">";

        for( $i = 1; $i < $number_of_rows + 1 ; $i++ ) { 
            $page[ 'body' ] .= "<option value=\"{$i}\">{$i}</option>"; 
        }
        $page[ 'body' ] .= "</select>";
    }
    else
        $page[ 'body' ] .= "\n                <input type=\"text\" size=\"15\" name=\"id\">";

    $page[ 'body' ] .= "\n                <input type=\"submit\" name=\"Submit\" value=\"提交\">
            </p>\n";

    if( $vulnerabilityFile == 'impossible.php' )
        $page[ 'body' ] .= "            " . tokenField();

    $page[ 'body' ] .= "
        </form>";
}
$page[ 'body' ] .= "
        {$html}
    </div>

    <h2>更多信息</h2>
    <ul>
        <li>" . dvwaExternalLinkUrlGet( 'https://en.wikipedia.org/wiki/SQL_injection' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://www.netsparker.com/blog/web-security/sql-injection-cheat-sheet/' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://owasp.org/www-community/attacks/SQL_Injection' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://bobby-tables.com/' ) . "</li>
    </ul>
</div>\n";

dvwaHtmlEcho( $page );

?>

