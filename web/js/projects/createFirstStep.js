/**
 * Gestion du JQUERY dans la première étape de la création d'un projet.
 */
$(() => {
    // Attributs.
    const lotRadioboxList = $('input:radio[name="ProjectCreateFirstStepForm[combobox_lot_checked]"]')

    const lotManagementLabel = $("#lot-management-label")
    const lotManagementBody = $("#lot-management-body")

    // Si le bouton coché au moment du chargement du DOM est "non", alors on cache la partie gestion des lots.
    const lotRadioboxCheckedValue = $('input:radio[name="ProjectCreateFirstStepForm[combobox_lot_checked]"]:checked').val()
    if (lotRadioboxCheckedValue == 0) {
        lotManagementLabel.hide()
        lotManagementBody.hide()
    }

    // Callback.
    lotRadioboxList.change(function () {
        if ($(this).is(":checked") && $(this).val() == 0) {
            lotManagementLabel.hide()
            lotManagementBody.hide()
        } else {
            lotManagementLabel.show()
            lotManagementBody.show()
        }
    })
})
