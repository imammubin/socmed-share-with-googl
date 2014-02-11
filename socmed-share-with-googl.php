<?php

	/*

		Plugin Name: socmed share with goo.gl url shorterner
		Description: WordPress plugin for 
		Author: Imam Mubin
		Author URI: http://www.imammubin.com
		Plugin URI: https://github.com/imammubin/socmed-share-with-googl/archive/master.zip
		Version: 1.0

	*/

	function socmed_share_with_googl($content){
		global $post;
		if(is_single()) {
			$custom_content= writeButton();
 			return $custom_content.' '.$content.' '.$custom_content;
		}else{
	        return $content;
    	}
	}
	
	function writeButton(){
 		$url=GoogleURLShorterner(get_permalink());
		$socmedDiv='';
		$socmedDiv.='<div id="socMedShareWithGoogl">';

 			$socmedDiv.='<div class="fb">';
 			$socmedDiv.='<div class="fb-like" data-href="'.$url.'"  data-layout="button_count"   data-show-faces="false" data-send="false"></div>';
 			$socmedDiv.='</div>';
			
 			$socmedDiv.='<div class="tw">';
 			$socmedDiv.='<a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$url.'">Tweet</a>';
 			$socmedDiv.='</div>';
			
 			$socmedDiv.='<div class="gp">';
 			$socmedDiv.='<g:plusone size="medium" href="'.$url.'"></g:plusone>';
 			$socmedDiv.='</div>';

		$socmedDiv.='</div>';
		$socmedDiv.=socmed_share_with_googl_css();
		
		return $socmedDiv;

	}
	
	function socmed_share_with_googl_css(){
		$css='
			<style>
				#socMedShareWithGoogl{ display:table; background:#ccc; width:100%; padding:0px; max-width:100%; overflow:hidden; }
				#socMedShareWithGoogl .fb,#socMedShareWithGoogl .tw,#socMedShareWithGoogl .gp{ float:left; margin:5px; width:80px; padding: 4px 0px 0px 5px;}
			</style>
        ';
		return $css;
	}

	function GoogleURLShorterner($url)
	{
	   $curlHandle = curl_init();
 	   curl_setopt($curlHandle, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
	   curl_setopt($curlHandle, CURLOPT_HEADER, 0);
	   curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
 	   curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
 	   curl_setopt($curlHandle, CURLOPT_POSTFIELDS, '{"longUrl":"'.$url.'"}');
	   curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
	   curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
 	   curl_setopt($curlHandle, CURLOPT_POST, 1);
 	   $content = curl_exec($curlHandle);

	   $data = json_decode($content);
	   return $data->id;
	}
	
	add_filter('the_content', 'socmed_share_with_googl');
 	
?>
