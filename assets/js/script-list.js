var $j = jQuery.noConflict();

function openWindow($id) {
	var idMicroCopy = "#copy-microcopy-container-" + $id;
	$j('.microcopy-shortcode').hide();
	$j(idMicroCopy).show();
	return false;
}

function closeWindow($id) {
	var idMicroCopy = "#copy-microcopy-container-" + $id;
	$j(idMicroCopy).hide();
	return false;
}
