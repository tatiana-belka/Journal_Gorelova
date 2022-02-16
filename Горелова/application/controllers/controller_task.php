<?php

class Controller_task extends Controller
{
	private $db;
    private $data = array();
    private static $sortOrders = array('0'=>'DESC',
                            '1'=>'ASC',);
    private static $sortElems = array('0' => 'date',
                               '1' => 'name',
                               '2' => 'mail');

    public function __construct()
    {
        $this->model = new Model_Task();
        $this->view  = new View();
	    include_once('application/inc/db.class.php');
	    try {
	        $this->db = new dbConnection();
	    }
	    catch (PDOException $e) {
		    $this->view->generate('taskTemplates/db.error.tpl', 'template_view.php');
		    die();
	    };
    }
    
    function action_index()
    {
        //$data = array();
        $this->data['records_on_page'] = 25;
        $this->get_options();

	    $this->set_cookie_options();
	    $this->data['record_counter'] = $this->db->count_all_records();
	    $this->data['number_of_page'] = ceil($this->data['record_counter'] / $this->data['records_on_page'] );

	    $this->data['current_page'] = 0;
	    $uri_args = explode('/' , $_SERVER['REQUEST_URI']);
	    if (array_key_exists('3', $uri_args)) // /task/value/page -> task=1st parameter, value=2nd, page=3
	        $this->data['current_page'] = intval($uri_args['3']);

	    $this->data['records'] = $this->db->get_page_records(
		                        $this->data['current_page'],
		                        $this->data['records_on_page'],
		                        $this->data['sortOrder'],
		                        $this->data['sortElem']);
        $this->view->generate(NULL, 'taskTemplates/header.template.tpl', $this->data);
        $this->view->generate(NULL, 'taskTemplates/body.template.tpl', $this->data);
        $this->view->generate(NULL, 'taskTemplates/footer.template.tpl', $this->data);
    }
    function get_options() {
	   
	    if (isset($_COOKIE['sortOrder'])) {
		    $indexSortOrder = intval($_COOKIE['sortOrder']);
		    if (isset( self::$sortOrders[$indexSortOrder] )) {
			    $this->data['sortOrder'] = $indexSortOrder;
		    }
	    }
	    if (isset($_COOKIE['sortElem'])) {
		    $indexSortElem = intval($_COOKIE['sortElem']);
		    if (isset( self::$sortElems[$indexSortElem] )) {
			    $this->data['sortElem'] = $indexSortElem;
		    }
	    }
      
        if (isset($_POST['sortOrder'])) {
            $indexSortOrder = intval($_POST['sortOrder']);
            if (isset( self::$sortOrders[$indexSortOrder] )) {
                $this->data['sortOrder'] = $indexSortOrder;
            }
        }
        if (isset($_POST['sortElem'])) {
            $indexSortElem = intval($_POST['sortElem']);
            if (isset( self::$sortElems[$indexSortElem] )) {
                $this->data['sortElem'] = $indexSortElem;
            }
        }
	 
	    if (!isset($this->data['sortOrder']) )
	        $this->data['sortOrder'] = 0; //DESC sort
	    if (!isset($this->data['sortElem']))
	        $this->data['sortElem'] =  0; //date field sorting;

    }

	function set_cookie_options() {
		if (isset($this->data['sortOrder'])) {
			setcookie('sortOrder', $this->data['sortOrder'], 0, '/');
		}

		if (isset($this->data['sortElem'])) {
			setcookie('sortElem', $this->data['sortElem'], 0, '/');
		}
	}

	function validate_name($name) {
		$pattern = '/[^-a-zA-z0-9]/';
		$replacement = '';
		$name = preg_replace($pattern, $replacement, $name);
		return $name;
	}

	function validate_mail($mail) {
		$pattern = '/[^@.a-zA-Z0-9]/';
		$replacement = '';
		$mail = preg_replace($pattern, $replacement, $mail);
		$mail = htmlspecialchars($mail);
		echo $mail;
		return $mail;
	}

	function validate_text($text) {
		
		$allowable_tags = '<i><a><code><strike><strong>';
		$text = strip_tags( $text, $allowable_tags );
		return $text;
	}

	function check_data() {
		$success = True;
		$this->data['error'] = '';
		$this->data['name'] = $this->validate_name( $name=$_POST['user'] );
		$this->data['mail'] = $this->validate_mail($_POST['mail']);
		$this->data['msg'] = $this->validate_text($this->data['msg']);
		$this->data['home'] = htmlspecialchars( $this->data['home']);
		echo $this->data['msg'];
		if ($this->data['captcha'] != $this->data['realcaptcha']) {
			$success &= False;
			$this->data['error'] .= "Invalid captcha<br />";
		}
		echo $this->data['mail'];
		return $success;
	}

	function action_savepost() {
		$this->data['captcha'] = $_POST['captcha'];
		$this->data['name'] = $_POST['user'];
		$this->data['mail'] = $_POST['mail'];
		$this->data['msg'] = $_POST['datatext'];
		$this->data['home'] = $_POST['homepage'];
		$this->data['ua'] = $_SERVER["HTTP_USER_AGENT"];
		$this->data['ip'] = $_SERVER["HTTP_X_REAL_IP"];
		$this->data['captcha2'] = $_POST['captcha'];
		$this->data['realcaptcha'] = $_COOKIE['captchaid'];

		if ($this->check_data()) {
			$this->send_data($this->data);
			$this->view->generate('taskTemplates/successful.tpl', 'template_view.php', $this->data);
		} else {
			$this->view->generate('taskTemplates/failure-record.tpl', 'template_view.php', $this->data);
		}
	}

	function send_data() {
		$this->db->add_record(
			$name = $this->data['name'],
			$mail = $this->data['mail'],
			$ip = $this->data['ip'],
			$home= $this->data['home'],
			$msg = $this->data['msg'],
			$ua = $this->data['ua'] );
	}
}