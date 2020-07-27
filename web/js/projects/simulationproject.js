let SelectTOtalPrice = "#project-sellingprice";
//let = $(SelectTOtalPrice).val();
let TotalPrice = Number(
    $(SelectTOtalPrice)
        .val()
        .replace(",", ".")
        .replace(/[^0-9.-]+/g, "")
);
function updateprice(id) {
    let SelectMillePourcent =
        "#projectcreatemillestoneform-" + id + "-pourcentage";
    // let pourcent = $(SelectMillePourcent).val();
    let pourcent = Number(
        $(SelectMillePourcent)
            .val()
            .replace(",", ".")
            .replace(/[^0-9.-]+/g, "")
    );
    let SelectPrice = "#projectcreatemillestoneform-" + id + "-price";
    let price = ((TotalPrice * pourcent) / 100).toFixed(2);
    if (isNaN(price)) {
        price = 0;
    }
    $(SelectPrice).val(
        new Intl.NumberFormat("fr-FR", {
            style: "currency",
            currency: "EUR",
        }).format(price)
    );
}

function updatepourcent(id) {
    let SelectPrice = "#projectcreatemillestoneform-" + id + "-price";
    //let price = $(SelectPrice).val();
    let price = Number(
        $(SelectPrice)
            .val()
            .replace(",", ".")
            .replace(/[^0-9.-]+/g, "")
    );

    let SelectMillePourcent =
        "#projectcreatemillestoneform-" + id + "-pourcentage";
    let pourcent = ((price / TotalPrice) * 100).toFixed(2);
    if (isNaN(pourcent)) {
        pourcent = 0;
    }
    $(SelectMillePourcent).val(pourcent);
}
let pourcentage = "#projectcreatemillestoneform-" + 0 + "-pourcentage";

$(pourcentage).on("input", function (e) {
    updateprice(0);
});

let price = "#projectcreatemillestoneform-" + 0 + "-price";
$(price).on("input", function (e) {
    updatepourcent(0);
});
updateprice(0);
$(() => {
    $(".dynamicform_millestone").on("afterInsert", function (e, item) {
        //Recherche de l'index courrent
        let seletect = item.innerHTML;
        let regex = new RegExp("projectcreatemillestoneform-([0-9]*)-comment");
        let arr = regex.exec(seletect);
        let index = parseInt(arr[1]);

        let pourcentage =
            "#projectcreatemillestoneform-" + index + "-pourcentage";

        $(pourcentage).on("input", function (e) {
            updateprice(index);
        });

        let price = "#projectcreatemillestoneform-" + index + "-price";
        $(price).on("input", function (e) {
            updatepourcent(index);
        });
        let regex2 = new RegExp(
            'id="projectcreatemillestoneform-([0-9]*)-pourcentage',
            "gim"
        );
        let array1;
        let id = 0;
        let pourcentCalculated = 0.0;
        while (
            (array1 = regex2.exec(document.body.innerHTML)) !== null &&
            id != 50
        ) {
            id = id + 1;
            let element = array1[1];
            console.log(array1);
            let SelectMillePourcent =
                "#projectcreatemillestoneform-" + element + "-pourcentage";

            let pourcentread = Number(
                $(SelectMillePourcent)
                    .val()
                    .replace(",", ".")
                    .replace(/[^0-9.-]+/g, "")
            );
            pourcentCalculated = pourcentCalculated + pourcentread;
        }

        $(pourcentage).val(100 - pourcentCalculated);
        updateprice(index);
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
