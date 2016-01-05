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

$getMDFiles = function() {
    
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

$getContent = function($filePath, $html = false) use ($parsedown, $getTagContent) {
    
    $id         = explode('-', $filePath)[0];
    $filePath   = str_replace('.md', '', $filePath).'.md';
    $filePath   = CONF['contentPath'].'/'.$filePath;
    
    if(!$html) {
        $html   = file_get_contents($filePath);
    }
    
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

$template = function($file, &$vars, $header = 'HTTP/1.1 200 OK') use (&$template) {
    
    extract($vars, EXTR_SKIP);
    
    ob_start();
    
    require CONF['templatePath'].$file.'.php';
    
    return ['body' => ob_get_clean(), 'header' => $header];
};

$route = function($map, $uri) use ($template) {
    
    $path   = strtok($uri, '?');
    $uri    = array_replace(['page', 1], explode('/', trim($path, '/')));
    
    foreach($map as $pattern => $callBack) {
        if(preg_match($pattern, $path)) {
            return call_user_func_array($callBack, $uri);
        }
    }
    
    $vars = [];
    return $template('404', $vars, 'HTTP/1.1 404 Not Found');;
};

$map = [
    '/(^\/$)|(^\/page)/' => function($path, $page) use ($getMDFiles, $postList, $template) {
    
        $limit  = 10;
        $offset = ($limit * $page) - $limit;
        $files  = array_slice($getMDFiles(), $offset, $limit);
        
        $vars = [
            'section' => 'home',
            'title' => 'Less talk, more code',
            'posts' => $postList($files),
            'olderPage' => $page + 1,
            'newerPage' => $page - 1,
        ];
        
        return $template('layout', $vars);
    },
    
    '/^\/[0-9]+\-[\/A-Za-z0-9\-]/' => function($slug) use ($getMDFiles, $getContent, $postList, $template) {
    
        $filePath = CONF['contentPath'].'/'.$slug.'.md';
        
        if(! $md = @file_get_contents($filePath)) {
            $vars = [];
            return $template('404', $vars, 'HTTP/1.1 404 Not Found');
        }
        
        $files  = array_slice($getMDFiles(), 0, 10);
        $post   = $getContent($slug, $md);
        
        $vars = [
            'section' => 'post',
            'title' => $post['title'],
            'posts' => $postList($files),
            'post' => $post,
            'template' => $template
        ];
        
        return $template('layout', $vars);
    }
];

$output = $route($map, $_SERVER['REQUEST_URI']);

header($output['header']);
echo $output['body'];