<?php

require 'Doom.php';
$v='ddasert.txt';
					$d= new datos($v);
					$d->porDefecto();
echo '<pre>wwwww';
print_r($d->adatos);
echo 'zzzzzz</pre>';


echo '<pre>ddddd';
print_r($d->getDatos());
echo 'fffff</pre>';

/* echo '<pre>2222wwwww';
print_r($d->adatos);
echo 'zzzzzz2222</pre>';
//$d->setUsuarion('dario','dario');

echo '<pre>';
print_r($d->adatos);
echo '</pre>';

echo '<pre>ddddd';
print_r($d->getDatos());
echo 'fffff</pre>';
*/
//$d->getDatos();
?>
