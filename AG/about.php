<?php

define('DVWA_WEB_PAGE_TO_ROOT', '');
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup(array());

$page = dvwaPageNewGrab();
$page['title'] = '关于';
$page['page_id'] = 'about';

$page['body'] .= "
<div class=\"body_padded\">
    <h2>关于</h2>
    <p>神盾靶场 (AG) 是一个 PHP/MySQL 网络应用程序，其漏洞非常明显。其主要目标是帮助安全专业人员在合法环境中测试他们的技能和工具，帮助网页开发者更好地理解保护网页应用程序的过程，并帮助教师和学生在课堂环境中学习网页应用程序安全性。</p>

    <h2>致谢</h2>
    <ul>
        <li>Brooks Garrett: " . dvwaExternalLinkUrlGet('http://brooksgarrett.com/', 'www.brooksgarrett.com') . "</li>
        <li>Craig</li>
        <li>g0tmi1k: " . dvwaExternalLinkUrlGet('https://blog.g0tmi1k.com/', 'g0tmi1k.com') . "</li>
        <li>Jamesr: " . dvwaExternalLinkUrlGet('https://www.creativenucleus.com/', 'www.creativenucleus.com') . "</li>
        <li>Jason Jones</li>
        <li>RandomStorm</li>
        <li>Ryan Dewhurst: " . dvwaExternalLinkUrlGet('https://wpscan.com/', 'wpscan.com') . "</li>
        <li>Shinkurt: " . dvwaExternalLinkUrlGet('http://www.paulosyibelo.com/', 'www.paulosyibelo.com') . "</li>
        <li>Tedi Heriyanto: " . dvwaExternalLinkUrlGet('http://tedi.heriyanto.net/', 'tedi.heriyanto.net') . "</li>
        <li>Tom Mackenzie</li>
        <li>Robin Wood: " . dvwaExternalLinkUrlGet('https://digi.ninja/', 'digi.ninja') . "</li>
        <li>Zhengyang Song: " . dvwaExternalLinkUrlGet('https://github.com/songzy12/', 'songzy12') . "</li>
    </ul>

    <h2>许可证</h2>
    <p>神盾靶场 (AG) 是自由软件：您可以根据自由软件基金会发布的 GNU 通用公共许可证的条款重新分发和/或修改它，许可证版本为 3 或（根据您的选择）任何更高版本。</p>

    <h2>开发</h2>
    <p>欢迎大家贡献力量，帮助神盾靶场取得成功。所有贡献者的姓名和链接（如果他们愿意）都可以放在致谢部分。要贡献，请选择项目主页上的一个问题进行处理或向问题列表提交补丁。</p>
</div>\n";

dvwaHtmlEcho($page);

exit;

?>

