jQuery(document).ready(function() {
	jQuery("#pageblockloaddata").html('Loading data...');
	jQuery("#pageblockloaddata").load("../wp-content/plugins/clictracker/include/dataload.php?load=true", function(response, status, xhr) {
		errorhandlerjs();
		
		jQuery("#newpage").click(function(){
			ajaxcall('true');
		});
		
		jQuery(".editmode").click(function(){
			ajaxcall( jQuery(this).attr('id') );
		});
		
		jQuery(".deletethecontentblock").click(function(){
			//alert( jQuery(this).attr('id') );
			if (confirm("Are you sure you want to delete this record?")) {
				deletedata(jQuery(this).attr('id'));
				jQuery("#ajax_rape_"+jQuery(this).attr('id')).fadeOut('slow');
			}
		})
	});
});

function errorhandlerjs(){
	if (status == "error") {
		var msg = "Sorry but there was an error: ";
		jQuery("#error").html(msg + xhr.status + " " + xhr.statusText);
	}
}

function deletedata(ID){
	jQuery.ajax({
		type: "POST",
		url: "../wp-content/plugins/clictracker/include/savepost.php",
		data: "deletedata="+ID
	
	});
}

function ajaxcall(str){
		
		jQuery("#success").html('<div class="loading"></div>');
		jQuery("#success").load("../wp-content/plugins/clictracker/include/page-lock.php?add="+str, function(response, status, xhr) {
			
			if(str != 'true'){
				var loadselect = jQuery('input:radio[name=contentlock]:checked').val();
				grrr = str;
				if(loadselect == 1){
					whichclick('fblike','cntlock', str);
				}
				if(loadselect == 2){
					whichclick('fblike','fblike', str);
				}
				if(loadselect == 3){
					whichclick('fblike','sharebutton', str);
				}
			}else{
				grrr = 0;
			}
			
			jQuery(".fbshare").click(function(){
				whichclick('fblike','fblike', grrr);
			});
			
			jQuery(".shareme").click(function(){
				whichclick('fblike','sharebutton', grrr);
			});
			
			jQuery(".cntlock").click(function(){
				addurlforcontenlocker();
				whichclick('fblike','cntlock', grrr);
			});
			
			reporterror();
		});
		
		jQuery('#selectpage').dialog({
			autoOpen	: true,
			width		: 800,
			resizable	: false,
			modal		: true,
			buttons		: {
				"Save"	: function(){
					var contentlock	= jQuery('input:radio[name=contentlock]:checked').val();
					var pageselect	= jQuery('#pageselect').val();
					
					if(contentlock == 1){
						if(!isUrl(jQuery('#theurl').val())){
								alert('No url found, please add atlest one url..');
								return false;
						}
						
						if(isNaN(jQuery('#timelock').val())){
							alert('\'Time to Lock\' is invalid number, please try again..');
							return false;
						}
						if(isNaN(jQuery('#widthofpop').val())){
							alert('\'Width\' is invalid number, please try again..');
							return false;
						}
						if(isNaN(jQuery('#marginofpop').val())){
							alert('\'Top Margin\' is invalid number, please try again..');
							return false;
						}
						savecontentlocker(pageselect);
						
					}else if(contentlock == 2){
						if(isNaN(jQuery('#fbbox_width').val())){
							alert('\'Width\' is invalid number, please try again..');
							return false;
						}
						if(isNaN(jQuery('#fbbox_margintop').val())){
							alert('\'Top Margin\' is invalid number, please try again..');
							return false;
						}
						savefacebooklike(pageselect);
					}else{
						if(isNaN(jQuery('#emailadd').val())){
							alert('\'Email width\' is invalid number, please try again..');
							return false;
						}
						
						if(isNaN(jQuery('#fancybox_width').val())){
							alert('\'Width\' is invalid number, please try again..');
							return false;
						}
						if(isNaN(jQuery('#fancybox_height').val())){
							alert('\'Height\' is invalid number, please try again..');
							return false;
						}
						if(isNaN(jQuery('#timedelay').val())){
							alert('\'Time Delay\' is invalid number, please try again..');
							return false;
						}
						if(isNaN(jQuery('#closeafter').val())){
							alert('\'Close After\' is invalid number, please try again..');
							return false;
						}
						sharemefunction(pageselect);
					}
					
					savepage();
					
					jQuery("#selectpage").dialog("close");
					
					jQuery("#pageblockloaddata").html('Loading data...');
					jQuery("#pageblockloaddata").load("../wp-content/plugins/clictracker/include/dataload.php?load=true", function(response, status, xhr) {
						errorhandlerjs();
						jQuery(".editmode").click(function(){
							ajaxcall( jQuery(this).attr('id') );
						});
						
						jQuery(".deletethecontentblock").click(function(){
							//alert( jQuery(this).attr('id') );
							if (confirm("Are you sure you want to delete this record?")) {
								deletedata(jQuery(this).attr('id'));
								jQuery("#ajax_rape_"+jQuery(this).attr('id')).fadeOut('slow');
							}
						})
					});
						
				},
				"Close"	: function(){
					jQuery("#selectpage").dialog("close");
				}
			}
		});
}

