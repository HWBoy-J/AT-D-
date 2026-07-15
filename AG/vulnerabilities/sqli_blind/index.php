<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = '漏洞：SQL 注入（盲注）';
$page[ 'page_id' ] = 'sqli_blind';
$page[ 'help_button' ]   = 'sqli_blind';
$page[ 'source_button' ] = 'sqli_blind';

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

require_once DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/sqli_blind/source/{$vulnerabilityFile}";

// 检查 PHP 函数 magic_quotee 是否启用
$WarningHtml = '';
if( ini_get( 'magic_quotes_gpc' ) == true ) {
    $WarningHtml .= "<div class=\"warning\">PHP 函数 \"<em>Magic Quotes</em>\" 已启用。</div>";
}
// 检查 PHP 函数 safe_mode 是否启用
if( ini_get( 'safe_mode' ) == true ) {
    $WarningHtml .= "<div class=\"warning\">PHP 函数 \"<em>Safe mode</em>\" 已启用。</div>";
}

$page[ 'body' ] .= "
<div class=\"body_padded\">
    <h1>漏洞：SQL 注入（盲注）</h1>

    {$WarningHtml}

    <div class=\"vulnerable_code_area\">";
if( $vulnerabilityFile == 'high.php' ) {
    $page[ 'body' ] .= "点击 <a href=\"#\" onclick=\"javascript:popUp('cookie-input.php');return false;\">这里更改您的 ID</a>.";
}
else {
    $page[ 'body' ] .= "
        <form action=\"#\" method=\"{$method}\">
            <p>
                用户 ID:";
    if( $vulnerabilityFile == 'medium.php' ) {
        $page[ 'body' ] .= "\n                <select name=\"id\">";
        $query  = "SELECT COUNT(*) FROM users;";
        $result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );
        $num    = mysqli_fetch_row( $result )[0];
        $i      = 0;
        while( $i < $num ) { $i++; $page[ 'body' ] .= "<option value=\"{$i}\">{$i}</option>"; }
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
        <li>" . dvwaExternalLinkUrlGet( 'http://pentestmonkey.net/cheat-sheet/sql-injection/mysql-sql-injection-cheat-sheet' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://owasp.org/www-community/attacks/Blind_SQL_Injection' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://bobby-tables.com/' ) . "</li>
    </ul>
</div>\n";

dvwaHtmlEcho( $page );

?>

