<?php
	
class WPKruxTagService{

	public $controltagOnPage = false;

	function setTags ( ) {
		global $kx_confid;
		global $kx_pubid;

		// Set pubid in social widget if pubid is set.
		$jsCodeToSetPubid = "";
		if( $kx_pubid != null ){
			$jsCodeToSetPubid = "Krux.q.push(['_setPubid', '$kx_pubid']);";
		}

		$this->tags = array(
			"socialtag" => "<!-- BEGIN Krux Social Widget Tag -->
											<script>
											  window.Krux||((Krux=function(){Krux.q.push(arguments)}).q=[]);
											  $jsCodeToSetPubid
											  (function(){
											    var k = document.createElement('script');k.type = 'text/javascript';k.async = true;
											    var m,src = (m=location.href.match(/\bkwsrc=([^&]+)\b/))&&decodeURIComponent(m[1]);
											    k.src = src ||(location.protocol === 'https:' ? 'https:' : 'http:') + 
											      '//cdn.krxd.net/static/socialtag/widget.js';
											    var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(k,s); 
											  })();
											</script>
											<!-- END Krux Social Widget Tag -->",
			"controltag" => "<!-- BEGIN Krux Controltag - http://krux.com -->
							<script id='kxct_$kx_confid' data-version='async:1.5' type='text/javascript'> 
							window.Krux||((Krux=function(){Krux.q.push(arguments)}).q=[]);
							(function(){
								var k=document.createElement('script');k.type='text/javascript';k.async=true;var m,src=(m=location.href.match(/\bkxsrc=([^&]+)\b/))&&decodeURIComponent(m[1]);
								k.src=src||(location.protocol==='https:'?'https:':'http:')+'//cdn.krxd.net/controltag?confid=$kx_confid';
								var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(k,s);
							})();
							</script>
							<!-- END Krux Controltag -->"
		);
	}

	function socialtag ( ) {
		echo $this->tags['socialtag'];
	}

	function controltag ( ) {
		echo $this->tags['controltag'];
	}

	/*
		Puts tag on either admin or site pages
		Arguments:	@tagName -> key to which tag to put on page 
								(from array $this->tags)
					@location -> either 'admin' or 'pages'
	*/
	function putTagOnPage ($tagName, $location) {
		global $kx_menu_page;
		$tag = $this->tags[$tagName];
		if($location == 'admin'){
			add_action( 'admin_head-' . $kx_menu_page, array($this, $tagName) );	
		}else if($location == 'pages'){
			add_action('wp_head', array($this, $tagName));
		}
	}

	function controltagOnPage ( ) {
		return $this->controltagOnPage;
	}

	public function __construct ( ) {
		global $kx_confid;
		global $kx_pubid;
		$kx_confid = get_option("kx_confid");
		$kx_pubid = get_option("kx_pubid");
		$this->setTags();
		if( $kx_confid != null ){
			$this->putTagOnPage("controltag", "pages");
			$this->controltagOnPage = true;
		}	
	}	
}

?>