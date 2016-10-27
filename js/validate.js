function isAllowedExtension($name, $arrAllowed){
	var $ext = $name.split('.').pop().toLowerCase();
	var $implode = $arrAllowed.join(',');
	if($.inArray($ext, $arrAllowed) == -1) {
		return false;
	}
	return true;
}