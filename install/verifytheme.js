!(function($){
	"use strict";
  jQuery(document).ready(function($){
    $('#Import_Pack_Container').on('click', '.__action-import-demo', function(e){
			e.stopImmediatePropagation();
      var confirm_message = verifytheme.message;
      var setting_page = verifytheme.setting_page;
  		if (confirm(confirm_message)) {
  			window.location.href = setting_page;
  		}
    })
  })
})(jQuery);
