<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @author Suraj Kumar Adhikari <surajadhikari1929@gmail.com>
 *
 */
class Event extends grocery_CRUD_Model 
{
	/**
	 * @Override 
	 * 
	 * @see grocery_CRUD_Model::where()
	 */
	public function where($key, $id)
	{
		return parent::where($key, $id);
	}

}