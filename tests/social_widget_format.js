window.KWP = window.KWP || {};
window.KWP.tests = window.KWP.tests || {};
var casper = require('casper').create({
    verbose: true,
    timeout: 30000,
    stepTimeout: 10000,
    pageSettings: {
        localToRemoteUrlAccessEnabled: true,
        loadImages: true
    },
    onLoadError: function () {
        // Abort if there are any resource loading problems
        this.die('Failed to load ' + arguments[1], 1);
    },
	onError: function(self, m) {   // Any "error" level message will be written
		console.log('FATAL:' + m); // on the console output and PhantomJS will
		self.exit();               // terminate
    },
	colorizerType: 'Dummy'
});

var base = 'http://localhost:8888';

casper.start(base + '/wp-login.php', function(){
	casper.evaluate(function(){
		document.querySelector('#user_login').value = 'admin';
		document.querySelector('#user_pass').value = 'clamchowder';
		document.querySelector('#wp-submit').click();
	});
});

casper.then(function(){
	casper.test.assertExists('#toplevel_page_krux_apps a.toplevel_page_krux_apps', 'logged in and plugin is installed');
});

casper.then(function(){
	casper.evaluate(function(){
		document.querySelector('#toplevel_page_krux_apps a.toplevel_page_krux_apps').click();
	});
});

casper.thenOpen(base + '/wp-admin/admin.php?page=krux_apps#social', function() {
	casper.test.assertExists('#pagesFormat', 'pages format exists');
});

// Change widget format to single button.
casper.then(function(){
	casper.test.info("Change widget format on pages to single button");
	casper.evaluate(function(){
		jQuery('#pagesFormat').val('single_button').change();
	});	
	/*	
	casper.waitUntilVisible('#widgetContainerPages :nth-child(4)', function then() {	
		casper.test.pass("Changing pages format to single button working properly");
	}, function onTimeout() {
		this.test.fail("Changing pages format to single button not working");
	}); */
});

// Change widget format to big button.
casper.then(function(){
	casper.test.info("Change widget format on pages to big button");
	casper.evaluate(function(){
		jQuery('#pagesFormat').val('big_button').change();
	});
	// Make sure big button widget exists
	this.test.assertExists('#widgetContainerPages :nth-child(3)', 'big button exists');	
	/*	
	casper.waitUntilVisible('#widgetContainerPages :nth-child(3)', function then() {
		this.test.pass("Changing pages format to big button working properly");
	}, function onTimeout() {
		this.test.fail("Changing pages format to big button not working");
	}); */
});

// Change widget format to article horizontal.
casper.then(function(){
	casper.evaluate(function(){
		jQuery('#pagesFormat').val('article_horizontal').change();
	});	
	this.test.assertExists('#widgetContainerPages :nth-child(2)', 'article horizontal exists');
	//this.test.assertVisible('#widgetContainerPages :nth-child(2)');
});

// Change widget format to article vertical.
casper.then(function(){
	casper.evaluate(function(){
		jQuery('#pagesFormat').val('article_style').change();
	});	
	this.test.assertExists('#widgetContainerPages :nth-child(1)', 'article style exists');
	//this.test.assertVisible('#widgetContainerPages :nth-child(1)');	
});

casper.run(function(){
	this.test.renderResults(true);	
});
