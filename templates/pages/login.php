<?php
$this->setLayout('layout');

$this->startBlock('content');
?>
    <h3><?php if(!empty($title)){ echo $title; }?></h3>
    <div class="form-container">
        <form method="post" action="<?php echo $baseUrl?>/login/trylogin" >
            <div class="input-box">
                <label for="em">E-mail</label>
                <input id="em" type="text" name="usemail">
            </div>
            <div class="input-box">
                <label for="pw">Password</label>
                <input id="pw" type="password" name="paw">
            </div>
            <div class="input-box centered">
                <input type="submit" name="logn" value="Belép">                
            </div>
        </form>
    </div>

    <?php if (isset($flash['logSubError'])){ echo $flash['logSubError']; } ?>
    <?php if (isset($flash['logForError'])){ echo $flash['logForError']; } ?>

<?php $this->endBlock();