<?php

namespace admin\controllers\entertainment_sansar\talk;

if( !defined('BASEPATH') ) exit('No direct script access allowed');
use \MX_Controller as Controller,
\grocery_CRUD as groceryCrud,
\Exception as ErrorException;
/**
 *
 * @author kapil tandukar <kapil.tandukar@gmail.com>
 *
 */

class talk extends Controller{

	/**
	 * Data Holder
	 *
	 * @var array
	 */
	protected static $data = array();


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
 				'Coffee Talk' 			=> 'admin/entertainment_sansar/talk',
 				'Question Answer'		=> 'admin/entertainment_sansar/talk/qa'
		);



		/**
		 * Loading grocery crud library
		*/
		$this->load->library('grocery_crud');

		try{

			/**
				* CRUD object
				*/
			$this->_crud = new groceryCrud();

			$this->load->config('grocery_crud');

			/**
			 * setting image
			 */
			$this->config->set_item('grocery_crud_file_upload_allow_file_types','gif|jpeg|jpg|png');


		}catch (ErrorException $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}

	}
		/**
		 * index default method
		 *
		 * list of poems
		 */
		public function index()
		{
			$this->_crud->set_table('ent_ct_talks');
			$this->_crud->set_subject('Coffee talk');


			/*
			 * Defining fields that show on Add & Edit forms if you want different then use add_fields & edit_fields
			*/
			$this->_crud->fields('topic', 'description', 'interviewer', 'name', 'profile','image','status');

			/**
			 * image upload
			 */
			$this->_crud->set_field_upload('image','assets/uploads/coffee_talk');

			$this->_crud->callback_after_upload(array($this,'example_callback_after_upload'));

			/*
			 * Setting required field for CRUD operation, can also be replaced by set_rules method;
			*  But most of the fields are requred, so this method is easier
			*/
			$this->_crud->required_fields('topic', 'description', 'interviewer', 'name', 'profile','image');
			static::$data['name'] = 'crud';
			static::$data['content_replace'] = $this->_crud->render();

			$this->_crud_output('main', static::$data);

		}

		/**
		 * image size define
		 * @param img_type $uploader_response
		 * @param img_type $field_info
		 * @param img_type $files_to_upload
		 *
		 */
		function example_callback_after_upload($uploader_response,$field_info, $files_to_upload)
		{
			$this->load->library('image_moo');

			//Is only one file uploaded so it ok to use it with $uploader_response[0].
			$file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name;

			$this->image_moo->load($file_uploaded)->resize(800,600)->save($file_uploaded,true);

			return true;
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
		 *
		 */
		public function qa()
		{
			/**
			 * Setting relation between category & poem table and accessing name field to use
			 */
			$this->_crud->set_relation('ent_ct_talk_id', 'ent_ct_talks', 'topic');


			/**
			 * Setting text to display for more readablity
			 */
			$this->_crud->display_as('ent_ct_talk_id','coffee talk');

			$this->_crud->set_table('ent_ct_qa');
			$this->_crud->set_subject('question answers');
			$this->_crud->required_fields('question', 'answer');

			static::$data['name'] = 'crud';
			static::$data['content_replace'] = $this->_crud->render();

			$this->_crud_output('main', static::$data);
		}

}

$_ns = __NAMESPACE__;