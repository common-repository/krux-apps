var WPKruxTest = {

	appendTestHtml: function ( ) {
		jQuery('#wpbody-content').append('<div id="krux-qunit"></div>');
		jQuery('#krux-qunit').append(
			'<h1 id="qunit-header">WordPress Krux Social Widget Unit Test</h1>' +
			'<h2 id="qunit-banner"></h2>' +
			'<div id="qunit-testrunner-toolbar"></div>' +
			'<h2 id="qunit-userAgent"></h2>' +
			'<ol id="qunit-tests"></ol>' +
			'<div id="qunit-fixture">test markup</div>'
		); 
	},

	startTests: function ( ) {
		test("ok test", function ( ) {
			ok(true, "true succeeds");
		});
	},

	init: function ( ) {
		this.appendTestHtml();
		this.startTests();
	}

}

jQuery(document).ready(function(){
	WPKruxTest.init();
});



