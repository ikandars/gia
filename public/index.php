<?php

date_default_timezone_set('Asia/Jakarta');

const CONF = [
    'contentPath' => '../contents',
    'templatePath' => '../template/blog/',
    'blogTitle' => 'Less talk, more code',
    'blogSubTitle' => 'The blog of Iskandar Soesman'
];

require '../vendor/erusev/parsedown/Parsedown.php';

$parsedown = new Parsedown();
$doc = new DOMDocument();

$mdFiles = function() {
    
    $resource = new FilesystemIterator(CONF['contentPath']);
    $resource = new RegexIterator($resource,'/^.+\.md/i');
    
    $files = [];
    
    foreach ($resource as $fileInfo) {
        $file = $fileInfo->getFilename();
        $key = explode('-', $file)[0];
        $files[$key] = $file;
    }
    
    krsort($files);
    
    return $files;
};

$uri = explode('/', trim(strtok($_SERVER['REQUEST_URI'], '?'), '/'));

$getTagContent = function($html, array $tags) use ($doc) {
    
    $doc->loadHTML($html);
    
    $return = [];
    
    foreach($tags as $tag) {
        $text = $doc->getElementsByTagName($tag);
        $text = iterator_to_array($text)[0];
        $text = $text->textContent;
        
        $return[$tag] = $text;
    }
    
    return $return;
};

$getContent = function($filePath) use ($parsedown, $getTagContent) {
    
    $id         = explode('-', $filePath)[0];
    $filePath   = str_replace('.md', '', $filePath).'.md';
    $filePath   = CONF['contentPath'].'/'.$filePath;
    
    $html       = file_get_contents($filePath);
    $html       = $parsedown->text($html);
    $date       = date ('F d Y H:i:s', filemtime($filePath));
    
    $text       = $getTagContent($html, ['h1', 'p']);
    
    return [
        'html' => $html,
        'lastModified' => $date,
        'id' => $id,
        'title' => $text['h1'],
        'url' => '/'.pathinfo($filePath, PATHINFO_FILENAME),
        'date' => $date,
        'lead' => $text['p']
    ];
};

$postList = function ($files) use ($getContent) {
    
    foreach($files as $file) {
        yield $getContent($file);
    }
};

$template = function($file) use (&$vars, &$template) {
    
    extract($vars, EXTR_SKIP);
    
    require CONF['templatePath'].$file.'.php';
};

// route to admin page
if($uri[0] == 'admin') {
    
}

// route to detail page
elseif($uri[0] && $uri[0] != 'page') {
    
    $filePath = CONF['contentPath'].'/'.$uri[0].'.md';
    
    if(! $md = @file_get_contents($filePath)) {
        header('HTTP/1.0 404 Not Found');
        require CONF['templatePath'].'404.php';
        exit;
    }
    
    $files  = array_slice($mdFiles(), 0, 10);
    $post   = $getContent($uri[0]);
    
    $vars = [
        'section' => 'post',
        'title' => $post['title'],
        'posts' => $postList($files),
        'post' => $post,
        'template' => $template
    ];
    
    $template('layout');
}

// route to content list page
else {
    $limit  = 10;
    $page   = ($uri[0] == 'page' && isset($uri[1]) && $uri[1] > 0)? $uri[1]:1;
    
    $offset = ($limit * $page) - $limit;
    $files  = array_slice($mdFiles(), $offset, $limit);
    
    $vars = [
        'section' => 'home',
        'title' => 'Less talk, more code',
        'posts' => $postList($files),
        'olderPage' => $page + 1,
        'newerPage' => $page - 1,
    ];
    
    $template('layout');
}