<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = '漏洞：跨站请求伪造 (CSRF)';
$page[ 'page_id' ] = 'csrf';
$page[ 'help_button' ]   = 'csrf';
$page[ 'source_button' ] = 'csrf';

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

require_once DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/csrf/source/{$vulnerabilityFile}";

$testCredentials = "
 <button onclick=\"testFunct()\">测试凭据</button><br /><br />
 <script>
function testFunct() {
  window.open(\"" . DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/csrf/test_credentials.php\", \"_blank\", 
  \"toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=400\");
}
</script>
";

$page[ 'body' ] .= "
<div class=\"body_padded\">
    <h1>漏洞：跨站请求伪造 (CSRF)</h1>

    <div class=\"vulnerable_code_area\">
        <h3>更改您的管理员密码：</h3>
        <br /> 
        <div id=\"test_credentials\">
            ".$testCredentials ."
        </div><br />
        <form action=\"#\" method=\"GET\">";

if( $vulnerabilityFile == 'impossible.php' ) {
    $page[ 'body' ] .= "
            当前密码:<br />
            <input type=\"password\" AUTOCOMPLETE=\"off\" name=\"password_current\"><br />";
}

$page[ 'body' ] .= "
            新密码:<br />
            <input type=\"password\" AUTOCOMPLETE=\"off\" name=\"password_new\"><br />
            确认新密码:<br />
            <input type=\"password\" AUTOCOMPLETE=\"off\" name=\"password_conf\"><br />
            <br />
            <input type=\"submit\" value=\"更改\" name=\"Change\">\n";

if( $vulnerabilityFile == 'high.php' || $vulnerabilityFile == 'impossible.php' )
    $page[ 'body' ] .= "            " . tokenField();

$page[ 'body' ] .= "
        </form>
        {$html}
    </div>
        <p>注意：浏览器开始默认将 <a href='https://web.dev/samesite-cookies-explained/'>SameSite cookie</a> 标志设置为 Lax，因此正在消除某些类型的 CSRF 攻击。当它们完成使命时，这个实验室将无法按原预期工作。</p>
        <p>公告：</p>
        <ul>
            <li><a href='https://chromestatus.com/feature/5088147346030592'>Chromium</a></li>
            <li><a href='https://docs.microsoft.com/en-us/microsoft-edge/web-platform/site-impacting-changes'>Edge</a></li>
            <li><a href='https://hacks.mozilla.org/2020/08/changes-to-samesite-cookie-behavior/'>Firefox</a></li>
        </ul>
        <p>作为托管恶意 URL 或代码的正常攻击的替代方案，您可以尝试使用此应用程序中的其他漏洞来存储它们，存储型 XSS 实验室是一个不错的起点。</p>

    <h2>更多信息</h2>
    <ul>
        <li>" . dvwaExternalLinkUrlGet( 'https://owasp.org/www-community/attacks/csrf' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'http://www.cgisecurity.com/csrf-faq.html' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://en.wikipedia.org/wiki/Cross-site_request_forgery ' ) . "</li>
    </ul>
</div>\n";

dvwaHtmlEcho( $page );

?>

