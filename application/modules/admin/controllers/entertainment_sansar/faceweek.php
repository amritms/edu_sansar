<?php
namespace admin\controllers\entertainment_sansar\faceweek;

if( !defined('BASEPATH') ) exit('No direct script access allowed');
use \MX_Controller as Controller,
	\grocery_CRUD as groceryCrud,
	\Exception as ErrorException;

/**
 *
 * @author Suraj Kumar Adhikari <surajadhikari1929@gmail.com>
 *
 */
class Faceweek extends Controller
{
	/**
	 * Data Holder
	 * (Singlton Design Pattern)
	 * @var array
	 */
	protected static $data = array();

	/**
	 * Grocery CRUD object
	 *
	 * @var object
	 */
	protected $_crud;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct ();

		if (!$this->ion_auth->logged_in()) {
			$this->session->set_flashdata('message','You are not logged in. <br /> Please login before trying to access admin panel');
			redirect('auth/login', 'refresh');
		}

		/*
		 * Links
		*/
		static::$data['links'] = array(
				'Face of the Week' => 'admin/entertainment_sansar/faceweek',
				'Records' => 'admin/entertainment_sansar/faceweek/records'
		);

		/*
		 * Loading grocery crud library
		*/
		$this->load->library('grocery_crud');

		try{
			/*
			 * Crud object
			*/
			$this->_crud = new groceryCrud();
			$this->load->config('grocery_crud');
			$this->config->set_item('grocery_crud_file_upload_allow_file_types', 'gif|jpeg|jpg|png|PNG|JPG|GIF');
		}catch(ErrorException $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	/**
	 * index (default) method
	 *
	 * lists the recepies
	 */
	public function index()
	{
		/*
		 * add these only in add form
		 */
		if( $this->_crud->getState() == 'add' )
		{
			$this->_crud->set_css('assets/grocery_crud/css/ui/simple/'. groceryCrud::JQUERY_UI_CSS);
		    $this->_crud->set_js('assets/grocery_crud/js/'. groceryCrud::JQUERY);
		    $this->_crud->set_js('assets/grocery_crud/js/jquery_plugins/ui/'. groceryCrud::JQUERY_UI_JS);
		    $this->_crud->set_js('assets/grocery_crud/js/jquery_plugins/config/jquery.datepicker.config.js');
		}

		$this->_crud->callback_add_field('time', function($value){
			//The below line is only to avoid the error in JavaScript
			$return  = '<script type="text/javascript">var js_date_format = "dd/mm/yyyy"; </script>';
			$value = !empty($value) ? $value : date("m/d/Y");
			return $return.'<input type="text" name="date" value="'.$value.'" class="datepicker-input" />';
		});

		$this->_crud->set_table('ent_fw_faceweek');
		$this->_crud->set_subject('Face of the week');

		/*
		 *   Setting text to display for more readablity
		 */
		$this->_crud->display_as('fav_movie', 'Favourite Movie')
					->display_as('fav_actor', 'Favourite Actor')
					->display_as('fav_actress', 'Favourite Actress')
					->display_as('aim', 'Aim in Life')
					->display_as('status', 'Make Face of the week');


		/*
		 * Setting required field for CRUD operation, can also be replaced by set_rules method;
		 * But most of the fields are requred, so this method is easier
		 */
		//$this->_crud->required_fields('name', 'gender', 'profession', 'description', 'height', 'age', 'likes', 'dislikes', 'fav_movie', 'fav_actor', 'fav_actress', 'aim', 'address', 'image', 'status');


		/*
		 * file upload path setting
		 */
		$this->_crud->set_field_upload('image','assets/uploads/faceweek');

		/*
		 * $that = Reference $this Object
		 */
		$that = $this;

		$this->_crud->callback_after_insert(function($post_array, $primary_key) use($that){
			$date = date('Y-m-d', strtotime(str_replace('-', '/', $post_array['date'])));
			return $that->db->insert('ent_fw_records', array(
									'date'					=> $date,
									'ent_fw_faceweek_id'	=> $primary_key
				));
		});

		/*
		 * grocery CRUD callback function after upload
		 */
		$this->_crud->callback_after_upload(function($uploader_response, $field_info, $files_to_upload) use($that){
			$that->load->library('image_moo');

			/*
			 * Is only one file uploaded so it ok to use it with $uploader_response[0].
			 */
			$file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name;
			$that->image_moo->load($file_uploaded)->resize(200, 200)->save($file_uploaded, true);
			return true;
		});

		static::$data['name'] = 'crud';
		static::$data['content_replace'] = $this->_crud->render();

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
	 * Method to load comments
	 */
	public function records()
	{
		$this->_crud->set_table('ent_fw_records');
		$this->_crud->set_subject('Records');
		$this->_crud->set_relation('ent_fw_faceweek_id','ent_fw_faceweek','name');
		$this->_crud->display_as('ent_fw_faceweek_id', 'Face of the Week');

		static::$data['name'] = 'crud';
		static::$data['content_replace'] = $this->_crud->render();

		$this->_crud_output('main', static::$data);
	}
}

$_ns = __NAMESPACE__;