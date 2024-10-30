<?php 
$wpconfig = realpath('../../../../wp-config.php');
if (!file_exists($wpconfig)) { exit('Could not find wp-config.php.'); }
	require_once($wpconfig);
	require_once(ABSPATH.'/wp-admin/admin.php');
	require(ABSPATH . WPINC . '/pluggable.php');

if(isset($_GET['lood'])){

$page = clictrakerr_postlocklist();
?>

<table width="100%" cellspacing="0" class="widefat post fixed">
    <thead>
      <tr>
        <th class="manage-column" width="15%">Title</th>
        <th class="manage-column" width="35%">Author</th>
        <th class="manage-column" width="15%">Date</th>
      </tr>
    </thead>
    <?php foreach($page as $key => $list){?>
    <tr id="ajax_rape_<?php echo $records->id?>">
      <td id="linkname_<?php echo $records->id?>">
      <strong><a title="Edit" href="javascript:void(0)" id="<?php echo $list->postid?>" class="editmode"><?php echo $list->post_title  ?></a></strong>
        <div class="row-actions">
        
        <span class="edit">
        <a href="javascript:void(0)" title="Edit this item">Edit</a> | 
        </span>
        
        <span class="trash">
        <a href="javascript:void(0)" title="Move this item to the Trash" class="submitdelete">Trash</a> | 
        </span>
        
        <span class="view">
        <a href="javascript:void(0)" rel="permalink" title="View "Sample Page"">View</a>
        </span>
        
        </div>
        </td>
      <td id=""></td>
      <td>;;</td>
    </tr>
    <?php }?>
  </table>
  
<?php }
if(isset($_GET['add'])){
	if($_GET['add'] == 'true'){
		$value = "post_status = 'publish' and post_type = 'page' ";
		$page = clictrakerr_post_page("post_status = 'publish' and post_type = 'page'");
		$post = clictrakerr_post_page("post_status = 'publish' and post_type = 'post' ");
	}else{
		$post_lock = clictrakerr_postlickfetch('id = '.$_GET['add']);
		$post = clictrakerr_post_page("ID = '".$post_lock->pageid."' ");
		
		$thewhatx = $post[0];
		
	}
?>
<div id="changeloading">
<table cellspacing="0" cellpadding="0" align="center" class="data-page"  width="100%">
  <tbody>
    <tr>
      <td colspan="2"><div class="divsection round">Page / Post</div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="160">Select Page</td>
      <td>
      	<?php if($_GET['add'] == 'true'){?>
        <select class="select"  name="pageselect" id="pageselect" >
        
          <optgroup label="--Select Page--">
          <?php 
		  	foreach($page as $key => $pagelist):
			$x = clictrakerr_postlickfetch('pageid = '.$pagelist->ID);
			
			if($x->pageid != $pagelist->ID){
		  ?>
          <option value="<?php echo $pagelist->ID?>" <?php if($x->pageselect == $pagelist->ID){?> selected="selected" <?php }?>> <?php echo $pagelist->post_title?> </option>
          <?php 
			}
		  endforeach;?>
          </optgroup>
          
          <optgroup label="--Select Post--">
          <?php 
		  	foreach($post as $key => $postlist):
		  	$y = clictrakerr_postlickfetch('pageid = '.$postlist->ID);
			
			if($y->pageid != $postlist->ID){
		  ?>
          <option value="<?php echo $postlist->ID?>" <?php if($x->pageselect == $postlist->ID){?> selected="selected" <?php }?>> <?php echo $postlist->post_title?> </option>
          <?php 
			}
			endforeach;?>
          </optgroup>
        </select>
        <?php }else{?>
        	<input type="text" value="<?php echo $thewhatx->post_title;?>" readonly="readonly"  class="text"/>
            <input type="hidden" value="<?php echo $thewhatx->ID;?>" id="pageselect" />
        <?php }?>
        </td>
    </tr>
    <tr>
    
      <td colspan="2">
      <table cellspacing="0" cellpadding="0" align="center" class="data-page"  width="100%">
    <tbody>
<tr>

      <td colspan="2"><div class="divsection round">Content Lock</div></td>
    </tr>
     <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">
      <table cellspacing="0" style="width:100%" cellpadding="0" align="center" class="data-page">
          <tbody>
            <tr>
              <td colspan="2"> No description  yet...
                <div style="height:10px; visibility:hidden"></div></td>
            </tr>
            <tr>
              <td width="160">Select Lock Option:</td>
              <td>
              <label>
                  <input type="radio" name="contentlock" class="radio cntlock" <?php if($post_lock->lock_select == 1 ){?> checked="checked"<?php }?> value="1" />
                  Content Locker </label>
                <div style="clear:both"></div>
                <label>
                  <input type="radio" name="contentlock" class="radio fbshare" <?php if($post_lock->lock_select == 2){?> checked="checked"<?php }?> value="2" />
                  FB Like </label>
                <div style="clear:both"></div>
                <label>
                  <input type="radio" name="contentlock" class="radio shareme" <?php if($post_lock->lock_select == 3 ){?> checked="checked"<?php }?> value="3" />
                  ShareMe </label>
                <input type="hidden" id="hidethisbla" value="<?php echo $record->contentlock?>" />
                <div style="clear:both"></div>
              
              </td>
              
            </tr>
            </tbody>
            </table>
      
      </td>
    </tr>
    
            <tr>
            <td colspan="2">
            <div id="showcnt"></div>
                <div id="fblike"></div>
            </td>
          </tr>
          </tbody>
        </table>
        </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
  </tbody>
</table>
</div>
<?php }

?>