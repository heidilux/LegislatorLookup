$(document).ready(function() {

    var method = "legislators";
    var filter = "query";
    var query = "";
    var url = "";

    // Set some values and text when making a dropdown selection
    $("#search-filter li a").on('click', function() {
        $("#search-btn").text($(this).text());
        $("#search-btn").val($(this).text());
        $("#filter").val($(this).data("filter"));
        $("#search-query").focus();

        method = $(this).data("method");
        filter = $(this).data("filter");
        query = $("#search-query").val();

    });
    
    // Construct the URI and 'click' it
    $(document).on('click', '#search-btn', function(e) {
        var valid = $("#search-query").valid();
        if (! valid) { return false; }
        e.preventDefault();
        query = $("#search-query").val();
        url = "/" + method + "/" + filter + "/" + query;

        window.location.href = url;
    });

    // 'click' the button if we hit enter
    $("#search-query").keypress(function(e) {
        var key = e.which;
        if (key == 13) {
            $("#search-btn").click();
            return false;
        }
    });

    $('#query-form').validate({ // initialize the plugin
        rules: {
            query: {
                required: true
            }
        }
    });

});