$(document).ready(function () {

    $('#bt_hide_menu').click(function () {
		$('#fW_main_content').attr("class", "col-sm-12");
		$('#fW_lateral').css("display", "none");
		$('#bt_show_menu').css("display", "block");
    });

    $('#bt_show_menu').click(function () {
		$('#fW_main_content').attr("class", "col-sm-9");
		$('#fW_lateral').css("display", "block");
		$('#bt_show_menu').css("display", "none");
    });

});