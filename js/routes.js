window.KWP.router = Backbone.Router.extend({
	routes: {
		'' : 'getStarted',
		'get-started' : 'getStarted',
		'have-account' : 'haveAccount',
		'social' : 'social'
	},
	getStarted: function ( ) {
		if(window.KWP.confid === '' && window.KWP.pubid === ''){
			new window.KWP.views.gettingStarted;
		}else{
			window.kwpRouter.navigate('social', {trigger: true});
		} 
	},
	haveAccount: function ( ) {
		if(window.KWP.confid === '' && window.KWP.pubid === ''){
			new window.KWP.views.haveAccount;
		}else{
			window.kwpRouter.navigate('social', {trigger: true});
		}
	},
	social: function ( ) {
		if(window.KWP.confid === '' && window.KWP.pubid === ''){
			window.kwpRouter.navigate('get-started', {trigger: true});
		}else{
			new window.KWP.views.social;
		}
	}
});