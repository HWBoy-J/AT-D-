<?php

define('DVWA_WEB_PAGE_TO_ROOT', '');
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup(array('authenticated'));

$page = dvwaPageNewGrab();
$page['title'] = '神盾靶场安全设置';
$page['page_id'] = 'security';

$securityHtml = '';
if (isset($_POST['seclev_submit'])) {
    // Anti-CSRF
    checkToken($_REQUEST['user_token'], $_SESSION['session_token'], 'security.php');

    $securityLevel = '';
    switch ($_POST['security']) {
        case 'low':
            $securityLevel = 'low';
            break;
        case 'medium':
            $securityLevel = 'medium';
            break;
        case 'high':
            $securityLevel = 'high';
            break;
        default:
            $securityLevel = 'impossible';
            break;
    }

    dvwaSecurityLevelSet($securityLevel);
    dvwaMessagePush("安全级别已设置为 {$securityLevel}");
    dvwaPageReload();
}

$securityOptionsHtml = '';
$securityLevelHtml = '';
foreach (array('low', 'medium', 'high', 'impossible') as $securityLevel) {
    $selected = '';
    if ($securityLevel == dvwaSecurityLevelGet()) {
        $selected = ' selected="selected"';
        $securityLevelHtml = "<p>当前安全级别为: <em>$securityLevel</em>.<p>";
    }
    $securityOptionsHtml .= "<option value=\"{$securityLevel}\"{$selected}>" . ucfirst($securityLevel) . "</option>";
}

// Anti-CSRF
generateSessionToken();

$page['body'] .= "
<div class=\"body_padded\">
    <h1>神盾靶场安全设置 <img src=\"" . DVWA_WEB_PAGE_TO_ROOT . "dvwa/images/lock.png\" /></h1>
    <br />

    <h2>安全级别</h2>

    {$securityHtml}

    <form action=\"#\" method=\"POST\">
        {$securityLevelHtml}
        <p>您可以将安全级别设置为低、中、高或不可能。安全级别将改变神盾靶场的漏洞级别：</p>
        <ol>
            <li>低 - 此安全级别完全脆弱，并且<em>没有任何安全措施</em>。它的用途是作为糟糕编码实践中网络应用漏洞的示例，并作为教学或学习基本利用技术的平台。</li>
            <li>中 - 此设置主要是为了向用户提供<em>错误的安全实践</em>的示例，开发者尝试但未能保护应用程序。这也是用户精炼其利用技术的挑战。</li>
            <li>高 - 此选项是中等难度的扩展，混合了<em>更难或替代的糟糕实践</em>来尝试保护代码。该漏洞可能不允许相同程度的利用，类似于各种 Capture The Flags (CTFs) 竞赛。</li>
            <li>不可能 - 此级别应<em>防止所有漏洞</em>。它用于比较易受攻击的源代码与安全源代码。<br /></li>
        </ol>
        <select name=\"security\">
            {$securityOptionsHtml}
        </select>
        <input type=\"submit\" value=\"提交\" name=\"seclev_submit\">
        " . tokenField() . "
    </form>
</div>";

dvwaHtmlEcho($page);

?>

