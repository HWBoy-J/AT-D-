<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = '漏洞：开放 HTTP 重定向';
$page[ 'page_id' ] = 'open_redirect';
$page[ 'help_button' ]   = 'open_redirect';
$page[ 'source_button' ] = 'open_redirect';
dvwaDatabaseConnect();

switch( dvwaSecurityLevelGet() ) {
    case 'low':
        $link1 = "source/low.php?redirect=info.php?id=1";
        $link2 = "source/low.php?redirect=info.php?id=2";
        break;
    case 'medium':
        $link1 = "source/medium.php?redirect=info.php?id=1";
        $link2 = "source/medium.php?redirect=info.php?id=2";
        break;
    case 'high':
        $link1 = "source/high.php?redirect=info.php?id=1";
        $link2 = "source/high.php?redirect=info.php?id=2";
        break;
    default:
        $link1 = "source/impossible.php?redirect=1";
        $link2 = "source/impossible.php?redirect=2";
        break;
}

$page[ 'body' ] .= "
<div class=\"body_padded\">
    <h1>漏洞：开放 HTTP 重定向</h1>

    <div class=\"vulnerable_code_area\">
        <h2>黑客历史</h2>
        <p>
            这里有两个链接到一些著名的黑客名言，看看你能否破解它们。
        </p>
        <ul>
            <li><a href='{$link1}'>名言 1</a></li>
            <li><a href='{$link2}'>名言 2</a></li>
        </ul>
        {$html}
    </div>

    <h2>更多信息</h2>
    <ul>
        <li>" . dvwaExternalLinkUrlGet( 'https://cheatsheetseries.owasp.org/cheatsheets/Unvalidated_Redirects_and_Forwards_Cheat_Sheet.html', "OWASP 未验证的重定向和转发备忘单" ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://owasp.org/www-project-web-security-testing-guide/stable/4-Web_Application_Security_Testing/11-Client-side_Testing/04-Testing_for_Client-side_URL_Redirect', "WSTG - 测试客户端 URL 重定向") . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://cwe.mitre.org/data/definitions/601.html', "Mitre - CWE-601：重定向到不信任站点的 URL（'开放重定向'）" ) . "</li>
    </ul>
</div>\n";

dvwaHtmlEcho( $page );

?>
