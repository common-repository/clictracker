<?php
$clictrackerclass = new clictracker();

function design_top(){
	$return .= '
				<div class="wrap" style="font-size:13px;">
				  <div class="icon32" id="icon-options-general">
					<br/>
				  </div>
				  <h2>Settings for Click Tracker Integration</h2>
				  <div id="clictracker">
					<p>This plugin will install the Track your site. </p>
				';	
	return $return;
}

function design_bottom(){
	$return .= '
				 </div>
				</div>
				';
	return $return;
}

function tracker_info(){
	
	global $wpdb;
	global $current_user;	
	$query = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."apicredintial " );
	return $query;
}

function clictraker_createdatabase(){
	global $wpdb;
	global $current_user;
	$general_share   	  = $wpdb->prefix . "clictraker_shareme";
	$contentlock     	  = $wpdb->prefix . "clictraker_contentlock";
	$fb_like_data		  = $wpdb->prefix . "clictraker_fblock";
	$postpockdata		  = $wpdb->prefix . "clictraker_postlock";
	$clictrakerlinks_table   = $wpdb->prefix . "contentlock_links";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		$sql = "CREATE TABLE {$general_share} (
			id int(11) NOT NULL auto_increment,
			generalid int(11) NOT NULL,
			pageselect int(11) NOT NULL,
			frequency int(11) NOT NULL,
			googlecircles varchar(120) NOT NULL,
			defaultmessage varchar(120) NOT NULL,
			disabledata int(11) NOT NULL,
			pluginhtml text NOT NULL,
			emailadd varchar(120) NOT NULL,
			emailheigh varchar(120) NOT NULL,
			emailhtml text NOT NULL,
			fancybox_width varchar(120) NOT NULL,
			fancybox_height varchar(120) NOT NULL,
			fancybox_color varchar(120) NOT NULL,
			enablepost int(2) NOT NULL,
			facebook int(2) NOT NULL,
			twitter int(2) NOT NULL,
			google int(2) NOT NULL,
			googlecircleson int(2) NOT NULL,
			emailadddree varchar(120) NOT NULL,
			stumbleupon int(2) NOT NULL,
			digg int(2) NOT NULL,
			linkedin int(2) NOT NULL,
			timedelay varchar(10) NOT NULL,
			closeafter varchar(10) NOT NULL,
			islockcontent int(2) NOT NULL,
			disable_exit int(2) NOT NULL,
			status int(2) NOT NULL,
			PRIMARY KEY  (id)
			) {$charset_collate};";
			
		dbDelta($sql);

	    /* Create/Upgrade Pretty Links Table */
    $sql = "CREATE TABLE {$contentlock} (
				id int(11) NOT NULL auto_increment,
				generalid int(11) NOT NULL,
				thetitle varchar(120) NOT NULL,
				texttop text NOT NULL,
				textbtn text NOT NULL,
				timelock int(11) NOT NULL,
				widthofpop varchar(120) NOT NULL,
				hightofpop varchar(120) NOT NULL,
				marginofpop varchar(120) NOT NULL,
				status int(2) NOT NULL,
				PRIMARY KEY  (id)
			) {$charset_collate} ;";
    
    dbDelta($sql);
	
	// create fb_likes_block
	$sql = "CREATE TABLE {$fb_like_data} (
				id INT NOT NULL auto_increment ,
				generalid INT NOT NULL ,
				fbbox_width VARCHAR( 120 ) NOT NULL ,
				fbbox_margintop VARCHAR( 120 ) NOT NULL ,
				fb_text TEXT NOT NULL ,
				status int(2) NOT NULL,
				PRIMARY KEY (id)
				) {$charset_collate} ;";
			
	dbDelta($sql);
	
    // create postlock
	$sql = "CREATE TABLE {$postpockdata} (
				id INT NOT NULL AUTO_INCREMENT ,
				pageid INT NOT NULL ,
				lock_select int(2) NOT NULL,
				PRIMARY KEY ( id ) 
				) {$charset_collate} ;";
			
	dbDelta($sql);
	
    /* Create/Upgrade Pretty Links Table */
    $sql = "CREATE TABLE {$clictrakerlinks_table} (
              id INT NOT NULL auto_increment,
              url TEXT NOT NULL,
			  pageid INT NOT NULL,
			  contentlocker int(1) default NULL,
             PRIMARY KEY (id)
            ) {$charset_collate};";
    
    dbDelta($sql);
	
}

function tracker_account_info_save(){
	
	global $wpdb;
	global $current_user;
		
	$table_name = $wpdb->prefix . "apicredintial";
	
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$sql = "CREATE TABLE ".$table_name." 
		(id mediumint(9) NOT NULL AUTO_INCREMENT,
		apicredintial varchar(100) NOT NULL,
		UNIQUE KEY id (id));";
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		$rows_affected = $wpdb->insert( $table_name, 
						 array( 'apicredintial' => ''.$_POST['api'].''));
		add_option("jal_db_version", $jal_db_version);
	}
		
	$myrows = $wpdb->get_results( "SELECT id FROM ".$wpdb->prefix."apicredintial" );
	$count = count($myrows);
		
	if($count == 0){
		$wpdb->insert( $wpdb->prefix.'apicredintial', 
		 array( 'apicredintial' => ''.$_POST['api'].''));
	}else{
		$wpdb->query("UPDATE ".$wpdb->prefix."apicredintial SET apicredintial = '".$_POST['api']."' ");
	}

}

