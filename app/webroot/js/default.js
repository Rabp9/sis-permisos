$(document).ready(function() {
    // Quitar link a active
    var active = $("ul.breadcrumb li.active a").html();
    $("ul.breadcrumb li.active").html(active).removeClass("active");
    
})