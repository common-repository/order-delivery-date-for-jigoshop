jQuery(document).ready(function(){

	//jQuery("#e_deliverydate").attr("class","text hasDatepick intra-field-label");

	jQuery("#e_deliverydate").width("150px");

	var formats = ["MM d, yy","MM d, yy"];

	jQuery("#e_deliverydate").val("").datepicker({dateFormat: formats[1], minDate:1});

	jQuery("#e_deliverydate").parent().append("<small style='font-size:10px;'>We will try our best to deliver your order on the specified date</small>");

});

