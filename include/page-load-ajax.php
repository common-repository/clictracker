<?php 
$wpconfig = realpath('../../../../wp-config.php');
if (!file_exists($wpconfig)) { exit('Could not find wp-config.php.'); }
	require_once($wpconfig);
	require_once(ABSPATH.'/wp-admin/admin.php');
	require(ABSPATH . WPINC . '/pluggable.php');
	if(isset($_GET['pageshow'])){
?>
  
<?php
	}

if(isset($_GET['sharebutton'])){
	//$post = linktrkr_post_page();
	$whathteid = clictrakerr_postlickfetch('id = '.$_GET['sharebutton']);
	
	$x = clictrakerr_shareme($whathteid->pageid,1);	
	
?>

<div class="divsection round">ShareMe Settings</div>
<p>Description here</p>
<div style="width:476px; float:left">
  <table cellspacing="0" cellpadding="0" align="center" class="data-page"  width="100%">
    <tbody>
      <tr>
        <td width="160">Popup Frequency</td>
        <td><select class="select"  name="frequency" id="frequency">
            <option <?php if($x->frequency == 1){?> selected="selected" <?php }?> value="1">Once per visit</option>
            <option <?php if($x->frequency == 2){?> selected="selected" <?php }?> value="2">Random popup</option>
            <option <?php if($x->frequency == 3){?> selected="selected" <?php }?> value="3">Every refresh</option>
          </select></td>
      </tr>
      <tr>
        <td>Google Circles ID</td>
        <td><input type="text" size="35" value="<?php echo $x->googlecircles?>" id="googlecircles" class="input" /></td>
      </tr>
      <tr>
        <td>Default Message</td>
        <td><input type="text" size="35" value="<?php echo $x->defaultmessage?>" id="defaultmessage" class="input" /></td>
      </tr>
      <tr>
        <td>Keep data after disable</td>
        <td><input type="checkbox" class="onoffbtn" value="1"  <?php if($x->disabledata == 1 ){?> checked="checked"<?php }?> name="disabledata"/></td>
      </tr>
      <tr>
        <td>Plugin HTML</td>
        <td><textarea class="input wysiwyg" id="pluginhtml" cols="45" rows="5"><?php echo $x->pluginhtml ?></textarea></td>
      </tr>
      <tr>
        <td>Email width</td>
        <td><input type="text" size="35" value="<?php echo $x->emailadd?>" id="emailadd" class="input number" /></td>
      </tr>
      <tr>
        <td>Email height</td>
        <td><input type="text" size="35" value="<?php echo $x->emailheigh?>" id="emailheigh" class="input number" /></td>
      </tr>
      <tr>
        <td>Email HTML</td>
        <td><textarea  class="input" rows="5" cols="45" id="emailhtml"><?php echo $x->emailhtml?></textarea></td>
      </tr>
    </tbody>
  </table>
  <div class="data-sections round">FancyBox Options</div>
  <table cellspacing="0" cellpadding="0" align="center" class="data-page"  width="100%">
    <tbody>
      <tr>
        <td>Width</td>
        <td><input type="text" value="<?php echo $x->fancybox_width?>" id="fancybox_width" class="input  number" /></td>
      </tr>
      <tr>
        <td>Height</td>
        <td><input type="text" value="<?php echo $x->fancybox_height?>" id="fancybox_height" class="input number" /></td>
      </tr>
      <tr>
        <td>Overlay color</td>
        <td><input type="text" id="fancybox_color" readonly="readonly" value="<?php if($x->fancybox_color == ''){ echo 'fff'; }else{echo $x->fancybox_color;} ?>" class="color_picker" /></td>
      </tr>
    </tbody>
  </table>
</div>
<div style="float:right; width:253px">
  <div class="inside">
    <h4>Enable popups for current post :
      <input type="checkbox" <?php if($x->enablepost == 1 ){?> checked="checked" <?php }?> name="enablepost" value="1" id="enablepost">
    </h4>
    <table width="100%">
      <tbody>
        <tr>
          <td><label for="facebook">Facebook &nbsp;</label></td>
          <td><input type="checkbox" <?php if($x->facebook == 1 ){?> checked="checked"<?php }?> name="facebook" value="1" id="facebook"></td>
        </tr>
        <tr>
          <td><label for="twitter">Twitter &nbsp;</label></td>
          <td><input type="checkbox" <?php if($x->twitter == 1 ){?> checked="checked"<?php }?> name="twitter" value="1" id="twitter"></td>
        </tr>
        <tr>
          <td><label for="google">Google+ &nbsp;</label></td>
          <td><input type="checkbox" <?php if($x->google == 1 ){?> checked="checked"<?php }?> name="google" value="1" id="google"></td>
        </tr>
        <tr>
          <td><label for="googlecircles">Google Badges &nbsp;</label></td>
          <td><input type="checkbox" <?php if($x->googlecircleson == 1 ){?> checked="checked"<?php }?> name="googlecircleson" value="1" id="googlecircleson"></td>
        </tr>
        <tr>
          <td><label for="emailadddree">Mail Subscription &nbsp;</label></td>
          <td><input type="checkbox" <?php if($x->emailadddree == 1 ){?> checked="checked"<?php }?> name="emailadddree" value="1" id="emailadddree"></td>
        </tr>
        <tr>
          <td><label for="stumbleupon">Stumbleupon &nbsp;</label></td>
          <td><input type="checkbox" <?php if($x->stumbleupon == 1 ){?> checked="checked"<?php }?> name="stumbleupon" value="1" id="stumbleupon"></td>
        </tr>
        <tr>
          <td><label for="digg">Digg &nbsp;</label></td>
          <td><input type="checkbox" <?php if($x->digg == 1 ){?> checked="checked" <?php }?> name="digg" value="1" id="digg"></td>
        </tr>
        <?php /*?><tr>
          <td><label for="linkedin">Linkedin &nbsp;</label></td>
          <td><input type="checkbox" <?php if($x->linkedin == 1 ){?> checked="checked"<?php }?> name="linkedin" value="1" id="linkedin"></td>
        </tr><?php */?>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><label for="timedelay">Delay Time &nbsp;</label></td>
          <td><input type="text" style="text-align: center" size="5" maxlength="2" name="timedelay" value="<?php echo $x->timedelay?>" id="timedelay"></td>
        </tr>
        
        <tr>
          <td><label for="closeafter">Close After &nbsp;</label></td>
          <td><input type="text" style="text-align: center" size="5" maxlength="2" name="closeafter" value="<?php echo $x->closeafter?>" id="closeafter"></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td><label for="islockcontent">Lock Content &nbsp;</label></td>
          <td><input value="1" type="checkbox" <?php if($x->islockcontent == 1 ){?> checked="checked" <?php }?> name="islockcontent" id="islockcontent"></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td><label for="disable_exit">Enable Exit &nbsp;</label></td>
          <td><input <?php if($x->disable_exit == 1 ){?> checked="checked" <?php }?> value="1" type="checkbox" name="disable_exit" id="disable_exit"></td>
        </tr>
       
      </tbody>
    </table>
  </div>
</div>
<?php }

