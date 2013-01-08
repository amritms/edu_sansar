<?php foreach($links as $key => $value): ?>
	<?php $data[] = anchor($value, $key); ?>
<?php endforeach; ?>
<span style="font-size:15px">Menus: </span>
<?php echo implode($data, ' || '); ?>
<div style='height:20px;'></div>
    <div>
		<?php echo $content->output; ?>
</div>
