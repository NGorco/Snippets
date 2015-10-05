function toggleQl(){
	if($("#settings #ql").is(':checked')){
			setInSt('quickdesk_quicklogin','true');
		}else{
			setInSt('quickdesk_quicklogin','false');
		}
}