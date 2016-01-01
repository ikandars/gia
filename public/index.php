<?php

date_default_timezone_set('Asia/Jakarta');

$contentsFolder = '../contents';
$templateFolder = '../template/blog/';

$resource = new FilesystemIterator($contentsFolder);
$resource = new RegexIterator($resource,'/^.+\.md/i');

$files = [];
foreach ($resource as $fileInfo) {
    
    $file = $fileInfo->getFilename();
    $key = explode('-', $file)[0];
    $files[$key] = $file;
}

krsort($files);

$uri = explode('/', trim(strtok($_SERVER['REQUEST_URI'], '?'), '/'));

require '../vendor/erusev/parsedown/Parsedown.php';

$parsedown = new Parsedown();
$doc = new DOMDocument();

function getTitle($string) {
    $pattern = "/<h1>(.*?)<\/h1>/";
    preg_match_all($pattern, $string, $matches);
    
    return ($matches[1][0]);
}

function getList($files)
{
    global $contentsFolder, $parsedown, $doc;
    
    foreach($files as $file) {
        
        $filePath = $contentsFolder.'/'.$file;
        
        $id = explode('-', $file)[0];
        $md = file_get_contents($filePath);
        $md = $parsedown->text($md);
        $date = date ('F d Y H:i:s', filemtime($filePath));
        
        $doc->loadHTML($md);
        
        $title = $doc->getElementsByTagName('h1');
        $title = iterator_to_array($title)[0];
        $title = $title->textContent;
        
        $lead = $doc->getElementsByTagName('p');
        $lead = iterator_to_array($lead)[0];
        $lead = $lead->textContent;
    
        yield [
            'id' => $id,
            'title' => $title,
            'url' => '/'.pathinfo($file, PATHINFO_FILENAME),
            'date' => $date,
            'lead' => $lead
        ];
    }
}

// route to admin page
if($uri[0] == 'admin') {
    
}

// route to detail page
elseif($uri[0] && $uri[0] != 'page') {
    
    $filePath = $contentsFolder.'/'.$uri[0].'.md';
    
    if(! $md = @file_get_contents($filePath)) {
        header('HTTP/1.0 404 Not Found');
        require $templateFolder.'404.php';
        exit;
    }
    
    $md     = $parsedown->text($md);
    $title  = getTitle($md);
    $date   = date ('F d Y H:i:s', filemtime($filePath));
    
    $files  = array_slice($files, 0, 10);
    $posts = getList($files);
    
    $content = 'post';
    
    require $templateFolder.'layout.php';
}

// route to content list page
else {
    $limit  = 20;
    $page   = ($uri[0] == 'page' && isset($uri[1]) && $uri[1] > 0)? $uri[1]:1;
    $olderPage = $page + 1;
    $newerPage = $page - 1;
    $offset = ($limit * $page) - $limit;
    $files  = array_slice($files, $offset, $limit);
    $posts = getList($files);
    $title = 'Less talk, more code';
    $content = 'home';
    
    require $templateFolder.'layout.php';
}