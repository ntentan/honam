<?php 
foreach($array as $key => $value){
    print "{$value} {$value->unescape()} $key \n";
}
print "{$array['first']} {$array['first']->unescape()} \n";
print (isset($array['second']) ? 'second found' : 'second not found') . "\n";
$array['new'] = "<p>A new paragraph</p>";
print "{$array['new']} {$array['new']->unescape()} \n";
$array[] = "<p>A zero paragraph</p>";
print "{$array[0]} {$array[0]->unescape()} \n";
?>

