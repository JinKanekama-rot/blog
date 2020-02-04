<label>更新</label>
<?= $this->Form->create('Import', array('type' => 'file')) ?>
<?= $this->Form->file('Import.submittedfile',[ 'accept'=>'.csv']); ?>
<?= $this->Form->button('Submit'); ?>
<?= $this->Form->end() ?>