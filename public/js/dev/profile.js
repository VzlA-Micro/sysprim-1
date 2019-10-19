
$(document).ready(function() {
    $("#user_form").hide();
    $("#btn-edit").click(function(e) {
        e.preventDefault();
        console.log("Hello world");
        $("#user_info").hide();
        $("#user_form").show();
        $("#btn-edit").hide();
    });   
});