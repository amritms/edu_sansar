<?php
namespace admin\controllers\entertainment_sansar\faceweek;

if( !defined('BASEPATH') ) exit('No direct script access allowed');
use \MX_Controller as Controller,
\grocery_CRUD as groceryCrud,
\Exception as ErrorException;
/**
 *
 * @author SAM
 *
 */
class Stories extends Controller {

	/**
	 * Data Holder
	 *
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
				'Categories' => 'admin/entertainment_sansar/stories/categories',
				'Stories' => 'admin/entertainment_sansar/stories',
				'Comments' => 'admin/entertainment_sansar/stories/comments'
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
		}catch(ErrorException $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}

	}

	/**
	 * index (default) method
	 *
	 * lists the stories
	 */
	public function index()
	{

		$this->_crud->set_table('ent_st_stories');
		$this->_crud->set_subject('Story');

		/*
		 * Setting relation betweent category & story table and accessing name field to use
		*/
		$this->_crud->set_relation('ent_st_categories_id','ent_st_categories','title');

		/*
		 *  Setting text to display for more readablity
		*/
		$this->_crud->display_as('ent_st_categories_id','Story Category')
		->display_as('name', 'Name of story submitter')
		->display_as('title', 'Title of Story');

		/*
		 * Defining fields that show on Add & Edit forms if you want different then use add_fields & edit_fields
		*/
		$this->_crud->fields('title', 'description', 'name', 'email', 'status','ent_st_categories_id');

		/*
		 * setting rules for the Grocery CRUD to look for
		*/
		$this->_crud->set_rules('email', 'Email of submitter', 'trim|valid_email');

		/*
		 * Setting required field for CRUD operation, can also be replaced by set_rules method;
		* But most of the fields are requred, so this method is easier
		*/
		$this->_crud->required_fields('title', 'description', 'name', 'email', 'ent_st_categories_id');
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

	public function categories()
	{
		$this->_crud->set_table('ent_st_categories');
		$this->_crud->set_subject('Category');
		$this->_crud->required_fields('name', 'description');

		static::$data['name'] = 'crud';
		static::$data['content_replace'] = $this->_crud->render();

		$this->_crud_output('main', static::$data);
	}


	/**
	 * Method to load comments
	 */
	public function comments()
	{
		$this->_crud->set_table('ent_st_comments');
		$this->_crud->set_subject('Comment');
		$this->_crud->set_relation('ent_st_stories_id','ent_st_stories','title');
		$this->_crud->display_as('ent_st_stories_id', 'Story');
		$this->_crud->required_fields('name', 'email', 'comments', 'ent_st_stories_id');
		static::$data['name'] = 'crud';
		static::$data['content_replace'] = $this->_crud->render();

		$this->_crud_output('main', static::$data);
	}
}

$_ns = __NAMESPACE__;
?>