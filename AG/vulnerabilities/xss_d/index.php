<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = '漏洞：基于 DOM 的跨站脚本攻击 (XSS)' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'xss_d';
$page[ 'help_button' ]   = 'xss_d';
$page[ 'source_button' ] = 'xss_d';

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

require_once DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/xss_d/source/{$vulnerabilityFile}";

# 对于不可能的级别，不解码查询字符串
$decodeURI = "decodeURI";
if ($vulnerabilityFile == 'impossible.php') {
    $decodeURI = "";
}

$page[ 'body' ] = <<<EOF
<div class="body_padded">
    <h1>漏洞：基于 DOM 的跨站脚本攻击 (XSS)</h1>

    <div class="vulnerable_code_area">
 
        <p>请选择语言：</p>

        <form name="XSS" method="GET">
            <select name="default">
                <script>
                    if (document.location.href.indexOf("default=") >= 0) {
                        var lang = document.location.href.substring(document.location.href.indexOf("default=")+8);
                        document.write("<option value='" + lang + "'>" + $decodeURI(lang) + "</option>");
                        document.write("<option value='' disabled='disabled'>----</option>");
                    }
                        
                    document.write("<option value='English'>英语</option>");
                    document.write("<option value='French'>法语</option>");
                    document.write("<option value='Spanish'>西班牙语</option>");
                    document.write("<option value='German'>德语</option>");
                </script>
            </select>
            <input type="submit" value="选择" />
        </form>
    </div>
EOF;

$page[ 'body' ] .= "
    <h2>更多信息</h2>
    <ul>
        <li>" . dvwaExternalLinkUrlGet( 'https://owasp.org/www-community/attacks/xss/' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://owasp.org/www-community/attacks/DOM_Based_XSS' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://www.acunetix.com/blog/articles/dom-xss-explained/' ) . "</li>
    </ul>
</div>\n";

dvwaHtmlEcho( $page );

?>

