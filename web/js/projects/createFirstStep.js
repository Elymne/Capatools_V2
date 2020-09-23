/**
 * Gestion du JQUERY dans la première étape de la création d'un projet.
 */
$(() => {
    // Attributs.
    const lotRadioboxList = $(
        'input:radio[name="ProjectCreateFirstStepForm[combobox_lot_checked]"]'
    );

    const lotManagementLabel = $("#lot-management-label");
    const lotManagementBody = $("#lot-management-body");

    // Si le bouton coché au moment du chargement du DOM est "non", alors on cache la partie gestion des lots.
    const lotRadioboxCheckedValue = $(
        'input:radio[name="ProjectCreateFirstStepForm[combobox_lot_checked]"]:checked'
    ).val();
    if (lotRadioboxCheckedValue == 0) {
        lotManagementLabel.hide();
        lotManagementBody.hide();
    }

    // Callback.
    lotRadioboxList.change(() => {
        if ($(this).is(":checked") && $(this).val() == 0) {
            lotManagementLabel.hide();
            lotManagementBody.hide();
        } else {
            lotManagementLabel.show();
            lotManagementBody.show();
        }
    });
    //frameElement()
    $(".dynamicform_wrapper").on("beforeDelete", (e, item) => {
        confirm("Etes-vous sûr de vouloir supprimer ce lot ?");
    });

    $(".dynamicform_wrapper").on("afterDelete", (e, item) => {
        //Je reorganise tout les N° de lot
        let regex = new RegExp(
            "projectcreatelotform-([0-9]*)-id_string",
            "gim"
        );
        let array1;
        //
        while ((array1 = regex.exec(document.body.innerHTML)) !== null) {
            let element = parseInt(array1[1]);
            let id_string = "#projectcreatelotform-" + element + "-id_string";
            element += 1;
            $(id_string).val("Lot N°" + element + " ");
        }
    });
    $(".dynamicform_wrapper").on("afterInsert", (e, item) => {
        //Recherche de l'index courrent
        let seletect = item.innerHTML;
        let regex = new RegExp("projectcreatelotform-([0-9]*)-id_string");
        let arr = regex.exec(seletect);
        let index = parseInt(arr[1]);
        let id_string = "#projectcreatelotform-" + index + "-id_string";
        $(id_string).val("Lot N°" + (index + 1) + " ");
    });
});
