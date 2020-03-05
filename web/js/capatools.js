$(document).ready(function() {
    $(document).ready(function(data) {
        $("company_field").autocomplete({
            data: data
        });
    });

    $(document).ready(function() {
        $("input.autocomplete").autocomplete({
            data: {
                Apple: null,
                Microsoft: null,
                Google: "https://placehold.it/250x250"
            }
        });
    });
});
