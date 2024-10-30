window.KWP = window.KWP || {};
window.KWP.views = window.KWP.views || {};

window.KWP.views.main = Backbone.View.extend({
	el: jQuery('#kwp-main-wrapper'),	
	content: jQuery('.kwp-content'),
	contentView: function (containerKey) {
		jQuery('.kwp-content').empty();
		var contentToShow = jQuery('#kwp' + containerKey).clone(true, true).show();
		jQuery('.kwp-content').html(contentToShow);
	}
});

window.KWP.views.gettingStarted = window.KWP.views.main.extend({
	initialize: function ( ) {		
		this.contentView('GettingStarted');
		jQuery('#kwpGetAccountLaterBtn').click(function(){
			var kruxUrl = "http://dataconsole.kruxdigital.com/social_widget_public?callback=?";
			var wpUrl = window.location.href;
			jQuery.getJSON(kruxUrl, { 'usersUrl' : wpUrl }, function (pubidObj) {
				var pubid = pubidObj.pubid;
				jQuery.ajax({
					type: "POST",
					url: "",
					data: { "pubid" : pubid },
					success: function ( ) {
							window.location.reload();
					}
				});
			}); 
		}); 
		jQuery('#kwpHaveAccountBtn').click(function(){
			window.kwpRouter.navigate('have-account', {trigger: true});
		});
	}
});

window.KWP.views.haveAccount = window.KWP.views.main.extend({
	initialize: function ( ) {
		this.contentView('HaveAccount');
	}
});






