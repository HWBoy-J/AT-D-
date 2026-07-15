<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ] = '源代码';

if (array_key_exists ("id", $_GET)) {
	$id = $_GET[ 'id' ];

	$lowsrc = @file_get_contents("./{$id}/source/low.php");
	$lowsrc = str_replace( array( '$html .=' ), array( 'echo' ), $lowsrc);
	$lowsrc = highlight_string( $lowsrc, true );

	$medsrc = @file_get_contents("./{$id}/source/medium.php");
	$medsrc = str_replace( array( '$html .=' ), array( 'echo' ), $medsrc);
	$medsrc = highlight_string( $medsrc, true );

	$highsrc = @file_get_contents("./{$id}/source/high.php");
	$highsrc = str_replace( array( '$html .=' ), array( 'echo' ), $highsrc);
	$highsrc = highlight_string( $highsrc, true );

	$impsrc = @file_get_contents("./{$id}/source/impossible.php");
	$impsrc = str_replace( array( '$html .=' ), array( 'echo' ), $impsrc);
	$impsrc = highlight_string( $impsrc, true );

	switch ($id) {
		case "javascript" :
			$vuln = 'JavaScript';
			break;
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
		case "authbypass" :
			$vuln = '授权绕过';
			break;
		case "open_redirect" :
			$vuln = '开放 HTTP 重定向';
			break;
		default:
			$vuln = "未知漏洞";
	}

	$page[ 'body' ] .= "
	<div class=\"body_padded\">
		<h1>{$vuln} 源代码</h1>
		<br />

		<h3>不可能的 {$vuln} 源代码</h3>
		<table width='100%' bgcolor='white' style=\"border:2px #C0C0C0 solid\">
			<tr>
				<td><div id=\"code\">{$impsrc}</div></td>
			</tr>
		</table>
		<br />

		<h3>高级 {$vuln} 源代码</h3>
		<table width='100%' bgcolor='white' style=\"border:2px #C0C0C0 solid\">
			<tr>
				<td><div id=\"code\">{$highsrc}</div></td>
			</tr>
		</table>
		<br />

		<h3>中级 {$vuln} 源代码</h3>
		<table width='100%' bgcolor='white' style=\"border:2px #C0C0C0 solid\">
			<tr>
				<td><div id=\"code\">{$medsrc}</div></td>
			</tr>
		</table>
		<br />

		<h3>低级 {$vuln} 源代码</h3>
		<table width='100%' bgcolor='white' style=\"border:2px #C0C0C0 solid\">
			<tr>
				<td><div id=\"code\">{$lowsrc}</div></td>
			</tr>
		</table>
		<br /> <br />

		<form>
			<input type=\"button\" value=\"<-- 返回\" onclick=\"history.go(-1);return true;\">
		</form>

	</div>\n";
} else {
	$page['body'] = "<p>未找到</p>";
}

dvwaSourceHtmlEcho( $page );

?>

