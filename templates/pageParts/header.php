
<nav class="nav-bar">
    <a href="<?php echo $baseUrl?>">public</a>
    
    <?php if ( isset($sess['logged'])) { ?>
        <a href="<?php echo $baseUrl?>/protected">protected</a>
        <a href="<?php echo $baseUrl?>/logout">logout</a>
    <?php } else { ?>
        <a href="<?php echo $baseUrl?>/login">login</a>
    <?php } ?>
</nav>