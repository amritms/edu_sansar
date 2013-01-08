<?php
namespace admin\controllers\entertainment_sansar\quiz;

if( !defined('BASEPATH') ) exit('No direct script access allowed');

use \MX_Controller as Controller,
	\grocery_CRUD as groceryCrud,
	\Exception as ErrorException;

/**
 *
 * @author kapil tandukar <kapil.tandukar@gmail.com>
 *
 */


class quiz extends Controller{

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
				'Add quiz'	 => 'admin/entertainment_sansar/quiz'
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
		

		}catch (ErrorException $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	
	/**
	 * index default method
	 *
	 * list of events
	 */
	public function index()
	{
		$this->_crud->set_table('ent_quiz');
		$this->_crud->set_subject('Quiz');
	
		
		/**
		 * Setting text to display for more readablity
		*/
		$this->_crud->display_as('ans1','answer a')
					->display_as('ans2', 'answer b')
					->display_as('ans3', 'answer c')
					->display_as('ans4','answer d');
	
		
		
		$this->_crud->fields('question', 'ans1', 'ans2', 'ans3', 'ans4','status');
	
		
		/*
		 * setting rules for the Grocery CRUD to look for
		*/
		$this->_crud->set_rules('ans1', 'answer ', 'trim|required')
					->set_rules('ans2', 'answer ', 'trim|required')
					->set_rules('ans3', 'answer ', 'trim|required')
					->set_rules('ans4', 'answer ', 'trim|required');
		
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

}

$_ns = __NAMESPACE__;