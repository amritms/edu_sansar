<?php
/**
 * PHP grocery CRUD
 *
 * LICENSE
 *
 * Grocery CRUD is released with dual licensing, using the GPL v3 (license-gpl3.txt) and the MIT license (license-mit.txt).
 * You don't have to do anything special to choose one license or the other and you don't have to notify anyone which license you are using.
 * Please see the corresponding license file for details of these licenses.
 * You are free to use, modify and distribute this software, but all copyright information must remain.
 *
 * @package    	grocery CRUD
 * @copyright  	Copyright (c) 2010 through 2012, John Skoumbourdis
 * @license    	https://github.com/scoumbourdis/grocery-crud/blob/master/license-grocery-crud.txt
 * @version    	1.2
 * @author     	John Skoumbourdis <scoumbourdisj@gmail.com>
 */

// ------------------------------------------------------------------------

/**
 * Grocery CRUD Model
 *
 *
 * @package    	grocery CRUD
 * @author     	John Skoumbourdis <scoumbourdisj@gmail.com>
 * @version    	1.2
 * @link		http://www.grocerycrud.com/documentation
 */
class grocery_CRUD_Model  extends CI_Model  {

	protected $primary_key = null;
	protected $table_name = null;
	protected $relation = array();
	protected $relation_n_n = array();
	protected $primary_keys = array();

	public function __construct()
    {
        parent::__construct();
	}

    public function db_table_exists($table_name = null)
    {
    	return $this->db->table_exists($table_name);
    }

