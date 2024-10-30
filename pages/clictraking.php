<?php 
global $wpdb;
$api = tracker_info();
$api = $api->apicredintial;
$msg = '';

if(function_exists('curl_init')){
	$url = 'http://clictracker.com/geturl.php?api='.$api;
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_HEADER, FALSE); 
	curl_setopt($ch, CURLOPT_NOBODY, FALSE); // remove body 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
	$head = curl_exec($ch); 
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
	curl_close($ch);\
	print_r($head);
}else{
	echo 'You need to enable "allow url fopen" or "curl" to use this plugin. Your current PHP version is ' . PHP_VERSION . "\n";
	exit;
}

$data = json_decode($data);

#if (count($data) > 0) {
	
	if(isset($_POST['Submit'])){
		
		$table_name = $wpdb->prefix . "clictracker_keywords";
		$wplt_db_version = get_option('wplikntrackr_db_version', 0);
		$charset_collate = '';
		if( $wpdb->has_cap( 'collation' ) ){
			if( !empty($wpdb->charset) )
			  $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			if( !empty($wpdb->collate) )
			  $charset_collate .= " COLLATE $wpdb->collate";
		}
		//Create database if database is not exist
		if ((int) $wplt_db_version == 0) {
			if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
				$sql = "CREATE TABLE $table_name (
							id int(11) NOT NULL auto_increment,
							keyword_name VARCHAR( 200 ) NOT NULL ,
							slug_name VARCHAR( 200 ) NOT NULL ,
							firstname VARCHAR( 120 ) NOT NULL ,
							linkid int( 11 ) NOT NULL ,
							PRIMARY KEY  (id)
						) {$charset_collate} ;";
	
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($sql);
			}
		}
		
		$keywords = $_POST['keyword_name'];
		$count = 0;
		foreach($keywords as $key => $keywords){
			if($keywords != ''){
				$id = $_POST['idkey'][$count];
				$url = $_POST['urlname'][$count];
				savekeywords($keywords,$id,$table_name,$url,$_POST['ownersname']);
				$count++;
			}
		}
	}
	$table_name = $wpdb->prefix . "clictracker_keywords";
	$keywds = getkeywords($table_name);
	foreach($keywds as $key => $keyswords ){
		$js .= 'jQuery("#keyword_name_'.$keyswords->linkid.'").val("'.$keyswords->keyword_name.'");';
	}
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		<?php echo $js;?>		
	});
</script>
        <?php print_r($data); ?>
        
<?php
#}
?>
