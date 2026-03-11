<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php if(!empty($title)){ echo $title; }?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl?>/assets/styles/style.css">
    </head>
    <body>
        <main class="main-container">
            <header class="conent-box">
                <div class="content">
                    <?php 
                        echo $this->setContentPart('header');
                    ?>
                </div>
            </header>
            <hr/>
            <div class="conent-box">
                <div class="content">
                    <?= $this->getBlock('content'); ?>
                </div>
            </div>
            <hr/>
            <footer class="conent-box">
                <div class="content">  
                    <?php
                        echo $this->setContentPart('footer');
                    ?>
                </div>
            </footer>
        </main>
    </body>
</html>