function savefacebooklike(generalid){
	var fbbox_width 	= jQuery('#fbbox_width').val();
	var fbbox_margintop = jQuery('#fbbox_margintop').val();
	var fb_text 		= jQuery('#fb_text').val();
	
	jQuery.ajax({
		type: "POST",
		url: "../wp-content/plugins/clictracker/include/savepost.php",
		data: "fbbox_generalid="+generalid+"&fbbox_width="+fbbox_width+"&fbbox_margintop="+fbbox_margintop+"&fb_text="+fb_text+"&status=1&whereclose=0"
	
	});
}

function sharemefunction(idstr){
	
	var pageselect 		= jQuery('#pageselect').val();
	var frequency 		= jQuery('#frequency').val();
	var googlecircles 	= jQuery('#googlecircles').val();
	var defaultmessage 	= jQuery('#defaultmessage').val();
	var disabledata 	= jQuery('input:checked[name=disabledata]:checked').val();
	var pluginhtml 	= jQuery('#pluginhtml').val();
	var emailadd 	= jQuery('#emailadd').val();
	var emailheigh 	= jQuery('#emailheigh').val();
	var emailhtml 	= jQuery('#emailhtml').val();
	var fancybox_width 	= jQuery('#fancybox_width').val();
	var fancybox_height	= jQuery('#fancybox_height').val();
	var fancybox_color 	= jQuery('#fancybox_color').val();
	//pops
	var enablepost 	= jQuery('input:checked[name=enablepost]:checked').val();
	var facebook 	= jQuery('input:checked[name=facebook]:checked').val();
	var twitter 	= jQuery('input:checked[name=twitter]:checked').val();
	
	var google 		= jQuery('input:checked[name=google]:checked').val();
	var googlecircleson 	= jQuery('input:checked[name=googlecircleson]:checked').val();
	var emailadddree 	= jQuery('input:checked[name=emailadddree]:checked').val();
	var stumbleupon 	= jQuery('input:checked[name=stumbleupon]:checked').val();
	var digg 		= jQuery('input:checked[name=digg]:checked').val();
	var linkedin 	= jQuery('input:checked[name=linkedin]:checked').val();
	var timedelay 	= jQuery('#timedelay').val();
	var closeafter 	= jQuery('#closeafter').val();
	var islockcontent 	= jQuery('input:checked[name=islockcontent]:checked').val();
	var disable_exit 	= jQuery('input:checked[name=disable_exit]:checked').val();
	
	jQuery.ajax({
		type: "POST",
		url: "../wp-content/plugins/clictracker/include/savepost.php",
		data: "theidsave="+idstr+"&pageselect="+pageselect+"&frequency="+frequency+"&googlecircles="+googlecircles+"&defaultmessage="+defaultmessage+"&disabledata="+disabledata+"&pluginhtml="+pluginhtml+"&emailadd="+emailadd+"&emailheigh="+emailheigh+"&emailhtml="+emailhtml+"&fancybox_width="+fancybox_width+"&fancybox_height="+fancybox_height+"&fancybox_color="+fancybox_color+"&enablepost="+enablepost+"&facebook="+facebook+"&twitter="+twitter+"&google="+google+"&googlecircleson="+googlecircleson+"&emailadddree="+emailadddree+"&stumbleupon="+stumbleupon+"&digg="+digg+"&linkedin="+linkedin+"&timedelay="+timedelay+"&closeafter="+closeafter+"&islockcontent="+islockcontent+"&disable_exit="+disable_exit+"&status=1&whereclose=0"
	
	});
}

