<?php foreach($posts as $post):?>
<div class="blog-post">
    <h2><a href="<?=$post['url']?>"><?=$post['title']?></a></h2>
    <p class="blog-post-meta">last modified: <?=$post['date']?></p>
    <p><?=$post['lead']?></p>
    <hr>
</div>
<?php endforeach?>
<nav>
    <ul class="pager">
        <?php if($newerPage):?>
            <li><a href="/page/<?=$newerPage?>">Newer content</a></li>
        <?php endif?>
            
        <?php if($post['id'] > 1):?>
            <li><a href="/page/<?=$olderPage?>">Older content</a></li>
        <?php endif?>
    </ul>
</nav>