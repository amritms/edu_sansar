<?php

namespace admin\controllers\entertainment_sansar\poems;

if( !defined('BASEPATH') ) exit('No direct script access allowed');

use \MX_Controller as Controller,
	\grocery_CRUD as groceryCrud,
	\Exception as ErrorException;

/**
 *
 * @author kapil tandukar <kapil.tandukar@gmail.com>
 *
 */
class poems extends Controller{

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
				'Categories' => 'admin/entertainment_sansar/poems/categories',
				'Poems'		 => 'admin/entertainment_sansar/poems',
				'Comments' 	 => 'admin/entertainment_sansar/poems/comments'
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
		$this->_crud->set_table('ent_po_poems');
		$this->_crud->set_subject('poem');

		/**
		 * Setting relation between category & poem table and accessing name field to use
		 */
		$this->_crud->set_relation('ent_po_categories_id', 'ent_po_categories', 'name');

		/**
		 * Setting text to display for more readablity
		 */
		$this->_crud->display_as('ent_po_categories_id','Poem Category')
					->display_as('name', 'Name of poem submitter')
					->display_as('title', 'Title of poem');

		/*
		 * Defining fields that show on Add & Edit forms if you want different then use add_fields & edit_fields
		*/
		$this->_crud->fields('title', 'description', 'name', 'email', 'status','ent_po_categories_id');

		/*
		 * setting rules for the Grocery CRUD to look for
		*/
		$this->_crud->set_rules('email', 'Email of submitter', 'trim|valid_email');

		/*
		 * Setting required field for CRUD operation, can also be replaced by set_rules method;
		* But most of the fields are requred, so this method is easier
		*/
		$this->_crud->required_fields('title', 'description', 'name', 'email', 'ent_po_categories_id');
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
		$this->_crud->set_table('ent_po_categories');
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
		$this->_crud->set_table('ent_po_comments');
		$this->_crud->set_subject('Comment');
		$this->_crud->set_relation('ent_po_poems_id','ent_po_poems','title');
		$this->_crud->display_as('ent_po_poems_id', 'Poem');
		$this->_crud->required_fields('name', 'email', 'comments', 'ent_po_poems_id');
		static::$data['name'] = 'crud';
		static::$data['content_replace'] = $this->_crud->render();

		$this->_crud_output('main', static::$data);
	}
}
$_ns = __NAMESPACE__;