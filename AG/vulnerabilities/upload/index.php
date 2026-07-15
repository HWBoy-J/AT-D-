<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = '漏洞：文件上传';
$page[ 'page_id' ] = 'upload';
$page[ 'help_button' ]   = 'upload';
$page[ 'source_button' ] = 'upload';

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

require_once DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/upload/source/{$vulnerabilityFile}";

// 检查文件夹是否可写
$WarningHtml = '';
if( !is_writable( $PHPUploadPath ) ) {
    $WarningHtml .= "<div class=\"warning\">文件夹权限不正确: {$PHPUploadPath}<br /><em>文件夹不可写。</em></div>";
}
// 是否安装了 PHP-GD？
if( ( !extension_loaded( 'gd' ) || !function_exists( 'gd_info' ) ) ) {
    $WarningHtml .= "<div class=\"warning\">PHP 模块 <em>GD 未安装</em>。</div>";
}

$page[ 'body' ] .= "
<div class=\"body_padded\">
    <h1>漏洞：文件上传</h1>

    {$WarningHtml}

    <div class=\"vulnerable_code_area\">
        <form enctype=\"multipart/form-data\" action=\"#\" method=\"POST\">
            <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"100000\" />
            选择要上传的图片：<br /><br />
            <input name=\"uploaded\" type=\"file\" /><br />
            <br />
            <input type=\"submit\" name=\"Upload\" value=\"上传\" />\n";

if( $vulnerabilityFile == 'impossible.php' )
    $page[ 'body' ] .= "            " . tokenField();

$page[ 'body' ] .= "
        </form>
        {$html}
    </div>

    <h2>更多信息</h2>
    <ul>
        <li>" . dvwaExternalLinkUrlGet( 'https://owasp.org/www-community/vulnerabilities/Unrestricted_File_Upload' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://www.acunetix.com/websitesecurity/upload-forms-threat/' ) . "</li>
    </ul>
</div>";

dvwaHtmlEcho( $page );

?>

