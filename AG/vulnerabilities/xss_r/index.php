<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = '漏洞：反射型跨站脚本攻击 (XSS)' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'xss_r';
$page[ 'help_button' ]   = 'xss_r';
$page[ 'source_button' ] = 'xss_r';

dvwaDatabaseConnect();

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
        break;
}

require_once DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/xss_r/source/{$vulnerabilityFile}";

$page[ 'body' ] .= "
<div class=\"body_padded\">
    <h1>漏洞：反射型跨站脚本攻击 (XSS)</h1>

    <div class=\"vulnerable_code_area\">
        <form name=\"XSS\" action=\"#\" method=\"GET\">
            <p>
                你的名字是什么？
                <input type=\"text\" name=\"name\">
                <input type=\"submit\" value=\"提交\">
            </p>\n";

if( $vulnerabilityFile == 'impossible.php' )
    $page[ 'body' ] .= "            " . tokenField();

$page[ 'body' ] .= "
        </form>
        {$html}
    </div>

    <h2>更多信息</h2>
    <ul>
        <li>" . dvwaExternalLinkUrlGet( 'https://owasp.org/www-community/attacks/xss/' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://owasp.org/www-community/xss-filter-evasion-cheatsheet' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://en.wikipedia.org/wiki/Cross-site_scripting' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'http://www.cgisecurity.com/xss-faq.html' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'http://www.scriptalert1.com/' ) . "</li>
    </ul>
</div>\n";

dvwaHtmlEcho( $page );

?>

