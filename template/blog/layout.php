<!DOCTYPE html>
<html>
<head>
<title><?=$title?> - The blog of Iskandar Soesman</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
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
        <h2 class="blog-title h1">Less talk, more code</h2>
        <p class="lead blog-description">The blog of Iskandar Soesman</p>
    </div>
    <div class="row">
        <div class="col-sm-8 blog-main">
            <?php include $templateFolder.$content.'.php'?>
        </div>
        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
            <div class="sidebar-module sidebar-module-inset">
                <h4>About</h4>
                <p>Speak: PHP, Node and Go. Build: <a href="https://twitter.com/panadaframework">@panadaframework</a> and <a href="https://twitter.com/soebizhq">@soebizhq</a>, a free e commerce site provider (<a href="https://soebiz.com">https://soebiz.com</a> ). Full time Software engineer <a href="https://twitter.com/detikcom">@detikcom</a></p>
            </div>
            <?php if($content == 'post'):?>
            <?php include $templateFolder.'widget.php'?>
            <?php endif?>
        </div><!-- /.blog-sidebar -->
    </div><!-- /.row -->
</div><!-- /.container -->
<footer class="blog-footer">
  <p>Original taken from blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
  <p>
    <a href="#">Back to top</a>
  </p>
</footer>
</body>
</html>