const totalPriceJson = JSON.parse(
    document.getElementById("price-data-target").textContent
);
const totalPrice = Number(
    totalPriceJson.replace(",", ".").replace(/[^0-9.-]+/g, "")
);

Initialise();

function Initialise() {
    let regex2 = new RegExp(
        'id="projectcreatemillestoneform-([0-9]*)-pourcentage',
        "gim"
    );
    let id = 0;
    let array1;
    while (
        (array1 = regex2.exec(document.body.innerHTML)) !== null &&
        id != 50
    ) {
        id = id + 1;
        let element = array1[1];
        updateprice(element);

        let pourcentage =
            "#projectcreatemillestoneform-" + element + "-pourcentage";

        $(pourcentage).on("input", function (e) {
            updateprice(element);
        });

        let price = "#projectcreatemillestoneform-" + element + "-priceeuros";
        $(price).on("input", function (e) {
            updatepourcent(element);
        });
    }
}

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
    let SelectPrice = "#projectcreatemillestoneform-" + id + "-priceeuros";
    let price = ((totalPrice * pourcent) / 100).toFixed(2);
    if (isNaN(price)) {
        price = 0;
    }
    $(SelectPrice).val(
        new Intl.NumberFormat("fr-FR", {
            style: "currency",
            currency: "EUR",
        }).format(price)
    );

    SelectPrice = "#projectcreatemillestoneform-" + id + "-price";
    $(SelectPrice).val(price);
}

function updatepourcent(id) {
    let SelectPrice = "#projectcreatemillestoneform-" + id + "-priceeuros";
    //let price = $(SelectPrice).val();
    let price = Number(
        $(SelectPrice)
            .val()
            .replace(",", ".")
            .replace(/[^0-9.-]+/g, "")
    );

    let SelectMillePourcent =
        "#projectcreatemillestoneform-" + id + "-pourcentage";
    let pourcent = ((price / totalPrice) * 100).toFixed(2);
    if (isNaN(pourcent)) {
        pourcent = 0;
    }
    $(SelectMillePourcent).val(pourcent);
}

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

        let price = "#projectcreatemillestoneform-" + index + "-priceeuros";
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

        let TaskNumber = "#projectcreatemillestoneform-" + index + "-number";
        $(TaskNumber).val(index);

        $(".picker").each(function () {
            $(this).datepicker({
                dateFormat: "dd-mm-yy",
                language: "fr",
            });
        });
    });

    $(".dynamicform_wrapperLot").on("beforeDelete", function (e, item) {
        if (!confirm("Voulez-vous supprimer ce jalon?")) {
            return false;
        }

        return true;
    });

    $(".dynamicform_wrapperLot").on("limitReached", function (e, item) {
        alert("Limite atteinte");
    });

    /**
     * On change, set the default value of field low_jtm_raison.
     */
    const SelectRaison = "#projectsimulate-low_tjm_raison";
    const description = "#projectsimulate-low_tjm_description";
    const descriptiondiv = "low_tjm_description_id";
    const description_label = "#low_tjm_description-label";

    $(SelectRaison).on("select2:select", function (e) {
        if (e.currentTarget.value != "Autre") {
            $(description).val("Aucune");
            $(description).hide();
            $(description_label).hide();
        } else {
            $(description).val("");
            $(description).show();
            $(description_label).show();
        }
    });

    /**
     * On init, select the default display of field low_jtm_raison.
     */
    if ($("#projectsimulate-low_tjm_raison option:selected").val() == "Autre") {
        $(description).show();
        $(description_label).show();
    } else {
        $(description).val("Aucune");
        $(description).hide();
        $(description_label).hide();
    }

    $(".dynamicform_millestone").on("beforeDelete", (e, item) =>
        confirm("Voulez-vous supprimer ce jalon ?")
    );
});
