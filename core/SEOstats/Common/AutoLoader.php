<?php
namespace SEOstats\Common;
class AutoLoader{
  protected $namespace='';
  protected $path='';
  public function __construct($namespace,$path){$this->namespace=ltrim($namespace,'\\');$this->path=rtrim($path,'/\\').DIRECTORY_SEPARATOR;}
  public function load($className){$class=ltrim($className,'\\');if(strpos($class,$this->namespace)!==0)return false;$nsparts=explode('\\',$class);$class=array_pop($nsparts);$nsparts[]='';$path=$this->path.implode(DIRECTORY_SEPARATOR,$nsparts);$path.=str_replace('_',DIRECTORY_SEPARATOR,$class).'.php';if(!is_readable($path))return false;require$path;return class_exists($className,false);}
  public function register(){return spl_autoload_register(array($this,'load'));}
  public function unregister(){return spl_autoload_unregister(array($this,'load'));}
}