    public function get_list()
    {
    	if($this->table_name === null)
    		return false;

    	$select = "`{$this->table_name}`.*";

    	//set_relation special queries
    	if(!empty($this->relation))
    	{
    		foreach($this->relation as $relation)
    		{
    			list($field_name , $related_table , $related_field_title) = $relation;
    			$unique_join_name = $this->_unique_join_name($field_name);
    			$unique_field_name = $this->_unique_field_name($field_name);

				if(strstr($related_field_title,'{'))
				{
					$related_field_title = str_replace(" ","&nbsp;",$related_field_title);
    				$select .= ", CONCAT('".str_replace(array('{','}'),array("',COALESCE({$unique_join_name}.",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $unique_field_name";
				}
    			else
    			{
    				$select .= ", $unique_join_name.$related_field_title AS $unique_field_name";
    			}

    			if($this->field_exists($related_field_title))
    				$select .= ", `{$this->table_name}`.$related_field_title AS '{$this->table_name}.$related_field_title'";
    		}
    	}

    	//set_relation_n_n special queries. We prefer sub queries from a simple join for the relation_n_n as it is faster and more stable on big tables.
    	if(!empty($this->relation_n_n))
    	{
			$select = $this->relation_n_n_queries($select);
    	}

    	$this->db->select($select, false);

    	$results = $this->db->get($this->table_name)->result();

    	return $results;
    }

    public function set_primary_key($field_name, $table_name = null)
    {
    	$table_name = $table_name === null ? $this->table_name : $table_name;

    	$this->primary_keys[$table_name] = $field_name;
    }

    protected function relation_n_n_queries($select)
    {
    	$this_table_primary_key = $this->get_primary_key();
    	foreach($this->relation_n_n as $relation_n_n)
    	{
    		list($field_name, $relation_table, $selection_table, $primary_key_alias_to_this_table,
    					$primary_key_alias_to_selection_table, $title_field_selection_table, $priority_field_relation_table) = array_values((array)$relation_n_n);

    		$primary_key_selection_table = $this->get_primary_key($selection_table);

	    	$field = "";
	    	$use_template = strpos($title_field_selection_table,'{') !== false;
	    	$field_name_hash = $this->_unique_field_name($title_field_selection_table);
	    	if($use_template)
	    	{
	    		$title_field_selection_table = str_replace(" ", "&nbsp;", $title_field_selection_table);
	    		$field .= "CONCAT('".str_replace(array('{','}'),array("',COALESCE(",", ''),'"),str_replace("'","\\'",$title_field_selection_table))."')";
	    	}
	    	else
	    	{
	    		$field .= "$selection_table.$title_field_selection_table";
	    	}

    		//Sorry Codeigniter but you cannot help me with the subquery!
    		$select .= ", (SELECT GROUP_CONCAT(DISTINCT $field) FROM $selection_table "
    			."LEFT JOIN $relation_table ON $relation_table.$primary_key_alias_to_selection_table = $selection_table.$primary_key_selection_table "
    			."WHERE $relation_table.$primary_key_alias_to_this_table = `{$this->table_name}`.$this_table_primary_key GROUP BY $relation_table.$primary_key_alias_to_this_table) AS $field_name";
    	}

    	return $select;
    }

    public function order_by($order_by , $direction)
    {
    	$this->db->order_by( $order_by , $direction );
    }

    public function where($key, $value = NULL, $escape = TRUE)
    {
    	$this->db->where( $key, $value, $escape);
    }

    public function or_where($key, $value = NULL, $escape = TRUE)
    {
    	$this->db->or_where( $key, $value, $escape);
    }

    public function having($key, $value = NULL, $escape = TRUE)
    {
    	$this->db->having( $key, $value, $escape);
    }

    public function or_having($key, $value = NULL, $escape = TRUE)
    {
    	$this->db->or_having( $key, $value, $escape);
    }

    public function like($field, $match = '', $side = 'both')
    {
    	$this->db->like($field, $match, $side);
    }

    public function or_like($field, $match = '', $side = 'both')
    {
    	$this->db->or_like($field, $match, $side);
    }

    public function limit($value, $offset = '')
    {
    	$this->db->limit( $value , $offset );
    }

    public function get_total_results()
    {
    	//set_relation_n_n special queries. We prefer sub queries from a simple join for the relation_n_n as it is faster and more stable on big tables.
    	if(!empty($this->relation_n_n))
    	{
    		$select = "{$this->table_name}.*";
    		$select = $this->relation_n_n_queries($select);

    		$this->db->select($select,false);

    		return $this->db->get($this->table_name)->num_rows();

    	}
    	else
    	{
    		return $this->db->get($this->table_name)->num_rows();
    	}
    }

    public function set_basic_table($table_name = null)
    {
    	if( !($this->db->table_exists($table_name)) )
    		return false;

    	$this->table_name = $table_name;

    	return true;
    }

    public function get_edit_values($primary_key_value)
    {
    	$primary_key_field = $this->get_primary_key();
    	$this->db->where($primary_key_field,$primary_key_value);
    	$result = $this->db->get($this->table_name)->row();
    	return $result;
    }

    public function join_relation($field_name , $related_table , $related_field_title)
    {
		$related_primary_key = $this->get_primary_key($related_table);

		if($related_primary_key !== false)
		{
			$unique_name = $this->_unique_join_name($field_name);
			$this->db->join( $related_table.' as '.$unique_name , "$unique_name.$related_primary_key = {$this->table_name}.$field_name",'left');

			$this->relation[$field_name] = array($field_name , $related_table , $related_field_title);

			return true;
		}

    	return false;
    }

    public function set_relation_n_n_field($field_info)
    {
		$this->relation_n_n[$field_info->field_name] = $field_info;
    }

    protected function _unique_join_name($field_name)
    {
    	return 'j'.substr(md5($field_name),0,8); //This j is because is better for a string to begin with a letter and not with a number
    }

    protected function _unique_field_name($field_name)
    {
    	return 's'.substr(md5($field_name),0,8); //This s is because is better for a string to begin with a letter and not with a number
    }

    public function get_relation_array($field_name , $related_table , $related_field_title, $where_clause, $order_by, $limit = null, $search_like = null)
    {
    	$relation_array = array();
    	$field_name_hash = $this->_unique_field_name($field_name);

    	$related_primary_key = $this->get_primary_key($related_table);

    	$select = "$related_table.$related_primary_key, ";

    	if(strstr($related_field_title,'{'))
    	{
    		$related_field_title = str_replace(" ", "&nbsp;", $related_field_title);
    		$select .= "CONCAT('".str_replace(array('{','}'),array("',COALESCE(",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $field_name_hash";
    	}
    	else
    	{
	    	$select .= "$related_table.$related_field_title as $field_name_hash";
    	}

    	$this->db->select($select,false);
    	if($where_clause !== null)
    		$this->db->where($where_clause);

    	if($where_clause !== null)
    		$this->db->where($where_clause);

    	if($limit !== null)
    		$this->db->limit($limit);

    	if($search_like !== null)
    		$this->db->having("$field_name_hash LIKE '%".$this->db->escape_like_str($search_like)."%'");

    	$order_by !== null
    		? $this->db->order_by($order_by)
    		: $this->db->order_by($field_name_hash);

    	$results = $this->db->get($related_table)->result();

    	foreach($results as $row)
    	{
    		$relation_array[$row->$related_primary_key] = $row->$field_name_hash;
    	}

    	return $relation_array;
    }

    public function get_ajax_relation_array($search, $field_name , $related_table , $related_field_title, $where_clause, $order_by)
    {
    	return $this->get_relation_array($field_name , $related_table , $related_field_title, $where_clause, $order_by, 10 , $search);
    }

    public function get_relation_total_rows($field_name , $related_table , $related_field_title, $where_clause)
    {
    	if($where_clause !== null)
    		$this->db->where($where_clause);

    	return $this->db->get($related_table)->num_rows();
    }

    public function get_relation_n_n_selection_array($primary_key_value, $field_info)
    {
    	$select = "";
    	$related_field_title = $field_info->title_field_selection_table;
    	$use_template = strpos($related_field_title,'{') !== false;;
    	$field_name_hash = $this->_unique_field_name($related_field_title);
    	if($use_template)
    	{
    		$related_field_title = str_replace(" ", "&nbsp;", $related_field_title);
    		$select .= "CONCAT('".str_replace(array('{','}'),array("',COALESCE(",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $field_name_hash";
    	}
    	else
    	{
    		$select .= "$related_field_title as $field_name_hash";
    	}
    	$this->db->select('*, '.$select,false);

    	$selection_primary_key = $this->get_primary_key($field_info->selection_table);

    	if(empty($field_info->priority_field_relation_table))
    	{
    		if(!$use_template){
    			$this->db->order_by("{$field_info->selection_table}.{$field_info->title_field_selection_table}");
    		}
    	}
    	else
    	{
    		$this->db->order_by("{$field_info->relation_table}.{$field_info->priority_field_relation_table}");
    	}
    	$this->db->where($field_info->primary_key_alias_to_this_table, $primary_key_value);
    	$this->db->join(
    			$field_info->selection_table,
    			"{$field_info->relation_table}.{$field_info->primary_key_alias_to_selection_table} = {$field_info->selection_table}.{$selection_primary_key}"
    		);
    	$results = $this->db->get($field_info->relation_table)->result();

    	$results_array = array();
    	foreach($results as $row)
    	{
    		$results_array[$row->{$field_info->primary_key_alias_to_selection_table}] = $row->{$field_name_hash};
    	}

    	return $results_array;
    }

    public function get_relation_n_n_unselected_array($field_info, $selected_values)
    {
    	$use_where_clause = !empty($field_info->where_clause);

    	$select = "";
    	$related_field_title = $field_info->title_field_selection_table;
    	$use_template = strpos($related_field_title,'{') !== false;
    	$field_name_hash = $this->_unique_field_name($related_field_title);

    	if($use_template)
    	{
    		$related_field_title = str_replace(" ", "&nbsp;", $related_field_title);
    		$select .= "CONCAT('".str_replace(array('{','}'),array("',COALESCE(",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $field_name_hash";
    	}
    	else
    	{
    		$select .= "$related_field_title as $field_name_hash";
    	}
    	$this->db->select('*, '.$select,false);

    	if($use_where_clause){
    		$this->db->where($field_info->where_clause);
    	}

    	$selection_primary_key = $this->get_primary_key($field_info->selection_table);
        if(!$use_template)
        	$this->db->order_by("{$field_info->selection_table}.{$field_info->title_field_selection_table}");
        $results = $this->db->get($field_info->selection_table)->result();

        $results_array = array();
        foreach($results as $row)
        {
            if(!isset($selected_values[$row->$selection_primary_key]))
                $results_array[$row->$selection_primary_key] = $row->{$field_name_hash};
        }

        return $results_array;
    }

    public function db_relation_n_n_update($field_info, $post_data ,$main_primary_key)
    {
    	$this->db->where($field_info->primary_key_alias_to_this_table, $main_primary_key);
    	if(!empty($post_data))
    		$this->db->where_not_in($field_info->primary_key_alias_to_selection_table , $post_data);
    	$this->db->delete($field_info->relation_table);

    	$counter = 0;
    	if(!empty($post_data))
    	{
    		foreach($post_data as $primary_key_value)
	    	{
				$where_array = array(
	    			$field_info->primary_key_alias_to_this_table => $main_primary_key,
	    			$field_info->primary_key_alias_to_selection_table => $primary_key_value,
	    		);

	    		$this->db->where($where_array);
				$count = $this->db->from($field_info->relation_table)->count_all_results();

				if($count == 0)
				{
					if(!empty($field_info->priority_field_relation_table))
						$where_array[$field_info->priority_field_relation_table] = $counter;

					$this->db->insert($field_info->relation_table, $where_array);

				}elseif($count >= 1 && !empty($field_info->priority_field_relation_table))
				{
					$this->db->update( $field_info->relation_table, array($field_info->priority_field_relation_table => $counter) , $where_array);
				}

				$counter++;
	    	}
    	}
    }

    public function db_relation_n_n_delete($field_info, $main_primary_key)
    {
    	$this->db->where($field_info->primary_key_alias_to_this_table, $main_primary_key);
    	$this->db->delete($field_info->relation_table);
    }

    public function get_field_types_basic_table()
    {
    	$db_field_types = array();
    	foreach($this->db->query("SHOW COLUMNS FROM `{$this->table_name}`")->result() as $db_field_type)
    	{
    		$type = explode("(",$db_field_type->Type);
    		$db_type = $type[0];

    		if(isset($type[1]))
    		{
    			if(substr($type[1],-1) == ')')
    			{
    				$length = substr($type[1],0,-1);
    			}
    			else
    			{
    				list($length) = explode(" ",$type[1]);
    				$length = substr($length,0,-1);
    			}
    		}
    		else
    		{
    			$length = '';
    		}
    		$db_field_types[$db_field_type->Field]['db_max_length'] = $length;
    		$db_field_types[$db_field_type->Field]['db_type'] = $db_type;
    		$db_field_types[$db_field_type->Field]['db_null'] = $db_field_type->Null == 'YES' ? true : false;
    		$db_field_types[$db_field_type->Field]['db_extra'] = $db_field_type->Extra;
    	}

    	$results = $this->db->field_data($this->table_name);
    	foreach($results as $num => $row)
    	{
    		$row = (array)$row;
    		$results[$num] = (object)( array_merge($row, $db_field_types[$row['name']])  );
    	}

    	return $results;
    }

    public function get_field_types($table_name)
    {
    	$results = $this->db->field_data($table_name);

    	return $results;
    }

    public function db_update($post_array, $primary_key_value)
    {
    	$primary_key_field = $this->get_primary_key();
    	return $this->db->update($this->table_name,$post_array, array( $primary_key_field => $primary_key_value));
    }

    public function db_insert($post_array)
    {
    	$insert = $this->db->insert($this->table_name,$post_array);
    	if($insert)
    	{
    		return $this->db->insert_id();
    	}
    	return false;
    }
    
    /**
     * Related constraint tables
     * 
     * @author Suraj Kumar Adhikari <surajadhikari1929@gmail.com>
     * @param  string 	$table_name
     * @return object
     */
    public function get_related_tables($table_name)
    {
    	if($connection = mysql_connect($this->db->hostname, $this->db->username, $this->db->password))
    	{
    		if(mysql_select_db('information_schema', $connection))
    		{
    			$result = mysql_query("SELECT * FROM 
    										KEY_COLUMN_USAGE WHERE 
    										REFERENCED_TABLE_NAME = '{$table_name}' 
    										AND REFERENCED_COLUMN_NAME = 'id'");
    			
    			return mysql_fetch_object($result);
			}
    	 }
    }
    
    /**
     * Gets the primary key
     * 
     * @author Suraj Kumar Adhikari <surajadhikari1929@gmail.com>
     * @param 	string 	$table_name
     * @param 	string 	$column
     */
    public function get_primarykey_value($table_name, $column)
    {
    	$result  = $this->db->select($column)->get($table_name)->result();
    	foreach($result as $row)
    	{
    		return $row->$column;
    	}
    }
    
    /**
     * Checkes if the field value existed
     * 
     * @author Suraj Kumar Adhikari <surajadhikari1929@gmail.com>
     * @param 	string	 $field
     * @param 	string	 $table
     * @param 	string	 $str
     * @return 	boolean
     */
    public function is_exists($field, $table, $str)
    {
    	$query = $this->db->limit(1)->get_where($table, array($field => $str));
    
    	return $query->num_rows() > 0 ? true : false;
    }
	
    /**
     * Iterates $data array
     * 
     * @author 	Suraj Kumar Adhikari <surajadhikari1929@gmail.com>
     * @param 	array		 $data
     * @return 	stdClass
     */
    public function iterate($data)
    {
    	$fields = new stdClass();
    
    	foreach($data as $db)
    	{
    	    foreach($db as $value)
    		{
    			$fields->field[] = $value;
    		}
    	 }
		return $fields;
    }
    
    /**
     * Checkes if the table has a foreign key relation with another table
     * 
     * @author Suraj Kumar Adhikari <surajadhikari1929@gmail.com>
     * @param  string		 $primary_key_field
     * @param  int			 $primary_key_value
     */
    public function recurse($primary_key_field, $primary_key_value)
    {
    	$data = array();
    	$related_tables = array();
    	if($this->db->get($this->table_name)->result() > 0)
    	{
    		$data[$this->table_name] = $this->db->get_where($this->table_name, array($primary_key_field => $primary_key_value))->result();
    		$table = $this->get_related_tables($this->table_name);
	    	if(isset($table->TABLE_NAME) && ($this->db->get($table->TABLE_NAME)->result() > 0))
	    	{
	    		$data[$table->TABLE_NAME] = $this->db->get_where($table->TABLE_NAME, array($table->COLUMN_NAME => $primary_key_value))->result();
	    		$fields = $this->iterate($data);
	  
	    		if(isset($table->TABLE_NAME) && $this->db->get($table->TABLE_NAME)->result() > 0)
	    		{
	    			$related_tables[] = $table->COLUMN_NAME;
	    			$table = $this->get_related_tables($table->TABLE_NAME);
	    			
	    			if(!empty($table))
	    			{
		    			foreach($fields->field as $db)
		    			{
			    			if($this->is_exists($table->COLUMN_NAME, $table->TABLE_NAME, $db->id)){
			    				$data[$table->TABLE_NAME][] = $this->db->get_where($table->TABLE_NAME, array($table->COLUMN_NAME => $db->id))->result();
			    			}
		    			}
		    			
		    			$related_tables[] = $table->COLUMN_NAME;
		    			$table = $this->get_related_tables($table->TABLE_NAME);
		    			
		    			if(!empty($table))
		    			{
		    				$related_tables[] = $table->COLUMN_NAME;
		    				$fields = $this->iterate($data);
		    				foreach($data as $key => $value)
		    				{
		    					foreach($value as $val)
		    					{
		    						if(is_array($val))
		    						{
		    							foreach($val as $v)
		    							{
		    								if($this->is_exists($table->COLUMN_NAME, $table->TABLE_NAME, $v->id) === true){
		    									$data[$table->TABLE_NAME][] = $this->db->get_where($table->TABLE_NAME, array($table->COLUMN_NAME => $v->id))->result();
		    								}
		    							}
		    						}
		    						else
		    						{
		    							if($this->is_exists($table->COLUMN_NAME, $table->TABLE_NAME, $val->id) === true)
		    							{
		    								$data[$table->TABLE_NAME][] = $this->db->get_where($table->TABLE_NAME, array($table->COLUMN_NAME => $val->id))->result();
		    							}
		    						}
		    					}
		    					 
		    				}
		    			}
	    			}
	    				
	    		}
	    	}
    	}
	
	foreach(array_reverse($data) as $key => $value)
	{
		foreach(array_reverse($related_tables) as $table)
		{
			foreach($value as $tables)
			{
				if(is_array($tables))
				{
					foreach($tables as $column)
					{
						if(property_exists($column, $table))
						{
							$result[$key][] = $this->db->get_where($key, array($table => $column->$table))->result();
							break;
						}
						
					}
				}
				else
				{
						if(property_exists($tables, $table))
						{
							$result[$key][] = $this->db->get_where($key, array($table => $tables->$table))->result();
							break;
						}
				}
			}
		}
	}
	
	if(isset($result))
	{
		foreach($result as $key => $value)
		{
			foreach($value as $val)
			{
				foreach($val as $aval)
				{
					if(property_exists($aval, 'url') && !empty($aval->url))
	    			{
	    					$segment = $this->uri->segment(3) . '_images/';
	    					
	    					if(file_exists($this->config->item('dir') . '/assets/uploads/'. $segment . $aval->url))
	    					{
	    						if(unlink($this->config->item('dir') . '/assets/uploads/'. $segment . $aval->url))
	    						{
	    						 	if(file_exists($this->config->item('dir') . '/assets/uploads/'. $segment . 'thumb__'.$aval->url))
	    							{
	    								if(unlink($this->config->item('dir') . '/assets/uploads/'. $segment . 'thumb__'.$aval->url))
	    								{
	    									$this->db->limit(1)->delete($key, array('ent_ev_albums_id' => $aval->ent_ev_albums_id));
	    									
	    									if($this->db->affected_rows() > 0)
	    									{
	    										$message['album'] = 'Album has been deleted';
	    									}
	    								}
	    							}
	    						}
	    					}
	    				} 
	    				else 
	    				{
	    					if(!empty($related_tables) && is_array($related_tables))
	    						{
	    							foreach(array_reverse($related_tables) as $tbl)
	    							{
	    								if(property_exists($aval, $tbl))
	    								{
	    									if(property_exists($aval, 'image'))
	    									{
	    										$segment = $this->uri->segment(3) . '/';

													if(file_exists($this->config->item('dir') . '/assets/uploads/'. $segment . $aval->image))
													{
														if(unlink($this->config->item('dir') . '/assets/uploads/'. $segment . $aval->image))
														{
															$this->db->delete($key, array($tbl => $aval->$tbl));
														}
													}
	    										}
	    										else
	    										{
	    											$this->db->delete($key, array($tbl => $aval->$tbl));
	    										}
	    									}
	    								}
	    							}
	    						}
	    					}
						}
					}
				}
			}

    /**
     * Database delete
     * 
     * @modify Suraj Kumar Adhikari <surajadhikari1929@gmail.com>
     * @param  int 		$primary_key_value
     * @return mixed
     */
    public function db_delete($primary_key_value)
    {
    	$primary_key_field = $this->get_primary_key();

		if($primary_key_field === false)
    		return false;
			
		$result = $this->db->get_where($this->table_name, array($primary_key_field => $primary_key_value))->result();
		
		$this->recurse($primary_key_field, $primary_key_value);
		
		if(property_exists($result[0], 'image') && !empty($result[0]->image))
		{
				$segment = $this->uri->segment(3) . '/';

				if(file_exists($this->config->item('dir') . '/assets/uploads/'. $segment . $result[0]->image))
				{
					if(unlink($this->config->item('dir') . '/assets/uploads/'. $segment . $result[0]->image))
					{
						$this->db->limit(1);
						$this->db->delete($this->table_name, array( $primary_key_field => $primary_key_value));
					}
				}
				else
				{
					$this->db->limit(1);
					$this->db->delete($this->table_name,array( $primary_key_field => $primary_key_value));
				}
			}
			else
			{
				$this->db->limit(1);
				$this->db->delete($this->table_name,array( $primary_key_field => $primary_key_value));
			}

			if( $this->db->affected_rows() == 1)
			 {
					return true;
			 }
			 else
			 {
		    		return false;
			 }
    }

    public function db_file_delete($field_name, $filename)
    {
    	if( $this->db->update($this->table_name,array($field_name => ''),array($field_name => $filename)) )
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }

    public function field_exists($field,$table_name = null)
    {
    	if(empty($table_name))
    	{
    		$table_name = $this->table_name;
    	}
    	return $this->db->field_exists($field,$table_name);
    }

    public function get_primary_key($table_name = null)
    {
    	if($table_name == null)
    	{
    		if(isset($this->primary_keys[$this->table_name]))
    		{
    			return $this->primary_keys[$this->table_name];
    		}

	    	if(empty($this->primary_key))
	    	{
		    	$fields = $this->get_field_types_basic_table();

		    	foreach($fields as $field)
		    	{
		    		if($field->primary_key == 1)
		    		{
		    			return $field->name;
		    		}
		    	}

		    	return false;
	    	}
	    	else
	    	{
	    		return $this->primary_key;
	    	}
    	}
    	else
    	{
    		if(isset($this->primary_keys[$table_name]))
    		{
    			return $this->primary_keys[$table_name];
    		}

	    	$fields = $this->get_field_types($table_name);

	    	foreach($fields as $field)
	    	{
	    		if($field->primary_key == 1)
	    		{
	    			return $field->name;
	    		}
	    	}

	    	return false;
    	}

    }

    public function escape_str($value)
    {
    	return $this->db->escape_str($value);
    }

}