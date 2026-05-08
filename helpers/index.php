<?php
function getObj($obj) {
	return json_decode(json_encode($obj));
}

function getInfoPage($slug, $menu) {
	$info = "";
	foreach (getObj($menu) as $item) {
		if ($item->slug === $slug) {
			$info = $item;
		}
	}
	return	$info;
}
?>