if(isset($_GET['fblike'])){
	$whathteid = clictrakerr_postlickfetch('id = '.$_GET['fblike']);
	$fb = clictrakerr_fblike_fetch($whathteid->pageid,1);
?>
<div class="divsection round">Facebook Like</div>
<p>Description here</p>
<table cellspacing="0" cellpadding="0" align="center" class="data-page"  width="100%">
    <tbody>
        <tr>
            <th align="left" colspan="2">&nbsp;</th>
        </tr>
        <tr>
            <td width="160">Width</td>
            <td><input class="input" size="35" type="text" value="<?php echo $fb->fbbox_width?>" id="fbbox_width" /></td>
        </tr>
        <tr>
            <td>Margin Top</td>
            <td><input class="input" size="35" type="text" value="<?php echo $fb->fbbox_margintop?>" id="fbbox_margintop" /></td>
        </tr>
        <tr>
            <td>Hidden Text</td>
            <td><textarea class="input" cols="45" rows="5" id="fb_text"><?php echo $fb->fb_text?></textarea></td>
        </tr>
    </tbody>
</table>
<?php
}

if(isset($_GET['cntlock'])){
	$whathteid = clictrakerr_postlickfetch('id = '.$_GET['cntlock']);
	$ct = clictrakerr_contentlocker_data($whathteid->pageid, 1);
?>
<div class="divsection round">Content Locker</div>
<p>Description here</p>
<div style="width:476px; float:left">
    <table cellspacing="0" cellpadding="0" align="center" class="data-page"  width="100%">
      <tbody>
        <tr>
        	<td>Title</td>
        	<td><input type="text" size="35" value="<?php echo $ct->thetitle?>" id="thetitle" class="input required" /></td>
        </tr>
        <tr>
        	<td>Text Top</td>
        	<td><textarea  class="input" rows="5" cols="45" id="texttop"><?php echo $ct->texttop?></textarea></td>
        </tr>
        <tr>
        	<td>Add url</td>
        	<td>
            <input style="padding:2px 13px" type="button" value="Añadir más enlaces [+]" class="submit addthisurl">
            <div id="space"></div>
            <div id="readydoom"></div>
            </td>
        </tr>
        
         <tr>
        	<td>Text Botton</td>
        	<td><textarea  class="input" cols="45" rows="5" id="textbotton"><?php echo $ct->textbtn?></textarea></td>
        </tr>
        <tr>
        	<td>Time to Lock</td>
        	<td><input type="text" size="35" value="<?php echo $ct->timelock?>" id="timelock" class="input number" />
            
            </td>
        </tr>
        
      </tbody>
    </table>
</div>
<div style="float:right; width:253px">
<table cellspacing="0" cellpadding="0" align="center" class="data-page"  width="100%">
    <tbody>
        <tr>
            <th align="left" colspan="2">Position</th>
        </tr>
        <tr>
            <th align="left" colspan="2">&nbsp;</th>
        </tr>
        <tr>
            <td>Width</td>
            <td><input type="text" value="<?php echo $ct->widthofpop?>" id="widthofpop" /></td>
        </tr>
        <tr style="display:none">
            <td>Height</td>
            <td><input type="text" value="<?php echo $ct->hightofpop?>" id="hightofpop" /></td>
        </tr>
        <tr>
            <td>Margin Top</td>
            <td><input type="text" value="<?php echo $ct->marginofpop?>" id="marginofpop" /></td>
        </tr>
    </tbody>
</table>
</div>
<?php
}
if(isset($_GET['urlist'])){
	$url = clictraker_contentlockrullist($_GET['urlist'],'pageid');
	$count = count($url);
	if($count == 0){
?>
<input type="hidden" name="theurl" class="input required url"  value="" id="addcontenurl" size="65">
<?php
	}else{
	foreach($url as $key => $rest){
?>
<div class="count_<?php echo $rest->id?>">
	<div id="space"></div>
    <input type="text" style="width:253px" value="<?php echo $rest->url?>" id="theurl" readonly="readonly" class="input" /> 
    <a href="javascript:void(0)" onclick="deleteme(this)" name="<?php echo $_GET['urlist']?>" id="<?php echo $rest->id?>">Delete</a></div>
<?php
	}
	}
}
?>