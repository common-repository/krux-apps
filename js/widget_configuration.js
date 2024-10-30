window.KWP.views.social = window.KWP.views.main.extend({
	getJson: function ( ) {

		jQuery.ajax({
			type: "GET",
			url: "",
			data: { "social_json" : 1 },
			success: function (data) {
				var socialJson = jQuery.parseJSON(data);
				var configStatus = socialJson["status"];
				var pages = socialJson["pages"];
				var posts = socialJson["posts"];

				var enabledIdxs = {
					"1" : 0,
					"0" : 1
				}
				jQuery("input:radio[name=enabled]")[enabledIdxs[configStatus]].checked = true;
				if(pages["status"] === "1"){
					jQuery('#locationPages').attr('checked', 'checked');
				}
				jQuery('#locationPages').data('widget', pages);
				if(posts["status"] === "1"){
					jQuery('#locationPosts').attr('checked', 'checked');
				}
				jQuery('#locationPosts').data('widget', posts);

				jQuery('#pagesFormat').val(pages["format"]).data('widget', pages).change();
				jQuery('#postsFormat').val(posts["format"]).data('widget', posts).change();
				var placementIdxs = {
					"top" : 0,
					"bottom" : 1,
					"both" : 2
				}
				jQuery('input:radio[name=page_placement]')[placementIdxs[pages["placement"]]].checked = true;
				jQuery('input:radio[name=post_placement]')[placementIdxs[posts["placement"]]].checked = true;
				jQuery('input:radio[name=page_placement]').data('widget', pages);
				jQuery('input:radio[name=post_placement]').data('widget', posts);
				var sharingOpts = socialJson["sharing_opts"][0]["sharing_opts"];
				sharingOpts = sharingOpts.split(",");
				var sharingOptsTable = {
					"facebook" : "fbchoice",
					"twitter" : "twchoice",
					"google" : "gpchoice",
					"pinterest" : "pinchoice",
					"linkedin" : "lichoice"
				}
				for(var i = 0; i < sharingOpts.length; i++){
					var socNet = sharingOpts[i].replace(/ /g,'');
					var choiceId = sharingOptsTable[socNet];
					var choiceInput = jQuery('#' + choiceId);
					choiceInput.attr('checked', 'checked');
				}
				jQuery('#fbchoice').change();
			}
		});
	},
	actions: function ( ) {

		var getShareChoicesStr = function ( ) {
			var shareChoices = [];
			var sharingOptions = jQuery('.kwp-social-options input[type=checkbox]');
			for(var i = 0; i < sharingOptions.length; i++){
				var checked = sharingOptions[i].checked;
				if(checked){
					shareChoices.push(jQuery(sharingOptions[i]).val());
				}
			}
			var shareChoicesStr = shareChoices.join(',');
			return shareChoicesStr;
		};

		jQuery('input:radio[name=enabled]').change(function(){
			var newVal = jQuery(this).val();
			jQuery.ajax({
				type: 'POST',
				url: '/wp-admin/admin.php',
				data: { 'config_status' : newVal }
			});
		});
		jQuery('.locationChoice').change(function(){
			var postsData = jQuery(this).data('widget');
			jQuery.ajax({
				type: 'POST',
				url: '/wp-admin/admin.php',
				data: { 'location' : postsData }
			});
		});
		var formatIdxs = {
			'article_style' : 0,
			'article_horizontal' : 1,
			'big_button' : 2,
			'single_button' : 3
		};		
		jQuery('.format_choice').change(function(){
			var widgetData = jQuery(this).data('widget');
			var newFormat = jQuery(this).val();
			var dataLocation = jQuery(this).data('location');			
			jQuery('#widgetContainer' + dataLocation).children().css('display', 'none');			
			var idx = formatIdxs[newFormat];	
			window.KWP.tests = window.KWP.tests || {};
			window.KWP.tests.formatAjax = false; // for casperjs ajax testing
			jQuery.ajax({
				type: 'POST',
				url: '/wp-admin/admin.php',
				data: { 'widgetData' : widgetData, 'newFormat' : newFormat },
				success: function(data) {
					var widgetContainer = jQuery('#widgetContainer' + dataLocation);
					var widget = widgetContainer.children()[idx];
					jQuery(widget).css('display', 'block');						
					// signals to casperjs, ready for testing
					window.KWP.tests.formatReady = true; 
				}
			}); 
		});
		jQuery('.kwp-placement-wrapper input').change(function(){
			var widgetData = jQuery(this).data('widget');
			var newPlacement = jQuery(this).val();
			jQuery.ajax({
				type: 'POST',
				url: '/wp-admin/admin.php',
				data: { 'widgetData' : widgetData, 'newPlacement' : newPlacement },
				success: function (data) {
					window.console && console.log(data);
				}
			}); 
		});
		jQuery('.kwp-social-options input[type=checkbox]').change(function(){
			var $this = this;
			var choiceVal = jQuery(this).val();
	        var shareChoicesStr = getShareChoicesStr();
	        var widgets = jQuery('.krux_social');
	        for(var i = 0; i < widgets.length; i++){
	            var ww = widgets[i];
	            ww.setAttribute('data-socnetworks', shareChoicesStr);
	        }
	        window.KSW && KSW.editKruxSocWidget(widgets);
	        jQuery.ajax({
	        	type: 'POST',
	        	url: '/wp-admin/admin.php',
	        	data: { 'sharingOptions' : shareChoicesStr },
	        	success: function (data) {
	        		window.console && console.log(data);
	        	}
	        });
		});
	},
	checkIfHasAccount: function ( ) {
		/*	
				If there is a pubid, but no confid, then this publisher can either have
				an account or not. Make jsonp request to Krux to see if there is a confid
				associated with this pubid. If so, then add it to this plugin, so that 
				we can add the controltag on page, and give a message to login to Krux
				Apps. Otherwise, show the message to sign up.
		*/
		if (KWP.pubid !== '' && KWP.confid === ''){
			var url = "http://dataconsole.kruxdigital.com/krux_apps/confid_jsonp?pubid=" + KWP.pubid + "&callback=?";
			jQuery.getJSON(url, null, function (confidObj) {
				var confid = confidObj.confid;
				if (confid !== 'none'){
					jQuery.ajax({
						type: "POST",
						url: "",
						data: { "confid" : confid },
						success: function ( ) {
								window.location.reload();
						}
					});
				}else{
					jQuery('#signupMessage').show();
				}
			});
		}else if(KWP.confid !== ''){
			jQuery('#loginMessage').show();
		}
	},
	initialize: function ( ) {
		this.contentView('Social');
		this.getJson();
		this.actions();
		this.checkIfHasAccount();
	}
});
