<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etc extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
		$this->load->model('Base');		
	}//function close


	public function index()
	{
		redirect("welcome/");
	}//function close


	
	//------convert_number_to_words  
	public function convert_number_to_words()
	{
		if(isset($_REQUEST['rs']))
		{
			$rs=$_REQUEST['rs'];
			$word= $this->Base->convert_number_to_words($rs);
			echo ucwords($word);
		}
	}//function close


	


	
	
	










}//class close
