
<?php
/*
Plugin Name: View
Plugin URI: https://shop.com/
Description: plugin view page
Version: 1.0.0
Author: Rick
Author URI: https://lionteck.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: view
*/
function bindText($text,$attrs){
	$reg='/{{+[A-Za-z_]+}}/';
	preg_match_all($reg, $text, $matches);


	for($x=0;$x<count($matches[0]);$x++){
		$name_attr=substr($matches[0][$x],2,strlen($matches[0][$x])-4);
		if(isset($attrs[$name_attr])){
			$text=str_replace($matches[0][$x],$attrs[$name_attr],$text);
		}
	}
	return $text;
}

function returnBindPage($pachage, $path, $attrs=array()){
	$html = file_get_contents(plugin_dir_path( __FILE__ ).'html/'.$path);
	$attrs['default_url'] = $pachage;
	$attrs['random'] = rand(1,1000000);
	return bindText($html,$attrs);
}


function returnBindPageVue($url_plugin,$path_dir, $father,$components, $attrs=array()){
	$html = file_get_contents($path_dir.'assets/html/'.$father.".html");
	$text_component="";
	$attrs['default_url'] = $url_plugin;
	$attrs['home_url'] = home_url();
	$attrs['random'] = rand(1,1000000);
	
	foreach($components as $component){
		$attrs['name_component']=$component;
		
		$text_component.=bindText(file_get_contents($path_dir.'assets/html/components/'.$component.".html"),$attrs);
	}
	$attrs['name_component']=$father;
	$father_text= bindText($html,$attrs);
	$js_parent='<script src="'.$url_plugin.'assets/js/'.$father.'.js?ver='.rand(1,1000000).'"></script>';
	return $father_text.$text_component.$js_parent;
}



function returnBindPagePlugin($url_plugin,$path_dir, $path, $attrs=array()){
	$html = file_get_contents($path_dir.'assets/html/'.$path);
	$attrs['default_url'] = $url_plugin;
	$attrs['home_url'] = home_url();
	$attrs['random'] = rand(1,1000000);
	return bindText($html,$attrs);
}


