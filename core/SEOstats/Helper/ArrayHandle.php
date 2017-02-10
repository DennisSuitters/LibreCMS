<?php
namespace SEOstats\Helper;
class ArrayHandle{
  protected$array;
  public function push($element){$this->array[]=$element;}
  public function setElement($key,$element){$this->array[$key]=$element;}
  public function count(){return count($this->array);}
  public function toArray(){return$this->array;}
}
