<?php
	$data_links = array(
				'links'	=> isset($links) ? $links : '',
				'content'	=> isset($content_replace) ? $content_replace : ''
			);
?>
<?php $data['output'] = isset($content_replace) ? $content_replace : NULL; ?>
<?php
		$this->load->view('includes/header', isset($data) ? $data : NULL );
		$this->load->view('includes/side_nav');
?>
	<div id="main-content">
  	<div class="container-fluid clearfix">
<?php
	$this->load->view('includes/breadcrumb');

	//entertainment_sansar/jokes/category
	//'includes/dashboard_widget_1'
	//echo gettype($content_replace);exit;

	if(isset($content_replace)):
		$this->load->view('crud', $data_links);
	else:
		$this->load->view('includes/dashboard_widget_1');
		$this->load->view('includes/dashboard_widget_2');
	endif;

	$this->load->view('includes/footer');
?>
	</div>
</div>