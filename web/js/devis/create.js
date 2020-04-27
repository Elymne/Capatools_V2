$(() => {
    $(".dynamicform_wrapper").on("afterInsert", (e, item) => {
        $(".picker").each(function () {
            $(this).datepicker({
                dateFormat: "dd-mm-yy",
            });
        });

        var maxPriceHt = $(".priceHt").val();
        console.log(maxPriceHt);
    });

    $(".dynamicform_wrapper").on("afterDelete", (e, item) => {
        $(".dob").each(function () {
            $(this).removeClass("hasDatepicker").datepicker({
                dateFormat: "dd/mm/yy",
                yearRange: "1925:+0",
                maxDate: "-1D",
                changeMonth: true,
                changeYear: true,
            });
        });
    });
});
