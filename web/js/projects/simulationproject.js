function updateprice(id) {
    var SelectMillePourcent =
        "#projectcreatemillestoneform-" + id + "-pourcentage";
    var pourcent = $(SelectMillePourcent).val();
    var SelectPrice = "#projectcreatemillestoneform-" + id + "-price";
    var price = ((TotalPrice * pourcent) / 100).toFixed(2);
    if (isNaN(price)) {
        price = 0;
    }
    $(SelectPrice).val(price);
}
function updatepourcent(id) {
    var SelectPrice = "#projectcreatemillestoneform-" + id + "-price";
    var price = $(SelectPrice).val();
    var SelectMillePourcent =
        "#projectcreatemillestoneform-" + id + "-pourcentage";
    var pourcent = ((price / TotalPrice) * 100).toFixed(2);
    if (isNaN(pourcent)) {
        pourcent = 0;
    }
    $(SelectMillePourcent).val(pourcent);
}
var pourcentage = "#projectcreatemillestoneform-" + 0 + "-pourcentage";
$(pourcentage).val(0);
$(pourcentage).on("input", function (e) {
    updateprice(0);
});

var price = "#projectcreatemillestoneform-" + 0 + "-price";
$(price).val(0);
$(price).on("input", function (e) {
    updatepourcent(0);
});
$(() => {
    $(".dynamicform_millestone").on("afterInsert", function (e, item) {
        //Recherche de l'index courrent
        var seletect = item.innerHTML;
        var regex = new RegExp("projectcreatemillestoneform-([0-9]*)-comment");
        var arr = regex.exec(seletect);
        var index = parseInt(arr[1]);

        var pourcentage =
            "#projectcreatemillestoneform-" + index + "-pourcentage";
        $(pourcentage).val(0);
        $(pourcentage).on("input", function (e) {
            updateprice(index);
        });

        var price = "#projectcreatemillestoneform-" + index + "-price";
        $(price).val(0);
        $(price).on("input", function (e) {
            updatepourcent(index);
        });
    });

    $(".dynamicform_wrapperLot").on("beforeDelete", function (e, item) {
        if (!confirm("Are you sure you want to delete this item?")) {
            return false;
        }

        return true;
    });

    $(".dynamicform_wrapperLot").on("limitReached", function (e, item) {
        alert("Limit reached");
    });
});
