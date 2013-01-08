<?php 	if(($this->uri->segment(1) == 'admin' || $this->uri->segment(1) == NULL) && ($this->uri->segment(2) == 'index' ||
		 $this->uri->segment(2) == NULL)): ?>
			<script src="<?php echo site_url("assets/admin/js/jquery.js"); ?>"></script>
			<script src="<?php echo site_url("assets/admin/js/jquery-ui-1.8.16.custom.min.js"); ?>"></script>
<?php endif;?>
<script src="<?php echo site_url("assets/admin/js/bootstrap.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/jquery.sparkline.min.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/jquery.nicescroll.min.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/accordion.jquery.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/raty.jquery.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/jquery.noty.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/jquery.cleditor.min.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/data-table.jquery.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/TableTools.min.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/ColVis.min.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/plupload.full.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/elfinder/elfinder.min.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/chosen.jquery.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/uniform.jquery.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/jquery.tagsinput.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/jquery.colorbox-min.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/check-all.jquery.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/inputmask.jquery.js"); ?>"></script>
<script src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
<script src="<?php echo site_url("assets/admin/js/plupupload/jquery.plupload.queue/jquery.plupload.queue.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/excanvas.min.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/custom-script.js"); ?>"></script>
<!-- html5.js for IE less than 9 -->
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="<?php echo site_url("assets/admin/js/respond.min.js"); ?>"></script>
<script src="<?php echo site_url("assets/admin/js/ios-orientationchange-fix.js"); ?>"></script>
<div style="footer">Copyright &copy; <?= date('Y');?></div>
<script>
		$(function(){
			$a = $('.side-nav').find('>li'); $($a).find('.active').next('ul.acitem').css('display','block');
		});
	</script>
	</body>
</html>