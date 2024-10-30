<?php 
$wpconfig = realpath('../../../../wp-config.php');
if (!file_exists($wpconfig)) { exit('Could not find wp-config.php.'); }
	require_once($wpconfig);
//	require_once(ABSPATH.'/wp-admin/admin.php');
	require(ABSPATH . WPINC . '/pluggable.php');

if(isset($_POST['campain'])){
	linktrkr_update_general();
}
if(isset($_POST['theid'])){
	linktrkr_add_url($_POST['theid'],$_POST['urlname'],0,'generalid');
}
if(isset($_POST['deletelink'])){
	linktrkr_delete_url($_POST['deletelink']);
}
if(isset($_POST['statusurl'])){
	linktrkr_reset_hits();
}
if(isset($_POST['updateurl'])){
	linktrkr_update_url();
}
if(isset($_POST['updatecategoryname'])){
	linktrkr_update_category();
}
if(isset($_POST['keywordsadd'])){
	linktrkr_add_keywords();
}
if(isset($_POST['deletegeneralid'])){
	linktrkr_delete_general();
}
if(isset($_POST['pageselect'])){
	clictraker_saveshareme();
}
if(isset($_POST['contentlockurl'])){
	clictraker_add_url($_POST['thegenid'],$_POST['contentlockurl'],1,$_POST['table']);
}
if(isset($_POST['deletemycontenturl'])){
	clictraker_delete_url($_POST['deletemycontenturl']);
}
if(isset($_POST['wheretheidgoes'])){
	clictraker_contentlocker();
}
if(isset($_POST['fbbox_generalid'])){
	clictraker_fblike_locker();
}
if(isset($_POST['pageid'])){
	clictraker_save_post_lock_page();
}

if(isset($_POST['checkingapi'])){
	checking_api();
}
if(isset($_GET['checkip'])){
	echo checkip();
}
if(isset($_POST['deletedata'])){
	deletedata($_POST['deletedata']);
}
?>