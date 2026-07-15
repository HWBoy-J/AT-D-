<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/Parsedown.php';

dvwaPageStartup( array( ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = '使用说明';
$page[ 'page_id' ] = 'instructions';

$docs = array(
    'readme'         => array( 'type' => 'markdown', 'legend' => '阅读我', 'file' => 'README.md' ),
    'PDF'            => array( 'type' => 'html' ,'legend' => 'PDF指南', 'file' => 'docs/pdf.html' ),
    'changelog'      => array( 'type' => 'markdown', 'legend' => '变更日志', 'file' => 'CHANGELOG.md' ),
    'copying'        => array( 'type' => 'markdown', 'legend' => '复制', 'file' => 'COPYING.txt' ),
);

$selectedDocId = isset( $_GET[ 'doc' ] ) ? $_GET[ 'doc' ] : '';
if( !array_key_exists( $selectedDocId, $docs ) ) {
    $selectedDocId = 'readme';
}
$readFile = $docs[ $selectedDocId ][ 'file' ];

$instructions = file_get_contents( DVWA_WEB_PAGE_TO_ROOT.$readFile );

if ($docs[ $selectedDocId ]['type'] == "markdown") {
    $parsedown = new Parsedown();
    $instructions = $parsedown->text($instructions);
}

/*
function urlReplace( $matches ) {
    return dvwaExternalLinkUrlGet( $matches[1] );
}

// 替换链接并模糊引用...
$instructions = preg_replace_callback(
    '/((http|https|ftp):\/\/([[:alnum:]|.|\/|?|=]+))/',
    'urlReplace',
    $instructions
);

$instructions = nl2br( $instructions );
*/
$docMenuHtml = '';
foreach( array_keys( $docs ) as $docId ) {
    $selectedClass = ( $docId == $selectedDocId ) ? ' selected' : '';
    $docMenuHtml  .= "<span class=\"submenu_item{$selectedClass}\"><a href=\"?doc={$docId}\">{$docs[$docId]['legend']}</a></span>";
}
$docMenuHtml = "<div class=\"submenu\">{$docMenuHtml}</div>";

$page[ 'body' ] .= "
<div class=\"body_padded\">
    <h1>使用说明</h1>

    {$docMenuHtml}

    <span class=\"fixed\">
        {$instructions}
    </span>
</div>";

dvwaHtmlEcho( $page );

?>
