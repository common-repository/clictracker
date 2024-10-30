<?php
//error_reporting(0);
$wpconfig = realpath('../../../../wp-config.php');
if (!file_exists($wpconfig)) { exit('Could not find wp-config.php.'); }
require_once($wpconfig);
require_once(ABSPATH.'/wp-admin/admin.php');
global $wpdb;

if(isset($_GET['load'])){
	$page = clictrakerr_postlocklist();
?> 
 
  <table width="100%" cellspacing="0" class="widefat post fixed">
    <thead>
      <tr>
        <th class="manage-column" width="59%">Title</th>
        <th class="manage-column" width="41%">Option</th>
        
      </tr>
    </thead>
    <?php foreach($page as $key => $list){?>
    <tr id="ajax_rape_<?php echo $list->postid?>">
      <td id="linkname_<?php echo $list->postid?>">
      <strong><a title="Edit" href="javascript:void(0)" id="<?php echo $list->postid?>" class="editmode"><?php echo $list->post_title  ?></a></strong>
        <div class="row-actions">
        
        <span class="edit">
        <a href="javascript:void(0)" title="Edit this item" id="<?php echo $list->postid?>" class="editmode">Edit</a> | 
        </span>
        
        <span class="trash">
        <a href="javascript:void(0)" title="Move this item to the Trash" id="<?php echo $list->postid?>" class="submitdelete deletethecontentblock">Trash</a>
        </span>
        
       
        
        </div>
        </td>
      <td id="">
      <a href="javascript:void(0)" title="Edit this item" id="<?php echo $list->postid?>" class="editmode">Edit</a> | 
      <a href="javascript:void(0)" title="Move this item to the Trash" id="<?php echo $list->postid?>" class="submitdelete deletethecontentblock">Delete</a>
      </td>
     
    </tr>
    <?php }?>
  </table>
  
<?php }?>