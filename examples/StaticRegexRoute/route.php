<?php
$route = [];
for($i=0;$i<999;++$i)
{
  $route[] = ['GET', '/'.$i];
}
return $route;