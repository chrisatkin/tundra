<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

for($i = 0; $i < $config[count($config) - 1]['column']; $i++)
	foreach($config as $item)
		if($item['column'] == $i + 1)
			$columns['columns'][$i][] = array(
				'id' => $item['id'],
				'title' => $item['title'],
				'order' => $item['order'],
				'type' => $item['type'],
				'column' => $item['column'],
				'refresh' => $item['refresh'],
				'config' => unserialize($item['config'])
			);

echo json_encode($columns);
//var_dump($columns);