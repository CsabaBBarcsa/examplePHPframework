<?php
$this->setLayout('layout');

$this->startBlock('content');
?>
<h1>Csak Tagoknak</h1>
<h2>Üdv <?php if(!empty($sess['logged']['uName'])){ echo $sess['logged']['uName'];}?></h2>

<?php $this->endBlock();