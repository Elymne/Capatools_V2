// Gestion cout des équipements.
$(() => {
    // Initialisation des données sous format d'objet Javascript.
    const laboratoriesData = JSON.parse(document.getElementById("laboratories-data-target").textContent)

    // Récupération des éléments HTML.
    const laboratorySelectForm = $("#projectcreaterepaymentform-0-laboratoryselected")

    const nbDayEquipmentInput = $("#projectcreateequipmentrepaymentform-0-nb_days")
    const nbHourEquipmentInput = $("#projectcreateequipmentrepaymentform-0-nb_hours")
    const priceEquipmentInput = $("#projectcreateequipmentrepaymentform-0-price")

    // Initialisation des données qui vont sévir toute la page dynamiquement.

    const nbDayPriceEquipmentField = $("#projectcreateequipmentrepaymentform-0-nb_days").val()
    console.log(nbDayPriceEquipmentField)

    // Quand on sélectionne une nouvelle données.
    laboratorySelectForm.change(() => {
        const result = calculateEquipmentPrice(nbDayEquipmentInput.val(), nbHourEquipmentInput.val(), getValueFormLaboratorySelected(laboratoriesData))
        priceEquipmentInput.val(result)
    })

    // Quand on change le cout en jour d'un matériel.
    nbDayEquipmentInput.on("input", (e) => {
        const result = calculateEquipmentPrice(nbDayEquipmentInput.val(), nbHourEquipmentInput.val(), getValueFormLaboratorySelected(laboratoriesData))
        priceEquipmentInput.val(result)
    })

    nbHourEquipmentInput.on("input", (e) => {
        const result = calculateEquipmentPrice(nbDayEquipmentInput.val(), nbHourEquipmentInput.val(), getValueFormLaboratorySelected(laboratoriesData))
        priceEquipmentInput.val(result)
    })
})

/**
 * Fonction permettant de retourner le labo sélectionné.
 * @param {*} laboratoriesData Liste de tous les laboratoires.
 */
const getValueFormLaboratorySelected = (laboratoriesData) => laboratoriesData[$("#projectcreaterepaymentform-0-laboratoryselected option:selected").val()]

/**
 * FOnction qui va être utilisé pour faire le calcul du coût.
 * @param {*} nbDay Nombre de jour
 * @param {*} nbHour Nombre d'heure
 * @param {*} laboratory Un objet Laboratoire
 *
 * @returns Un prix.
 */
const calculateEquipmentPrice = (nbDay, nbHour, laboratory) => laboratory.price_contributor_day * nbDay + laboratory.price_contributor_day * nbHour