function savecontentlocker(generalid){
	var thetitle 		= jQuery('#thetitle').val();
	var texttop 		= jQuery('#texttop').val();
	var addcontenurl 	= jQuery('#addcontenurl').val();
	var textbtn 		= jQuery('#textbotton').val();
	var timelock 		= jQuery('#timelock').val();
	
	var widthofpop 		= jQuery('#widthofpop').val();
	var hightofpop 		= jQuery('#hightofpop').val();
	var marginofpop		= jQuery('#marginofpop').val();
	
	jQuery.ajax({
		type: "POST",
		url: "../wp-content/plugins/clictracker/include/savepost.php",
		data: "wheretheidgoes="+generalid+"&thetitle="+thetitle+"&texttop="+texttop+"&addcontenurl="+addcontenurl+"&textbtn="+textbtn+"&timelock="+timelock+"&widthofpop="+widthofpop+"&hightofpop="+hightofpop+"&marginofpop="+marginofpop+"&status=1&whereclose=0"
	
	});
}

function whichclick(loadmethod, getmethod, id){
	
	jQuery("#"+loadmethod).html('<div class="loading"></div>');
	jQuery("#"+loadmethod).load("../wp-content/plugins/clictracker/include/page-load-ajax.php?"+getmethod+"="+id, function(response, status, xhr) {
		addurlforcontenlocker();
		reporterror();
		jQuery("#readydoom").load("../wp-content/plugins/clictracker/include/page-load-ajax.php?urlist="+jQuery('#pageselect').val());
	});
}

function savepage(){
	var pageid = jQuery('#pageselect').val();
	var lockid = jQuery('input:radio[name=contentlock]:checked').val();
	jQuery.ajax({
		type: "POST",
		url: "../wp-content/plugins/clictracker/include/savepost.php",
		data: "pageid="+pageid+"&lockid="+lockid
	
	});
}

function addurlforcontenlocker(){
	jQuery(".addthisurl").click(function(){
	var pageid	= jQuery('#pageselect').val();
	
	
		jQuery('#lockurladd').dialog({
			autoOpen	: true,
			width		: 350,
			resizable	: false,
			modal		: true,
			buttons		: {
				"Save"	: function(){
					
					if(isUrl(jQuery(".theurl").val())){
						
						jQuery.ajax({
							type: "POST",
							url: "../wp-content/plugins/clictracker/include/savepost.php",
							data: "contentlockurl="+jQuery(".theurl").val()+"&thegenid="+pageid+"&table=pageid"
	
						});
						jQuery("#readydoom").load("../wp-content/plugins/clictracker/include/page-load-ajax.php?urlist="+pageid);
						jQuery('#lockurladd').dialog('close');
						
					}else{
						alert('Invalid Url, Please try again...');
					}
					
					},
				"Close"	: function(){
					jQuery('#lockurladd').dialog('close');
				}
			}		
		});
		
	});
}

function deleteme(id){

	jQuery.ajax({
		type: "POST",
		url: "../wp-content/plugins/clictracker/include/savepost.php",
		data: "deletemycontenturl="+id.id

	});
	jQuery("#readydoom").load("../wp-content/plugins/clictracker/include/page-load-ajax.php?urlist="+id.name);
}

function isUrl(s) {
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	return regexp.test(s);
}

function reporterror(){
	if (status == "error") {
		var msg = "Sorry but there was an error: ";
		jQuery("#error").html(msg + xhr.status + " " + xhr.statusText);
	}
}