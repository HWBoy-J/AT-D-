<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';
require_once DVWA_WEB_PAGE_TO_ROOT . "external/recaptcha/recaptchalib.php";

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = '漏洞：不安全的 CAPTCHA';
$page[ 'page_id' ] = 'captcha';
$page[ 'help_button' ]   = 'captcha';
$page[ 'source_button' ] = 'captcha';

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

$hide_form = false;
require_once DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/captcha/source/{$vulnerabilityFile}";

// 检查是否有 reCAPTCHA 密钥
$WarningHtml = '';
if( $_DVWA[ 'recaptcha_public_key' ] == "" ) {
    $WarningHtml = "<div class=\"warning\"><em>缺少 reCAPTCHA API 密钥</em>，请查看配置文件: " . realpath( getcwd() . DIRECTORY_SEPARATOR . DVWA_WEB_PAGE_TO_ROOT . "config" . DIRECTORY_SEPARATOR . "config.inc.php" ) . "</div>";
    $html = "<em>请从 reCAPTCHA 注册密钥</em>： " . dvwaExternalLinkUrlGet( 'https://www.google.com/recaptcha/admin/create' );
    $hide_form = true;
}

$page[ 'body' ] .= "
    <div class=\"body_padded\">
    <h1>漏洞：不安全的 CAPTCHA</h1>

    {$WarningHtml}

    <div class=\"vulnerable_code_area\">
        <form action=\"#\" method=\"POST\" ";

if( $hide_form )
    $page[ 'body' ] .= "style=\"display:none;\"";

$page[ 'body' ] .= ">
            <h3>更改您的密码：</h3>
            <br />

            <input type=\"hidden\" name=\"step\" value=\"1\" />\n";

if( $vulnerabilityFile == 'impossible.php' ) {
    $page[ 'body' ] .= "
            当前密码：<br />
            <input type=\"password\" AUTOCOMPLETE=\"off\" name=\"password_current\"><br />";
}

$page[ 'body' ] .= "            新密码：<br />
            <input type=\"password\" AUTOCOMPLETE=\"off\" name=\"password_new\"><br />
            确认新密码：<br />
            <input type=\"password\" AUTOCOMPLETE=\"off\" name=\"password_conf\"><br />

            " . recaptcha_get_html( $_DVWA[ 'recaptcha_public_key' ] );
if( $vulnerabilityFile == 'high.php' )
    $page[ 'body' ] .= "\n\n            <!-- **开发提示**   响应：'hidd3n_valu3'   &&   用户代理：'reCAPTCHA'   **/开发提示** -->\n";

if( $vulnerabilityFile == 'high.php' || $vulnerabilityFile == 'impossible.php' )
    $page[ 'body' ] .= "\n            " . tokenField();

$page[ 'body' ] .= "
            <br />

            <input type=\"submit\" value=\"更改\" name=\"Change\">
        </form>
        {$html}
    </div>

    <h2>更多信息</h2>
    <ul>
        <li>" . dvwaExternalLinkUrlGet( 'https://en.wikipedia.org/wiki/CAPTCHA' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://www.google.com/recaptcha/' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://owasp.org/www-project-automated-threats-to-web-applications/assets/oats/EN/OAT-009_CAPTCHA_Defeat' ) . "</li>
    </ul>
</div>\n";

dvwaHtmlEcho( $page );

?>

