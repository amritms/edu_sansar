<?php

namespace admin\controllers\entertainment_sansar\events;

if( !defined('BASEPATH') ) exit('No direct script access allowed');

use \MX_Controller as Controller,
	\grocery_CRUD as groceryCrud,
	\image_CRUD as imageCrud,
	\Exception as ErrorException;

/**
 *
 * @author Amrit Man Shrestha
 *
 */
class events extends Controller{

	/**
	 * Data Holder
	 *
	 * @var array
	 */
	protected static $data = array();

	/**
	 *
	 * @var Crud Object
	 */
	protected $_crud;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		/*
		 * Links
		*/
		static::$data['links'] = array(
				'Categories' 			=> 'admin/entertainment_sansar/events/categories',
				'Events'	 			=> 'admin/entertainment_sansar/events',
				'Albums'	 			=> 'admin/entertainment_sansar/events/albums'
		);

		/*
		 * Loading grocery crud library
		 */
 		$this->load->library('grocery_crud');
 		$this->load->library('image_CRUD');

		try{

			/*
			* CRUD object
			*/
			$this->_crud = new groceryCrud();
			$this->load->config('grocery_crud');
			$this->config->set_item('grocery_crud_file_upload_allow_file_types', 'gif|jpeg|jpg|png|PNG|JPG|GIF');

		}catch (ErrorException $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}


	/**
	 * index default method
	 *
	 * list of events
	 */
	public function index($id = null)
	{
		$this->_crud->set_table('ent_ev_events');
		$this->_crud->set_subject('Event');
		
		$exists = $this->uri->segment(6) == '' ? true : false;
		
		if(isset($id) && intval($id) && $exists)
		{
			$this->_crud->set_model('event');
			$this->event->where('ent_ev_categories_id', $id);
		}
		
		/*
		 * Setting relation between category & poem table and accessing name field to use
		 */
		$this->_crud->set_relation('ent_ev_categories_id', 'ent_ev_categories', 'name');

		/*
		 * Setting text to display for more readablity
		 */
		$this->_crud->display_as(array('ent_ev_categories_id'=>'Event Category',
									   'title'=> 'Event\'s Title',
									  'event_date' => 'Date'));
					
		/*
		 * file upload path setting
		 */
		$this->_crud->set_field_upload('image','assets/uploads/events');
		
		$this->_crud->callback_add_field('event_date', function($value){
			//The below line is only to avoid the error in JavaScript
			$return  = '<script type="text/javascript">var js_date_format = "dd/mm/yyyy"; </script>';
			$value = !empty($value) ? $value : date("m/d/Y");
			return $return.'<input type="text" name="date" value="'.$value.'" class="datepicker-input" />';
		});

		/*
		 * grocery CRUD callback function after upload
		 */
		$this->_crud->callback_after_upload(array($this, 'callback_after_upload'));

		$this->_crud->callback_column('title', function($value, $row){
			return anchor("admin/entertainment_sansar/events/albums/{$row->id}", $value);
		});
		
		/*
		 * Defining fields that show on Add & Edit forms if you want different then use add_fields & edit_fields
		 */
		//$this->_crud->fields('title', 'description', 'event_location', 'event_date', 'status','ent_ev_categories_id');

		/*
		 * Setting required field for CRUD operation, can also be replaced by set_rules method;
		 * But most of the fields are requred, so this method is easier
		 */
	 //$this->_crud->required_fields('title', 'image', 'description', 'event_location', 'event_date', 'ent_ev_categories_id');
		static::$data['content_replace'] = $this->_crud->render();

		$this->_crud_output('main', static::$data);
	}

	/**
	 * index default method
	 *
	 * list of events
	 */
	public function albums($id = null)
	{
		
		$this->_crud->set_model('event');
		$this->_crud->set_table('ent_ev_albums');
		$exists = $this->uri->segment(6) == '' ? true : false;
		
		if(isset($id) && intval($id) && $exists)
		{
			$this->_crud->set_model('event');
			$this->event->where('ent_ev_events_id', $id);
		}
		
		$this->_crud->set_subject('Event Album');

		/*
		 * Setting relation between category & poem table and accessing name field to use
		 */
		$this->_crud->set_relation('ent_ev_events_id', 'ent_ev_events', 'title');

		
		/*
		 * Setting text to display for more readablity
		 */
		$this->_crud->display_as('ent_ev_events_id', 'Event Title');
		
		/*
		 * Setting required field for CRUD operation, can also be replaced by set_rules method;
		* But most of the fields are requred, so this method is easier
		*/
		$this->_crud->required_fields('title', 'description', 'photo_by', 'enhanced_by', 'ent_ev_events_id');
		
		$this->_crud->callback_column('name', function($value, $row){
			return anchor("admin/entertainment_sansar/events/album/{$row->id}", $value);
		});
		
		static::$data['content_replace'] = $this->_crud->render();
		$this->_crud_output('main', static::$data);
	}

	/**
	 *
	 * @param 	array 	$uploader_response
	 * @param 	array 	$field_info
	 * @param 	array 	$files_to_upload
	 * @return 	boolean
	 */
	public function callback_after_upload($uploader_response,$field_info, $files_to_upload)
	{
		$this->load->library('image_moo');

		//Is only one file uploaded so it ok to use it with $uploader_response[0].
		$file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name;

		$this->image_moo->load($file_uploaded)->resize(200, 200)->save($file_uploaded, true);

		return true;
	}


	public function album($id)
	{
		$image_crud = new imageCrud();

		$image_crud->set_table('ent_ev_photos');

		$image_crud->set_primary_key_field('id');
		$image_crud->set_url_field('url');
		$image_crud->set_title_field('title');
		$image_crud->set_relation_field('ent_ev_albums_id')
				   ->set_ordering_field('priority')
				   ->set_image_path('assets/uploads/events_images');

		static::$data['name'] = 'crud';
		static::$data['content_replace'] = $image_crud->render();
		$this->_crud_output('main', static::$data);
	}

	/**
	 * Custom view loader
	 *
	 * @access protected
	 * @param  array 		$output
	 */
	protected function _crud_output($view, array $output = array())
	{
		$this->load->view($view, $output);
	}

	/**
	 * Event categories
	 * 
	 * @return string
	 */
	public function categories()
	{
		$this->_crud->set_table('ent_ev_categories');
		$this->_crud->set_subject('Category');
		$this->_crud->required_fields('name', 'description');
		
		$this->_crud->callback_column('name', function($value, $row){
			return anchor("admin/entertainment_sansar/events/events/{$row->id}", $value);
		});
		
		static::$data['name'] = 'crud';
		static::$data['content_replace'] = $this->_crud->render();

		$this->_crud_output('main', static::$data);
	}



}
$_ns = __NAMESPACE__;