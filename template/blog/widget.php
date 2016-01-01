<div class="sidebar-module">
    <h4>Latest posts</h4>
    <ol class="list-unstyled">
        <?php foreach($posts as $post):?>
        <li><a href="<?=$post['url']?>"><?=$post['title']?></a></li>
        <?php endforeach?>
    </ol>
</div>