function savekeywords($keywords,$id,$table_name,$url,$ownersname){
	global $wpdb, $post;
	
	$query = "SELECT linkid FROM ".$table_name." where linkid = ".$id."  ";
	$genid = $wpdb->get_row($query, OBJECT);
	$linkid = $genid->linkid;
	//for some reason, we need to delete the other records, katong wla na sa clictracker!!
	
	if(empty($linkid)){
		$wpdb->insert( $table_name, 
				array('keyword_name' => $keywords,
					  'linkid' 		=> $id,
					  'slug_name' 	=> $url,
					  'firstname'	=>  $ownersname));
	}else{
		$wpdb->query("UPDATE ".$table_name." SET keyword_name = '".$keywords."', slug_name = '".$url."', firstname = '".$ownersname."' where linkid = '".$id."' ");
	}
}

function getkeywords($table_name){
	global $wpdb, $post;
	$query = "SELECT * FROM ".$table_name."   ";
	$return = $wpdb->get_results($query, OBJECT);
	return $return;
}

function clictrakerr_postlocklist(){
	global $wpdb, $post;
	$query = "SELECT 
				a.id as postid,
				a.pageid,
				b.ID as ID,
				b.post_title 
			 from 
			 	".$wpdb->prefix."clictraker_postlock a 
			left join 
				".$wpdb->prefix."posts b 
			on 
				a.pageid = b.ID";
	$return = $wpdb->get_results($query, OBJECT);
	sleep(1);
	return $return;
}

function clictrakerr_post_page($postpage){
	global $wpdb, $post;
	$query = "SELECT ID,post_title FROM ".$wpdb->prefix."posts where ".$postpage." ";
	$return = $wpdb->get_results($query, OBJECT);
	return $return;
}

function clictrakerr_postlickfetch($where){
	global $wpdb, $post;
	$query = "SELECT * FROM ".$wpdb->prefix."clictraker_postlock where ".$where." ";
	$return = $wpdb->get_row($query, OBJECT);
	return $return;
}

function clictrakerr_shareme($id,$status){
	global $wpdb, $post;
	$query = "SELECT * FROM ".$wpdb->prefix."clictraker_shareme where generalid = ".(int)$id." and status = ".(int)$status." ";
	$return = $wpdb->get_row($query, OBJECT);
	return $return;
}

function clictrakerr_fblike_fetch($id,$status){
	global $wpdb, $post;
	$query = "SELECT * FROM ".$wpdb->prefix."clictraker_fblock where generalid = ".(int)$id." and status = ".(int)$status." ";
	$return = $wpdb->get_row($query, OBJECT);
	return $return;
}

function clictrakerr_contentlocker_data($id,$status){
	global $wpdb, $post;
	$query = "SELECT * FROM ".$wpdb->prefix."clictraker_contentlock where generalid = ".(int)$id." ";
	$return = $wpdb->get_row($query, OBJECT);
	return $return;
}

