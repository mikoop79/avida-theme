jQuery(document).ready(function() {
	jQuery("[id*=checkboxall]").click(function() {
		var status = this.checked;
		
		jQuery("[id*=checklist]").each(function() {
			this.checked = status;	
		});
	});
});