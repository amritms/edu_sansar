<?php

namespace admin\controllers\admin;

if(! defined('BASEPATH')) exit('No direct script access allowed');

use \MX_Controller as Controller;

/**
 * Admin controller Class
 *
 * @author Suraj Kumar Adhikari <surajadhikari1929@gmail.com>
 */
class admin extends Controller
{
    /**
     * Data Holder
     *
     * @var array
     */
    protected static $data = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        /*
         * Loading Ion Auth Library
         */
        $this->load->library('ion_auth');
    }

    public function index()
    {
    	/*
         * If not logged in redirect them to login page
         */
        if (!$this->ion_auth->logged_in()) {
                $this->session->set_flashdata('message','You are not logged in. <br /> Please login before trying to access admin panel');
                redirect('auth/login', 'refresh');
        }

        /*
         * Loading main view
         */
    	$this->load->view('main');
    }


}

$_ns = __NAMESPACE__;