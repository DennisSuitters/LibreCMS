<?php
$routes=array(
	'error'				=>	array('front','error'),
	''					=>	array('front','index'),
	'index'				=>	array('front','index'),
	'article'			=>	array('front','article'),
	'portfolio'			=>	array('front','portfolio'),
	'bookings'			=>	array('front','bookings'),
	'events'			=>	array('front','events'),
	'news'				=>	array('front','news'),
	'testimonials'		=>	array('front','testimonials'),
	'inventory'			=>	array('front','inventory'),
	'services'			=>	array('front','services'),
	'gallery'			=>	array('front','gallery'),
	'contactus'			=>	array('front','contactus'),
	'cart'				=>	array('front','cart'),
	'sitemap'			=>	array('front','sitemap'),
	'tos'				=>	array('front','tos'),
	'login'				=>	array('front','login'),
	'logout'			=>	array('front','logout'),
	'proofs'			=>	array('front','proofs'),
	'search'			=>	array('front','search'),
	'sitemap'			=>	array('front','sitemap'),
	'settings'			=>	array('front','settings'),
	'admin/add'			=>	array('admin','add'),
	'admin/accounts'	=>	array('admin','accounts'),
	'admin/bookings'	=>	array('admin','bookings'),
	'admin/content'		=>	array('admin','content'),
	'admin/article'		=>	array('admin','article'),
	'admin/portfolio'	=>	array('admin','portfolio'),
	'admin/events'		=>	array('admin','events'),
	'admin/news'		=>	array('admin','news'),
	'admin/testimonials'=>	array('admin','testimonials'),
	'admin/inventory'	=>	array('admin','inventory'),
	'admin/services'	=>	array('admin','services'),
	'admin/gallery'		=>	array('admin','gallery'),
	'admin/proofs'		=>	array('admin','proofs'),
	'admin/media'		=>	array('admin','media'),
	'admin/messages'	=>	array('admin','messages'),
	'admin/orders'		=>	array('admin','orders'),
	'admin/preferences'	=>	array('admin','preferences'),
	'admin/proofs'		=>	array('admin','proofs'),
	'admin/search'		=>	array('admin','search'),
	'admin/statistics'	=>	array('admin','statistics'),
	'admin'				=>	array('admin','statistics'),
	'sitemap.xml'		=>	array('internal','sitemap'),
	'robots.txt'		=>	array('internal','robots'),
	'rss'				=>	array('internal','rss')
);
$route=new router();
$route->setRoutes($routes);
$route->routeURL(preg_replace("|/$|","",filter_input(INPUT_GET,'url',FILTER_SANITIZE_URL)));
function minify($txt){
	return preg_replace(array('/ {2,}/','/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'),array(' ',''),$txt);
}
class router{
	protected $route_match=false;
	protected $route_call=false;
	protected $route_call_args=false;
	protected $routes=array();
	public function __construct(){
	
	}
	public function setRoutes($routes){
		$this->routes=$routes;
	}
	public function routeURL($url=false){
		if(isset($this->routes[$url])){
			$this->route_match=$url;
			$this->route_call=$this->routes[$url];
			$this->callRoute();
			return true;
		}
		foreach($this->routes as $path=>$call){
			if(empty($path)){
				continue;
			}
			preg_match("|{$path}/(.*)$|i",$url,$match);
			if(!empty($match[1])){
				$this->route_match=$path;
				$this->route_call=$call;
				$this->route_call_args=explode("/",$match[1]);
				$this->callRoute();
				return true;
			}
		}
		if($this->route_call===false){
			if(!empty($this->routes['error'])){
				$this->route_call=$this->routes['error'];
				$this->callRoute();
				return true;
			}
		}
	}
	private function callRoute(){
		$call=$this->route_call;
		if(is_array($call)){
			$call_obj=new $call[0]();
			$call_obj->$call[1]($this->route_call_args);
		}else{
			$call($this->route_call_args);
		}
	}
}
