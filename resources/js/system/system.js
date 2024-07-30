// Auto-close the success alert after 5 seconds
setTimeout(function () {
    $("#successAlert").alert('close');
}, 5000);

// Auto-close the danger alert after 5 seconds
setTimeout(function () {
    $("#dangerAlert").alert('close');
}, 5000);

/* -- START DELETE MODAL SCRIPT --*/
$(document).ready(function () {
    $(".delete-button").click(function () {
        var email = $(this).data("email");
        var actionUrl = $(this).data("actionurl");
        $("#confirmationText").text("Are you sure you want to delete user " + email + "?");
        $("#deleteForm").attr("action", actionUrl);
    });

});
/* -- END DELETE MODAL SCRIPT --*/