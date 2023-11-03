<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);		
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function login2(){
		
			extract($_POST);
			if(isset($email))
				$username = $email;
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			if($_SESSION['login_alumnus_id'] > 0){
				$bio = $this->db->query("SELECT * FROM alumnus_bio where id = ".$_SESSION['login_alumnus_id']);
				if($bio->num_rows > 0){
					foreach ($bio->fetch_array() as $key => $value) {
						if($key != 'passwors' && !is_numeric($key))
							$_SESSION['bio'][$key] = $value;
					}
				}
			}
			if($_SESSION['bio']['status'] != 1){
					foreach ($_SESSION as $key => $value) {
						unset($_SESSION[$key]);
					}
					return 2 ;
					exit;
				}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = '$type' ";
		if($type == 1)
			$establishment_id = 0;
		$data .= ", establishment_id = '$establishment_id' ";
		$chk = $this->db->query("Select * from users where username = '$username' and id !='$id' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function signup(){
		extract($_POST);
		$data = " name = '".$firstname.' '.$lastname."' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$uid = $this->db->insert_id;
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password')
					continue;
				if(empty($data) && !is_numeric($k) )
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if($_FILES['img']['tmp_name'] != ''){
							$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
							$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
							$data .= ", avatar = '$fname' ";

			}
			$save_alumni = $this->db->query("INSERT INTO alumnus_bio set $data ");
			if($data){
				$aid = $this->db->insert_id;
				$this->db->query("UPDATE users set alumnus_id = $aid where id = $uid ");
				$login = $this->login2();
				if($login)
				return 1;
			}
		}
	}
	function update_account(){
		extract($_POST);
		$data = " name = '".$firstname.' '.$lastname."' ";
		$data .= ", username = '$email' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' and id != '{$_SESSION['login_id']}' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("UPDATE users set $data where id = '{$_SESSION['login_id']}' ");
		if($save){
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password')
					continue;
				if(empty($data) && !is_numeric($k) )
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if($_FILES['img']['tmp_name'] != ''){
							$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
							$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
							$data .= ", avatar = '$fname' ";

			}
			$save_alumni = $this->db->query("UPDATE alumnus_bio set $data where id = '{$_SESSION['bio']['id']}' ");
			if($data){
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				$login = $this->login2();
				if($login)
				return 1;
			}
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['system'][$key] = $value;
		}

			return 1;
				}
	}
	function save_student(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM students where id_no ='$id_no' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO students set $data");
		}else{
			$save = $this->db->query("UPDATE students set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}
	function delete_student(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM students where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_faculty(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','ref_code')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM faculty where id_no ='$id_no' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO faculty set $data");
			$nid=$this->db->insert_id;
		}else{
			$save = $this->db->query("UPDATE faculty set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}
	function delete_faculty(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM faculty where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_employee(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','ref_code')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM employees where id_no ='$id_no' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO employees set $data");
			$nid=$this->db->insert_id;
		}else{
			$save = $this->db->query("UPDATE employees set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}
	function delete_employee(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM employees where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_log(){
		extract($_POST);
		$data = array();
		$qry = $this->db->query("SELECT * from $type where id_no = '$id_code' ");
		if($qry->num_rows > 0){
			$res = $qry->fetch_array();
			$id = $res['id'];
			$data['name'] = ucwords($res['name']);
		}else{
			$data['status'] = 2;
			return json_encode($data);
			exit;
		}
		$chk = $this->db->query("SELECT * FROM logs  where frm_id = '$id' and date(date_created) = '".date('Y-m-d')."' and type = '$type' order by unix_timestamp(date_created) desc limit 1 ");
		$result = $chk->num_rows > 0 ? $chk->fetch_array() : '';
		if(!empty($result)){
			$ltype = $result['log_type'] == 1 ? 2 : 1;
		}else{
			$ltype = 1;
		}
		$save = $this->db->query("INSERT INTO logs set frm_id = $id, log_type = '$ltype',type='$type' ");
		if($save)
			$data['status'] = 1;
			$data['type'] = $ltype;
			return json_encode($data);
	}
	function save_log_visitor(){
		extract($_POST);
		$data = array();
		$qry = $this->db->query("SELECT * from visitors where pass_no = '$pass_no' ");
		$id = -1;
		if($qry->num_rows > 0){
			$res = $qry->fetch_array();
			$id = $res['id'];
		}
		$chk = $this->db->query("SELECT * FROM logs  where frm_id = '$id' and date(date_created) = '".date('Y-m-d')."' and type = 'visitor' order by unix_timestamp(date_created) desc limit 1 ");
		$result = $chk->num_rows > 0 ? $chk->fetch_array() : '';
		if(!empty($result) && $result['log_type'] == 1 ){
			$data['status'] = 2;
			return json_encode($data);
			exit;
		}else{
			$det = "";
			foreach($_POST as $k => $v){
				if(!in_array($k, array('id','type')) && !is_numeric($k)){
					if(empty($det)){
						$det .= " $k='$v' ";
					}else{
						$det .= ", $k='$v' ";
					}
				}
			}
			// echo "INSERT INTO visitors set $det";
			$save = $this->db->query("INSERT INTO visitors set $det");
			if($save){
				$id = $this->db->insert_id;
				$save2 = $this->db->query("INSERT INTO logs set frm_id = $id, log_type = 1,type='visitor' ");
				if($save2)
					$data['status'] = 1;
					$data['type'] = 1;
			}	
		}
		return json_encode($data);

	}
	function save_log_visitor_out(){
		extract($_POST);
		$data = array();
		$qry = $this->db->query("SELECT v.*,l.type from visitors v inner join logs l on l.frm_id = v.id and l.type = 'visitor' where v.pass_no = '$id_code' and date(l.date_created) = '".date('Y-m-d')."' and l.type = 'visitor' order by unix_timestamp(date_created) desc limit 1 ");
		if($qry->num_rows > 0){
			$res = $qry->fetch_array();
			if($res['type'] == 2){
				$data['status'] = 2;
				return json_encode($data);
				exit;
			}else{
				$id = $res['id'];
				$data['name'] = ucwords($res['name']);
			}
		}else{
			$data['status'] = 2;
			return json_encode($data);
			exit;
		}
		$save = $this->db->query("INSERT INTO logs set frm_id = $id, log_type = '2',type='visitor' ");
		if($save)
			$data['status'] = 1;
			$data['type'] = 2;
			return json_encode($data);
	}
}