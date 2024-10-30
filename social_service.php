<?php

class WPKruxSocialService {

	function catch_that_image($content) {
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
		if(count($matches[1]) > 0){
			$first_img = $matches[1][0];
		}
		return $first_img;
	}		

	function addSocialElementToPost ($content = '') {
		if(!is_page()){
			$postConfig = $this->api->getPostConfig();
			$sharingOpts = $this->api->getSharingOpts();
			$first_img = $this->catch_that_image($content);
			$socialEl = "<div style='float: left; width: 100%'><div class='krux_social' data-format='$postConfig->format' data-socnetworks='$sharingOpts' data-img='$first_img'></div></div>";		
			if($postConfig->placement == 'top'){
				return $socialEl . '<br /><br />' . $content;
			}else if($postConfig->placement == 'bottom'){
				return $content . '<br />' . $socialEl;
			}else if($postConfig->placement == 'both'){
				return $socialEl . '<br /><br />' . $content . '<br />' . $socialEl;			
			}
		}else{
			return $content;
		}
	}

	function addSocialElementToPage ($content) {
		if(is_page()){
			$pageConfig = $this->api->getPageConfig();
			$sharingOpts = $this->api->getSharingOpts();
			$socialEl = "<div style='float: left; width: 100%'><div class='krux_social' data-format='$pageConfig->format' data-socnetworks='$sharingOpts'></div></div>";	
			if($pageConfig->placement == 'top'){
				return $socialEl . '<br /><br />' . $content;
			}else if($pageConfig->placement == 'bottom'){
				return $content . '<br />' . $socialEl;
			}else if($pageConfig->placement == 'both'){
				return $socialEl . '<br /><br />' . $content . '<br />' . $socialEl;			
			}
		}else{
			return $content;
		}
	}

	function renderSocialToPost ( ) {
		if($this->api->isEnabled() && $this->api->postEnabled()){
			$this->tagService->putTagOnPage('socialtag', 'pages');
			add_action('the_content', array($this, 'addSocialElementToPost'));
		}
	}

	function renderSocialToPage ( ) {
		if($this->api->isEnabled()){
			$this->tagService->putTagOnPage('socialtag', 'pages');
			add_filter('the_content', array($this, 'addSocialElementToPage'));
		}
	}

	public function __construct ( ) {	
		$this->api = new WPKruxApi();
		$this->tagService = new WPKruxTagService();
		$this->renderSocialToPost();
		$this->renderSocialToPage();		
	}	

}

?>