<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'update_account'){
	$save = $crud->update_account();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_employee"){
	$save = $crud->save_employee();
	if($save)
		echo $save;
}
if($action == "delete_employee"){
	$save = $crud->delete_employee();
	if($save)
		echo $save;
}

if($action == "save_class"){
	$save = $crud->save_class();
	if($save)
		echo $save;
}
if($action == "delete_class"){
	$save = $crud->delete_class();
	if($save)
		echo $save;
}
if($action == "save_faculty"){
	$save = $crud->save_faculty();
	if($save)
		echo $save;
}
if($action == "delete_faculty"){
	$save = $crud->delete_faculty();
	if($save)
		echo $save;
}

if($action == "save_student"){
	$save = $crud->save_student();
	if($save)
		echo $save;
}
if($action == "delete_student"){
	$save = $crud->delete_student();
	if($save)
		echo $save;
}
if($action == "save_log"){
	$save = $crud->save_log();
	if($save)
		echo $save;
}

if($action == "save_log_visitor"){
	$save = $crud->save_log_visitor();
	if($save)
		echo $save;
}
if($action == "save_log_visitor_out"){
	$save = $crud->save_log_visitor_out();
	if($save)
		echo $save;
}
ob_end_flush();
?>