function clictraker_fblike_locker(){
	global $wpdb, $post;
	$query = "SELECT generalid FROM ".$wpdb->prefix."clictraker_fblock where generalid = ".(int)$_POST['fbbox_generalid']." and status != ".(int)$_POST['whereclose']." ";
	$genid = $wpdb->get_row($query, OBJECT);
	$thisid = $genid->generalid;
	if(empty($thisid)){
		$wpdb->insert( $wpdb->prefix."clictraker_fblock", 
				array( 'generalid'		=> $_POST['fbbox_generalid'],
					   'fbbox_width' 	=> $_POST['fbbox_width'],
					   'fbbox_margintop'=> $_POST['fbbox_margintop'],
					   'fb_text' 		=> $_POST['fb_text'],
					   'status'		=> $_POST['status']
					   ));
	}else{
		$wpdb->query("UPDATE ".$wpdb->prefix."clictraker_fblock 
					  SET
						fbbox_width 	= '".$_POST['fbbox_width']."',
					    fbbox_margintop	= '".$_POST['fbbox_margintop']."',
					    fb_text 		= '".$_POST['fb_text']."'
					  WHERE generalid = ".$_POST['fbbox_generalid']." and  status = ".$_POST['status']."");
	}
}

function clictraker_save_post_lock_page(){
	global $wpdb, $post;
	
	$query = "SELECT pageid FROM ".$wpdb->prefix."clictraker_postlock where pageid = ".(int)$_POST['pageid']." ";
	$genid = $wpdb->get_row($query, OBJECT);
	$thisid = $genid->pageid;
	if(empty($thisid)){
	
	$wpdb->insert( $wpdb->prefix."clictraker_postlock", 
			array('pageid' 		=> $_POST['pageid'],
				  'lock_select' => $_POST['lockid'] ));
	}else{
		$wpdb->query("UPDATE ".$wpdb->prefix."clictraker_postlock 
					  SET
					   lock_select 	= '".$_POST['lockid']."'
					  WHERE pageid = ".(int)$_POST['pageid']." ");
	}
}

function deletedata($ID){
	global $wpdb, $post;
	$wpdb->query("Delete from ".$wpdb->prefix."clictraker_postlock where id = ".(int)$ID." ");
}

function clictraker_contentlocker(){
	global $wpdb, $post;
	$query = "SELECT generalid FROM ".$wpdb->prefix."clictraker_contentlock where generalid = ".(int)$_POST['wheretheidgoes']." and status != ".(int)$_POST['whereclose']." ";
	$genid = $wpdb->get_row($query, OBJECT);
	$thisid = $genid->generalid;
	if(empty($thisid)){
		$wpdb->insert( $wpdb->prefix."clictraker_contentlock", 
				array( 'generalid'	=> $_POST['wheretheidgoes'],
					   'thetitle' 	=> $_POST['thetitle'],
					   'texttop' 	=> $_POST['texttop'],
					   'textbtn' 	=> $_POST['textbtn'],
					   'timelock' 	=> $_POST['timelock'],
					   'widthofpop' => $_POST['widthofpop'],
					   'hightofpop' => $_POST['hightofpop'],
					   'marginofpop'=> $_POST['marginofpop'],
					   'status'		=> $_POST['status']
					   ));
	}else{
		$wpdb->query("UPDATE ".$wpdb->prefix."clictraker_contentlock 
					  SET
						thetitle 	= '".$_POST['thetitle']."',
					   	texttop 	= '".$_POST['texttop']."',
					   	textbtn 	= '".$_POST['textbtn']."',
					   	timelock 	= '".$_POST['timelock']."',
					   	widthofpop 	= '".$_POST['widthofpop']."',
					   	marginofpop	= '".$_POST['marginofpop']."'
					  WHERE generalid = ".$_POST['wheretheidgoes']."
					  AND  status = ".$_POST['status']." ");
	}
	sleep(1);
}

function checkip(){
	$apicret = tracker_info();
	
	if(function_exists('curl_init')){
		$url = 'http://clictracker.com/geturl.php?ipadd='.$_SERVER['REMOTE_ADDR'].'&apicheck='.$apicret->apicredintial;;
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_HEADER, FALSE); 
		curl_setopt($ch, CURLOPT_NOBODY, FALSE); // remove body 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		$head = curl_exec($ch); 
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		curl_close($ch);
		return $head;
	}else{
		echo 'You need to enable "allow url fopen" or "curl" to use this plugin. Your current PHP version is ' . PHP_VERSION . "\n";
		exit;
	}
	
}

function clictraker_saveshareme(){
	global $wpdb, $post;
	$query = "SELECT generalid FROM ".$wpdb->prefix."clictraker_shareme where generalid = ".(int)$_POST['theidsave']." and status != ".(int)$_POST['whereclose']." ";
	$genid = $wpdb->get_row($query, OBJECT);
	$thisid = $genid->generalid;
	if(empty($thisid)){
		$wpdb->insert( $wpdb->prefix."clictraker_shareme", 
				array( 'generalid'		=> $_POST['theidsave'],
					   'pageselect' 	=> $_POST['pageselect'],
					   'frequency' 		=> $_POST['frequency'],
					   'googlecircles' 	=> $_POST['googlecircles'],
					   'defaultmessage' => $_POST['defaultmessage'],
					   'disabledata' 	=> $_POST['disabledata'],
					   'pluginhtml' 	=> $_POST['pluginhtml'],
					   'emailadd' 		=> $_POST['emailadd'],
					   'emailheigh' 	=> $_POST['emailheigh'],
					   'emailhtml' 		=> $_POST['emailhtml'],
					   'fancybox_width' => $_POST['fancybox_width'],
					   'fancybox_height' => $_POST['fancybox_height'],
					   'fancybox_color' => $_POST['fancybox_color'],
					   'enablepost' 	=> $_POST['enablepost'],
					   'facebook' 		=> $_POST['facebook'],
					   'twitter' 		=> $_POST['twitter'],
					   'google' 		=> $_POST['google'],
					   'googlecircleson' => $_POST['googlecircleson'],
					   'emailadddree' 	=> $_POST['emailadddree'],
					   'stumbleupon' 	=> $_POST['stumbleupon'],
					   'digg' 			=> $_POST['digg'],
					   'linkedin' 		=> $_POST['linkedin'],
					   'timedelay' 		=> $_POST['timedelay'],
					   'closeafter' 	=> $_POST['closeafter'],
					   'islockcontent' 	=> $_POST['islockcontent'],
					   'disable_exit' 	=> $_POST['disable_exit'],
					   'status'			=> $_POST['status']
					   ));
	}else{
		$wpdb->query("UPDATE ".$wpdb->prefix."clictraker_shareme 
					  SET
					   pageselect 	= '".$_POST['pageselect']."',
					   frequency 	= '".$_POST['frequency']."',
					   googlecircles = '".$_POST['googlecircles']."',
					   defaultmessage = '".$_POST['defaultmessage']."',
					   disabledata 	= '".$_POST['disabledata']."',
					   pluginhtml 	= '".$_POST['pluginhtml']."',
					   emailadd 	= '".$_POST['emailadd']."',
					   emailheigh 	= '".$_POST['emailheigh']."',
					   emailhtml 	= '".$_POST['emailhtml']."',
					   fancybox_width = '".$_POST['fancybox_width']."',
					   fancybox_height = '".$_POST['fancybox_height']."',
					   fancybox_color = '".$_POST['fancybox_color']."',
					   enablepost 	= '".$_POST['enablepost']."',
					   facebook 	= '".$_POST['facebook']."',
					   twitter 		= '".$_POST['twitter']."',
					   google 		= '".$_POST['google']."',
					   googlecircleson = '".$_POST['googlecircleson']."',
					   emailadddree = '".$_POST['emailadddree']."',
					   stumbleupon 	= '".$_POST['stumbleupon']."',
					   digg 		= '".$_POST['digg']."',
					   linkedin 	= '".$_POST['linkedin']."',
					   timedelay 	= '".$_POST['timedelay']."',
					   closeafter 	= '".$_POST['closeafter']."',
					   islockcontent 	= '".$_POST['islockcontent']."',
					   disable_exit 	= '".$_POST['disable_exit']."' 
					  WHERE generalid = ".(int)$_POST['theidsave']."
					  AND status 	= ".$_POST['status']."");
	}
}

function clictraker_contentlockrullist($id,$wherclose){
	global $wpdb, $post;
	$query = "SELECT * FROM ".$wpdb->prefix."contentlock_links where ".$wherclose." = ".(int)$id." and contentlocker = 1 " ;
	$return = $wpdb->get_results($query, OBJECT);
	return $return;
}

function clictraker_add_url($id,$url,$contelock,$tablename){
	global $wpdb, $post;
	$wpdb->insert( $wpdb->prefix."contentlock_links", 
			array( 'url'	=> $url,
				   'pageid'	=> $id,
				   'contentlocker' => $contelock ));
}

function clictraker_delete_url($id){
	global $wpdb, $post;
	$wpdb->query("Delete from ".$wpdb->prefix."contentlock_links where id = ".(int)$id." ");
}


function clictracker_fblike_fetch($id){
	global $wpdb, $post;
	$query = "SELECT * FROM ".$wpdb->prefix."clictraker_fblock where generalid = ".(int)$id." ";
	$return = $wpdb->get_row($query, OBJECT);
	return $return;
}

class clictracker {

    var $max;

 	function clictracker() {
        add_filter('the_content', array($this, 'the_contents'));
    }

    function the_contents($content) {
        global $wpdb, $post;

        if (is_home()) {
            $table_name = $wpdb->prefix . "clictracker_keywords";
			$this->max = (int) 3;
			$rows = $wpdb->get_results("SELECT * FROM {$table_name} WHERE keyword_name != '';");
		  
			if (count($rows) > 0) {
				$links = array();
				foreach ($rows as $value) {
					$keywords = explode(',', $value->keyword_name);
					foreach ($keywords as $keyword) {
						if (!$this->true_in_this_array(trim($keyword), $links) AND (trim($keyword) != ''))
							$links[] = array('id' => $value->lintrackr_id, 
											 'tracking' => $value->slug_name, 
											 'keyword' => trim($keyword),
											 'fname' => $value->firstname );
					}
				}
				
				shuffle($links);
				$skipallfilters = array();
				$skipallfilters = array_merge($skipallfilters, $this->skipallfilters($content, '<a', '</a>'));
				$skipallfilters = array_merge($skipallfilters, $this->skipallfilters($content, '<h1', '</h1>'));
				$skipallfilters = array_merge($skipallfilters, $this->skipallfilters($content, '<h2', '</h2>'));
				$skipallfilters = array_merge($skipallfilters, $this->skipallfilters($content, '<h3', '</h3>'));
				$skipallfilters = array_merge($skipallfilters, $this->skipallfilters($content, '<h4', '</h4>'));
				$skipallfilters = array_merge($skipallfilters, $this->skipallfilters($content, '<h5', '</h5>'));
				$skipallfilters = array_merge($skipallfilters, $this->skipallfilters($content, '<code', '</code>'));
				$skipallfilters = array_merge($skipallfilters, $this->skipallfilters($content, '<object', '</object>'));
				$skipallfilters = array_merge($skipallfilters, $this->skipallfilters($content, '<script', '</script>'));
				$skipallfilters = array_merge($skipallfilters, $this->skipallfilters($content, '<embed', '>'));
				$skipallfilters = array_merge($skipallfilters, $this->skipallfilters($content, '[tube]', '[/tube]'));

				$matchesAllKeyword = array();
				foreach ($links as $key => $val) {
					if(trim($val['keyword']) != ''){
						$pattern = '%\b' . trim($val['keyword']) . '\b%i';
						preg_match_all($pattern, $content, $matches[$key], PREG_OFFSET_CAPTURE);
						shuffle($matches[$key][0]);
						$ltMaxLinksKeyword = get_option('ltMaxLinksKeyword') ? get_option('ltMaxLinksKeyword') : 1;
						array_splice($matches[$key][0], $ltMaxLinksKeyword);
						$matchesAllKeyword = array_merge($matchesAllKeyword, $matches[$key]);
					}
				}
				
				$matchesAllLinks = array();
				foreach ($matchesAllKeyword as $k => $matches) {
					foreach ($matches as $key => $value) {
						if ($this->validulr($value[1], $skipallfilters)) {
							if ($this->noTooverlap($value[1], $matchesAllLinks)) {
								$matchesAllLinks[] = array(
									'link_index' => $k,
									'keyword' => $value[0],
									'start' => $value[1],
									'fname' => $val['fname']
								);
							}
						}
					}
				}
				
				shuffle($matchesAllLinks);
				$no_follow = get_option('ltCbNoFollow') ? ' rel="nofollow" ' : '';
				foreach ($matchesAllLinks as $key => $value) {
					$link = '<a target="_blank" href="http://'.$value['fname'].'.clictracker.com/'.$links[$value['link_index']]['tracking'].'">' . $value['keyword'] . '</a>';
					$content = substr_replace($content, $link, $matchesAllLinks[$key]['start'], strlen($value['keyword']));
					$matchesAllLinks = $this->startupdating($matchesAllLinks, $matchesAllLinks[$key]['start'], strlen($link) - strlen($value['keyword']));
					$this->max--;
					if ($this->max <= 0)
						break;
				}
			}
        }
		if ( !is_home()) {
			//check if the content block
			$this->contentblock( $post->ID );
		}
        return $content;
    }

    function contentblock( $id ){
		 global $wpdb, $post;
		 $rows = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix . "clictraker_postlock WHERE pageid = ".(int)$id." ");
		 if($rows){
			return $this->clictracker_contentlock($rows->pageid,$rows->lock_select);			
		 }
	}
	
	function clictracker_contentlock($pageID,$lockSelected){
		switch($lockSelected){
		  case 1:
			return $this->clictracker_content_lock($pageID,$lockSelected);
			break;
		  case 2:
			return $this->clictracker_fblock($pageID,$lockSelected);
			break;
		  case 3:
			return $this->clictracker_share($pageID,$lockSelected);
			break;
	  	}
	}
	
	function clictracker_share($id,$robot){
		
		define(IMAGES_URL , plugins_url('clictracker/assets/img'));
		$sharethis = clictrakerr_shareme($id,1);
		$plugins .= "<link  href='".plugins_url('clictracker/assets/css/jquery.fancybox-1.3.1.css')."' rel='stylesheet' type='text/css' />";
		if($sharethis->google == 1){
			$plugins .= "
			<div style='float: left; height: 49px;  width: 45px;'>
				<!-- Place this tag where you want the +1 button to render -->
				<div id='gplusid' style='float: left;'><g:plusone annotation=\"none\"  callback='showButton'></g:plusone></div>
				
				<!-- Place this render call where appropriate -->
				<script type=\"text/javascript\">
				  (function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/plusone.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				  })();
				</script>
				</div>";
		}
		
	   if($sharethis->emailadd == ''){
		   $poreturnW = 500;
		   $poreturnH = 200;
	   }else{
		   $poreturnW = $sharethis->emailadd;
		   $poreturnH = $sharethis->emailheigh;
	   }
	   
		if($sharethis->emailadddree == 1)
		$plugins .= '<a href="'. plugins_url('clictracker/email.php') .'/email.php?id='.$id.'" onclick="return openPopup(this, '.$poreturnW.', '.$poreturnH.');"><img class="wpshareme_image" src="' . IMAGES_URL . '/email.png"  /></a>';
		
		if($sharethis->googlecircleson == 1)
		$plugins .= '<link href="https://plus.google.com/' . $general['googlecircles'] . '" rel="publisher" />
					<a href="https://plus.google.com/' . $general['googlecircles'] . '?prsrc=3" style="text-decoration:none;" onclick="return openPopup(this, 320, 260)"><img class="wpshareme_image" src="' . IMAGES_URL . '/google-plus.png"  /></a>';
	
		if($sharethis->facebook == 1)
		$plugins .= '<a href="http://www.facebook.com/sharer.php?u=' . get_permalink() . '&t=' . $urllike . '" onclick="return openPopup(this);"><img class="wpshareme_image" src="' . IMAGES_URL . '/facebook-share.png" /></a>';
		
		if($sharethis->twitter == 1)
		$plugins .= '<a href="http://twitter.com/share?text=' . $urllike . '" onclick="return openPopup(this);"><img style="margin-right:0" class="wpshareme_image" src="' . IMAGES_URL . '/twitter-share.png" /></a>';
	
		if($sharethis->stumbleupon == 1)
		$plugins2 .= '
		   <span class="badge1" id="stumbleupon_span" style="height: 18px; margin-top: 2px; float:left;
	width: 74px;" onclick="showButton();">
				<ul class="suHostedBadge" style="margin: 0; padding:0;">
				   <li><a target="_blank" onclick="return openPopup(this, 640, 400);" href="http://www.stumbleupon.com/submit?url='. urlencode($urllike) .'" class="logo">StumbleUpon</a></li>
				   <li><a target="_blank" onclick="return openPopup(this, 640, 400);" href="http://www.stumbleupon.com/submit?url='. urlencode($urllike) .'" class="count">
						 <span>Submit</span>
					   </a>
				   </li>
				</ul>
			</span>';
		
		if($sharethis->digg == 1)
		$plugins2 .= '<a class="DiggThisButton DiggCompact" href="http://digg.com/submit?url=' . $urllike .'&amp;title='. urlencode(get_the_title()).'"></a>';
		
		$plugins2 .= '<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>';
		$plugins2 .= '<script type="IN/Share" data-url="'. $urllike .'" data-counter="right"></script>';
		
		$plugins .= "<script type=\"text/javascript\">
					(function() {
						var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
						s.type = 'text/javascript';
						s.async = true;
						s.src = 'http://widgets.digg.com/buttons.js';
						s1.parentNode.insertBefore(s, s1);
					})();
					</script>";
		
		$closeAfter = $general['closeafter'];
		
		$height_text = 'style="height:' . (244 + $sharethis->fancybox_width - 400) . 'px;"';
		$height_content = 'style="height: '. (350 + $sharethis->fancybox_height - 400) . 'px;"';
		
		if($sharethis->fancybox_width == ''){
			$widthser = 500;
		}else{
			$widthser = $sharethis->fancybox_width;
		}
		
		if($sharethis->closeafter == ''){
			$closebysec = 20;
		}else{
			$closebysec = $sharethis->closeafter;
		}
		
		$content .= '
			<a id="wpshareme_link" href="#wpshareme" style="display: none;">WPShareME</a>
			<style>
				#wpshareme_content {
					background:#'.$sharethis->fancybox_color.' !important;
				}';
				if($sharethis->twitter != 1 && $sharethis->facebook != 1 && $sharethis->googlecircleson != 1 && $sharethis->google != 1 && $sharethis->emailadddree != 1){
					$content .= '#wpshareme_icons2{
									height: 73px !important;
								}';
				}
		$content .= '
				</style>
				
				<script type="text/javascript">
				function checktime(){
					
				}
				
				$().ready(function(){
					$("#dialoggrrr").dialog({
						autoOpen	: true,
						width		: '.$widthser.',
						resizable	: false,
						modal		: true,
						buttons		: {
							
						}
					});
				});
				
				function showButton()
				{
					jQuery(".ui-dialog-titlebar").css(\'display\', \'inline\');
				}
				
				 function openPopup(element, w, h) {
					 jQuery("#fancybox-close").css("display", "inline");
					 
					var width  = 575,
						height = 400,
						left   = (jQuery(window).width()  - width)  / 2,
						top    = (jQuery(window).height() - height) / 2,
						url    = element.href;
						
						if(w != 0)
							width = w;
						if(h != 0)
							height = h;	
							
						var opts   = \'status=1\' +
								 \',width=\'  + width  +
								 \',height=\' + height +
								 \',top=\'    + top    +
								 \',left=\'   + left;
								 
					
					
					window.open(url, \'twitte\', opts);
					"  . $closeonclick . "
					return false;
				}
				function closeWindow()
				{
					$("#dialoggrrr").dialog(\'close\');
				}
				setTimeout(closeWindow, '.$closebysec.'000);
				</script>
				<div style="display:none">
				  <div style="display: block;" id="dialoggrrr">
					<div id="wpshareme" style="width: ' . $sharethis->fancybox_width .'px; height: ' . $sharethis->fancybox_height . 'px;">
					  <div id="wpshareme_content" style="min-height: 100%;height: auto !important;height: 100%;margin: 0 auto -129px;">
						<div id="wpshareme_text">
						  <div style="height:100%; overflow:auto; overflow-x:hidden; -ms-overflow-x: hidden; ">' . stripslashes($sharethis->pluginhtml) .'</div>
						</div>
						<div style="height:190px;"></div>
					  </div>
					  <div>
						<div id="wpshareme_icons2"  onclick="showButton()" style="width:310px; height:30px; margin:0 auto;"> '. $plugins2 .' </div>
						<div id="wpshareme_icons" style="float: none; clear:both; text-align: center;"  onclick="showButton();">
						  <div style="margin:0 auto; width: 354px;"> ' . $plugins . '
							<div style="clear:both;"></div>
						  </div>
						</div>
						
						<div id="wpshareme_footer" style="height:50px;background-image:url(' . IMAGES_URL . '/footer.png);">S h a r e &nbsp; t h i s &nbsp; w i t h &nbsp; o t h e r s';
						  $content .= '<br/>
						  or wait <span class="wpshare_counter">'.$closebysec.'</span> seconds';
						  $content .= '</div>
					  </div>
					</div>
				  </div>
				</div>';
		echo $content;
	}
	
	function clictracker_content_lock($id,$robot){
		$list = clictrakerr_contentlocker_data($id,0);
		$theurls = clictraker_contentlockrullist($id,'pageid');
		$myFile = "wp-content/plugins/clictracker/js/lock_script/links.txt";
		
		$fh = fopen($myFile, 'w') or die("can't open file");
		foreach($theurls as $key => $urlnasd){
			$xplode = explode('http://',$urlnasd->url);
			$xplode = explode('.',$xplode[1]);
			$stringData = $xplode[0]."\n";
			fwrite($fh, $stringData);
			$stringData = $urlnasd->url."\n";
			fwrite($fh, $stringData);
		}
		fclose($fh);
		
			if($list->widthofpop == ''){
				$wposition = 800;
			}else{
				$wposition = $list->widthofpop;
			}
			if($list->marginofpop == ''){
				$vposition = 100;
			}else{
				$vposition = $list->marginofpop;
			}
			if($list->timelock == ''){
				$timelock = 4;
			}else{
				$timelock = $list->timelock;
			}
		
		$plugins = '
			<style>
				#blocker_centerPane{
					width:'.$wposition.'px !important;
					top:'.$vposition.'px !important;
				}
			</style>';
// add some codition if ip address already exist
		$check = checkip();
		if($check != 1 ){
			$plugins .= '<script type="text/javascript">';			
			$plugins .= '
					setInterval(function() {
						jQuery("#xxxxxxx").load("'.plugins_url('clictracker/include/savepost.php?checkip=true').'" , function(response, status, xhr) {
							
						  if (response == 1) {
							window[_0xe25b[172]](unblockContent,timeout_in_seconds_from_click*1000);
						  }
						});
						
					}, 1500);
				';
				
			$plugins .= "var blocker_headline = '".$list->thetitle."';";
			$plugins .= "var blocker_instructionalText = '".$list->texttop."';";
			$plugins .= "var cpaconvert_files_path = '". plugins_url('clictracker/js/lock_script/')."';" ;
			$plugins .= "var blocker_footerText = '".$list->textbtn."';";
			$plugins .= "var timeout_in_seconds_from_click = ".$timelock.";";
			$plugins .= "var panel_vertical_position = ".$vposition.";";
			$plugins .= "var panel_width = ".$wposition.";";
			$plugins .= "
			
			</script>";
			$plugins .= '<script type="text/javascript" src="'.plugins_url('clictracker/js/lock_script/lock.js').'"></script>';
			
			if(isset($_GET['get'])){
				$plugins .= '<script type="text/javascript">';
				$plugins .= 'window[_0xe25b[172]](unblockContent,timeout_in_seconds_from_click*1000);';
				$plugins .= "</script>";
			}
			echo '<div id="xxxxxxx" style="display:"></div>';
		echo $plugins;
		}
	}
	
	function clictracker_fblock($pageID,$lockSelected){
		$urllike = get_permalink( $post->ID );
		$fb = clictracker_fblike_fetch($pageID);
		$buffer = $fb->fb_text;
		
		$pop .= '
			<style>
				.ui-dialog{
					overflow: hidden !important;
					top:'.$fb->fbbox_margintop.'px !important;
				}
			</style>';
			
		$pop .= '<div style="display:none">';
		$pop .= '<div id="fblikethis" style="border:1px solid #000; background:#FFF; padding:16px;">';
		$pop .= $fb->fb_text;	
		$pop .= '<div style="height:20px;visibility:hidden"></div>';
		$pop .= clictracker_encsdsdst_text(1,$pageID,$urllike);
		$pop .= '<div id="fb-root"></div>';	
		$pop .= '<div style="height:40px;visibility:hidden"></div></div></div>';
		$pop .= '<script src="http://connect.facebook.net/en_US/all.js#appId=132905226727817&amp;xfbml=1"></script>';
		$widthparam = $fb->fbbox_width;
		$pop .= clictracker_ajax_load_me($widthparam , $pageID);	
		echo $pop;
	}

	function startupdating($matchesAllLinks, $start, $length) {
        foreach ($matchesAllLinks as $key => $value) {
            if ($value['start'] > $start) {
                $matchesAllLinks[$key]['start'] = $value['start'] + $length;
            }
        }
        return $matchesAllLinks;
    }

    function validulr($value, $skipallfilters=array()) {
        foreach ($skipallfilters as $val) {
            if (($value > $val['start']) AND ($value < $val['end'])) {
                return false;
                break;
            }
        }
        return true;
    }

    function noTooverlap($value, $matchesAllLinks = array()){
        foreach ($matchesAllLinks as $val) {
            if (($value >= $val['start']) AND ($value <= ($val['start'] + strlen($val['keyword'])))) {
                return false;
                break;
            }
        }
        return true;
    }

    function skipallfilters($content, $open_tag, $close_tag) {
        $i = 0;
        $open_tag_pos = true;
        $result = array();
        while ($open_tag_pos) {
            $open_tag_pos = stripos($content, $open_tag, $i);
            if ($open_tag_pos) {
                $close_tag_pos = stripos($content, $close_tag, $open_tag_pos + 1);
                $i = $close_tag_pos + 1;
                $result[] = array('start' => $open_tag_pos, 'end' => $close_tag_pos + strlen($close_tag));
            }
        }

        return $result;
    }

    function true_in_this_array($value, $array, $case_insensitive = false) {
        foreach ($array as $item) {
            if (is_array($item))
                $ret = $this->true_in_this_array($value, $item, $case_insensitive);
            else
                $ret = ($case_insensitive) ? strtolower($item) == $value : $item == $value;
            if ($ret
                )return $ret;
        }
        return false;
    }

}

function clictracker_ajax_load_me($widthparam , $id){
	$cookie_domain = $_SERVER['HTTP_HOST'];
    $cookie_domain = preg_replace('#(www*\.)#si', '', $cookie_domain);
	
	if($widthparam == ''){
		$thewidth = 500;
	}else{
		$thewidth = $widthparam;
	}
	
	$plugin .= <<<JS_EOF
<script>
    var cookie_domain = '$cookie_domain';

    if (typeof jQuery.cookie == 'undefined') {
        jQuery.cookie = function(name, value, options) {
            if (typeof value != 'undefined') {

			jQuery('#fblikethis').dialog('close');
			
                options = options || {};
                if (value === null) {
                    value = '';
                    options.expires = -1;
                }
                var expires = '';
                if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
                    var date;
                    if (typeof options.expires == 'number') {
                        date = new Date();
                        date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
                    } else {
                        date = options.expires;
                    }
                    expires = '; expires=' + date.toUTCString();
                }
                
                var path = options.path ? '; path=' + (options.path) : '';
                var domain = options.domain ? '; domain=' + (options.domain) : '';
                var secure = options.secure ? '; secure' : '';
                document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
            } else {
                var cookieValue = null;
				jQuery('#fblikethis').dialog({
						autoOpen	: true,
						width		: $thewidth,
						resizable	: false,
						modal		: true,
						closeOnEscape: false,
						buttons		: {
							
						}		
				});
                if (document.cookie && document.cookie != '') {
                    var cookies = document.cookie.split(';');
                    for (var i = 0; i < cookies.length; i++) {
                        var cookie = jQuery.trim(cookies[i]);
                        if (cookie.substring(0, name.length + 1) == (name + '=')) {
                            cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                            break;
                        }
                    }
					
                }
                return cookieValue;
            }
        };
     }

     function like_gate_decrypt(str, pwd) {
        return (str + '').replace(/[a-z]/gi, function (s) {
            return String.fromCharCode(s.charCodeAt(0) + (s.toLowerCase() < 'n' ? 13 : -13));
        });
     }

     function like_gate_handle_event(pars) {
       pars = pars || {};
       if (pars.event == 'unlike') {
			jQuery('#fblikethis').dialog({
				autoOpen	: true,
				width		: $thewidth,
				resizable	: false,
				modal		: true,
				closeOnEscape: false,
				buttons		: {
				}		
			});
            jQuery.cookie('like_gate_lp_{$id}', null, { path: '/' });
            return true;
       }

       jQuery.cookie('like_gate_lp_{$id}', 1, { expires: 365, path: '/' }); 
       var decrypted_hidden = like_gate_decrypt(jQuery('.like-gate').html());
       jQuery('.like-gate-result').html(decrypted_hidden).show('slow');
	   jQuery('#fblikethis').dialog('close');
     }

     jQuery(document).ready(function() {
        var like_status = jQuery.cookie('like_gate_lp_{$id}');
        if (like_status > 0) {
            like_gate_handle_event({event:'like'});
        }
     });

	 window.fbAsyncInit = function() {
		FB.Event.subscribe('edge.create', function(href, widget) {
           like_gate_handle_event({
                event: 'like',
                url : href,
                widget: widget,
                '' : ''
           });
		});

		FB.Event.subscribe('edge.remove', function(href, widget) {
           like_gate_handle_event({event:'unlike'});           
		});
     };
</script>
JS_EOF;
return $plugin;
}

function clictracker_encsdsdst_text($buffer,$id,$urllike) {

    $style = 'style="display:none;"';
	$post_url = $urllike;
    global $post;  
    $post_url = get_permalink($post->ID); // the user will like this

    $like_box =<<<LIKE_BOX
<!-- like-gate-result -->
<div id='like-gate-result' class='like-gate-result' $style></div>
<!-- /like-gate-result -->

<div class='like_gate_like_container' post_url="$post_url" post_id='{$id}'>
    <fb:like href="{$post_url}" layout="standard" show-faces="false" width="" action="like" colorscheme="light"></fb:like>
</div>
LIKE_BOX;
    
    $buffer = $like_box . "<!-- like-gate-secret id:{$id} -->\n<div $style class='like-gate like-gate-secret' post_id='{$id}' post_url='$post_url'>"
        . str_rot13($buffer) . "ds\n</div>\n<!-- /like-gate-secret -->\n"; // . var_export($post, 1);
    
    return $buffer;
}

?>