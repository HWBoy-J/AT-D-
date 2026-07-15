<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ] .= '源代码';

if (array_key_exists ("id", $_GET) && array_key_exists ("security", $_GET)) {
	$id       = $_GET[ 'id' ];
	$security = $_GET[ 'security' ];

	switch ($id) {
		case "fi" :
			$vuln = '文件包含';
			break;
		case "brute" :
			$vuln = '暴力破解';
			break;
		case "csrf" :
			$vuln = 'CSRF';
			break;
		case "exec" :
			$vuln = '命令注入';
			break;
		case "sqli" :
			$vuln = 'SQL 注入';
			break;
		case "sqli_blind" :
			$vuln = 'SQL 注入（盲注）';
			break;
		case "upload" :
			$vuln = '文件上传';
			break;
		case "xss_r" :
			$vuln = '反射型 XSS';
			break;
		case "xss_s" :
			$vuln = '存储型 XSS';
			break;
		case "weak_id" :
			$vuln = '弱会话 ID';
			break;
		case "javascript" :
			$vuln = 'JavaScript';
			break;
		case "authbypass" :
			$vuln = '授权绕过';
			break;
		case "open_redirect" :
			$vuln = '开放 HTTP 重定向';
			break;
		default:
			$vuln = "未知漏洞";
	}

	$source = @file_get_contents( DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/{$id}/source/{$security}.php" );
	$source = str_replace( array( '$html .=' ), array( 'echo' ), $source );

	$js_html = "";
	if (file_exists (DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/{$id}/source/{$security}.js")) {
		$js_source = @file_get_contents( DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/{$id}/source/{$security}.js" );
		$js_html = "
		<h2>vulnerabilities/{$id}/source/{$security}.js</h2>
		<div id=\"code\">
			<table width='100%' bgcolor='white' style=\"border:2px #C0C0C0 solid\">
				<tr>
					<td><div id=\"code\">" . highlight_string( $js_source, true ) . "</div></td>
				</tr>
			</table>
		</div>
		";
	}

	$page[ 'body' ] .= "
	<div class=\"body_padded\">
		<h1>{$vuln} 源代码</h1>

		<h2>vulnerabilities/{$id}/source/{$security}.php</h2>
		<div id=\"code\">
			<table width='100%' bgcolor='white' style=\"border:2px #C0C0C0 solid\">
				<tr>
					<td><div id=\"code\">" . highlight_string( $source, true ) . "</div></td>
				</tr>
			</table>
		</div>
		{$js_html}
		<br /> <br />

		<form>
			<input type=\"button\" value=\"比较所有级别\" onclick=\"window.location.href='view_source_all.php?id=$id'\">
		</form>
	</div>\n";
} else {
	$page['body'] = "<p>未找到</p>";
}

// 添加横向导航栏的 CSS 样式
$page['body'] .= "
<style>
    .horizontal-menu {
        display: flex;
        justify-content: space-around;
        background-color: #f0f0f0;
        padding: 10px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
    }
    .horizontal-menu a {
        text-decoration: none;
        color: #333;
        padding: 10px;
    }
    .horizontal-menu a:hover {
        background-color: #ddd;
    }
</style>
<div class=\"horizontal-menu\">
    <a href=\"view_source.php?id=fi&security=low\">文件包含 - 低级</a>
    <a href=\"view_source.php?id=fi&security=medium\">文件包含 - 中级</a>
    <a href=\"view_source.php?id=fi&security=high\">文件包含 - 高级</a>
    <!-- 在这里添加更多链接 -->
</div>
";

dvwaSourceHtmlEcho( $page );

?>
