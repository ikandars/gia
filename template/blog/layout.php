<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=$title?> - <?=CONF['blogSubTitle']?></title>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.0.0/styles/default.min.css">
<link rel="stylesheet" href="/assets/blog/blog.css">
</head>
<body>
<div class="blog-masthead">
    <div class="container">
        <nav class="blog-nav">
            <a class="blog-nav-item" href="/">Blog</a>
            <a target="_blank" class="blog-nav-item" href="https://id.linkedin.com/in/ikandar">Linkedin</a>
            <a target="_blank" class="blog-nav-item" href="https://twitter.com/ikandars">Twitter</a>
            <a target="_blank" class="blog-nav-item" href="https://github.com/ikandars">Github</a>
        </nav>
    </div>
</div>
<div class="container">
    <div class="blog-header">
        <h2 class="blog-title h1"><?=CONF['blogTitle']?></h2>
        <p class="lead blog-description"><?=CONF['blogSubTitle']?></p>
    </div>
    <div class="row">
        <div class="col-sm-8 blog-main">
            <?=$template($section, $vars)['body']?>
        </div>
        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
            <div class="sidebar-module sidebar-module-inset">
                <h4>About Iskandar Soesman</h4>
                <p>I Speak: PHP, Node and Go. I build: <a href="https://twitter.com/panadaframework">Panadaframework</a> and <a href="https://soebiz.com">Soebiz</a>, a free e commerce site provider. I also full time Software engineer <a href="http://www.detik.com">@detikcom</a></p>
            </div>
            <?php if($section == 'post'):?>
            <?=$template('widget', $vars)['body']?>
            <?php endif?>
            <div class="sidebar-module sidebar-module-inset">
                <h4>Download this blog app</h4>
                <p>This blog app is open source project written in PHP and use markdown file base as the data store. Get it here <a href="https://github.com/ikandars/gia">https://github.com/ikandars/gia</a></p>
            </div>
        </div><!-- /.blog-sidebar -->
    </div><!-- /.row -->
</div><!-- /.container -->
<footer class="blog-footer">
  <p>Original taken from blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
  <p>
    <a href="#">Back to top</a>
  </p>
</footer>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.0.0/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
</body>
</html>