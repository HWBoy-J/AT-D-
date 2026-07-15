<?php

// 检查正确的 PHP 函数是否已启用
$WarningHtml = '';
if( !ini_get( 'allow_url_include' ) ) {
    $WarningHtml .= "<div class=\"warning\">PHP 函数 <em>allow_url_include</em> 未启用。</div>";
}
if( !ini_get( 'allow_url_fopen' ) ) {
    $WarningHtml .= "<div class=\"warning\">PHP 函数 <em>allow_url_fopen</em> 未启用。</div>";
}

$page[ 'body' ] .= "
<div class=\"body_padded\">
    <h1>漏洞：文件包含</h1>

    {$WarningHtml}

    <div class=\"vulnerable_code_area\">
        [<em><a href=\"?page=file1.php\">file1.php</a></em>] - [<em><a href=\"?page=file2.php\">file2.php</a></em>] - [<em><a href=\"?page=file3.php\">file3.php</a></em>]
    </div>

    <h2>更多信息</h2>
    <ul>
        <li>" . dvwaExternalLinkUrlGet('https://en.wikipedia.org/wiki/Remote_File_Inclusion', '维基百科 - 文件包含漏洞') . "</li>
        <li>" . dvwaExternalLinkUrlGet('https://owasp.org/www-project-web-security-testing-guide/stable/4-Web_Application_Security_Testing/07-Input_Validation_Testing/11.1-Testing_for_Local_File_Inclusion', 'WSTG - 本地文件包含') . "</li>
        <li>" . dvwaExternalLinkUrlGet('https://owasp.org/www-project-web-security-testing-guide/stable/4-Web_Application_Security_Testing/07-Input_Validation_Testing/11.2-Testing_for_Remote_File_Inclusion', 'WSTG - 远程文件包含') . "</li>
    </ul>
</div>\n";

?>

