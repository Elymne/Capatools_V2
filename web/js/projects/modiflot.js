$(() => {
    $(".dynamicform_wrapper").on("afterInsert", function (e, item) {
        //Recherche de l'index courrent
        let seletect = item.innerHTML;
        let regex = new RegExp("Lot-([0-9]*)-number");
        let arr = regex.exec(seletect);
        let index = parseInt(arr[1]);

        //Ajout des callbacks pour les élements
        let SelectNumber = "#Lot-" + index + "-number";
        $(SelectNumber).val(index);
    });

    $(".dynamicform_wrapper").on("beforeDelete", function (e, item) {
        if (!confirm("Are you sure you want to delete this item?")) {
            return false;
        }

        return true;
    });

    $(".dynamicform_wrapper").on("limitReached", function (e, item) {
        alert("Limit reached");
    });
});
