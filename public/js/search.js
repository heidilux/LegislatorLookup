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

        method = $(this).data("method");
        filter = $(this).data("filter");
        query = $("#search-query").val();

        switch (filter) {
            case 'query':
                $("#search-query").attr("placeholder", "First or Last name").focus();
                break;
            case 'zip':
                $("#search-query").attr("placeholder", "5 digit zipcode").focus();
                break;
            case 'state':
                $("#search-query").attr("placeholder", "2 letter abbreviation").focus();
                break;
        }

    });
    
    // Construct the URI and 'click' it
    $(document).on('click', '#search-btn', function(e) {
        var valid = $("#search-query").valid();
        if (! valid) { return false; }
        e.preventDefault();
        query = $("#search-query").val();

        // the 'state' filter requires that the abbr be uppercase
        query = (filter == 'state') ? query.toUpperCase() : query;

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

    // Initialize the validate plugin and set some formatting options
    $('#query-form').validate( {
        errorPlacement: function(error, element) {
            error.appendTo("#query-form");
        },
        errorElement: 'div',
        errorClass: 'validation-error',
        rules: {
            query: {
                required: true
            }
        }
    });

});