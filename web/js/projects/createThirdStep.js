// Initialisation des données sous format d'objet Javascript.
const laboratoriesData = JSON.parse(document.getElementById("laboratories-data-target").textContent)
const equipmentsData = JSON.parse(document.getElementById("equipment-data-target").textContent)

// Variable utilisé pour déterminer le contenu dans la liste déroulante d'un matériel.
let equipmentsStateList = equipmentsData

/**
 * Scope jquery qui s'occupe de gérer la partie dynamique (calcul des coûts ect..) au lancement de la vue.
 * C'est donc la gestion dynamique de tous les composants à l'initialisation de la vue.
 */
$(() => {
    /**
     * On vide la liste déroulantes de toutes ses options, puis la nourrit avec la liste des matériels existants.
     * En sommes, ici, nous rafraichissons la liste déroulante à l'initialisation de la vue.
     */
    $("#projectcreateequipmentrepaymentform-0-equipmentselected").empty()
    $("#projectcreateequipmentrepaymentform-0-equipmentselected").append(getEquipementsOptionsListFromSelectedLaboratory(equipmentsData, laboratoriesData))

    /**
     * Mise à jour de l'état de la liste des matériels par rapport au labo choisi.
     * Très utile car on en a besoin pour faire le calcul du coût par matériel.
     */
    equipmentsStateList = getEquipementsListFromSelectedLaboratory(equipmentsData, laboratoriesData)

    /**
     * Callback onChange sur la liste déroulante des matériels du premier item.
     * Permet de reclaculer le coût d'utilisation d'un matériel.
     */
    $("#projectcreateequipmentrepaymentform-0-equipmentselected").change(() => {
        const result = calculateEquipmentPrice(
            $("#projectcreateequipmentrepaymentform-0-nb_days").val(),
            $("#projectcreateequipmentrepaymentform-0-nb_hours").val(),
            getValueFromEquipmentSelectedByIndex(equipmentsStateList, 0),
        )
        $("#projectcreateequipmentrepaymentform-0-price").val(result)
    })

    /**
     * Callback onInput sur le champ de sélection des jours d'utilisation d'un matériel.
     * Permet de reclaculer le coût d'utilisation d'un matériel.
     */
    $("#projectcreateequipmentrepaymentform-0-nb_days").on("input", () => {
        const result = calculateEquipmentPrice(
            $("#projectcreateequipmentrepaymentform-0-nb_days").val(),
            $("#projectcreateequipmentrepaymentform-0-nb_hours").val(),
            getValueFromEquipmentSelectedByIndex(equipmentsStateList, 0),
        )
        $("#projectcreateequipmentrepaymentform-0-price").val(result)
    })

    /**
     * Callback onInput sur le champ de sélection des heures d'utilisation d'un matériel.
     * Permet de recalculer le coût d'utilisation d'un matériel.
     */
    $("#projectcreateequipmentrepaymentform-0-nb_hours").on("input", () => {
        const result = calculateEquipmentPrice(
            $("#projectcreateequipmentrepaymentform-0-nb_days").val(),
            $("#projectcreateequipmentrepaymentform-0-nb_hours").val(),
            getValueFromEquipmentSelectedByIndex(equipmentsStateList, 0),
        )
        $("#projectcreateequipmentrepaymentform-0-price").val(result)
    })

    /**
     * Calbacl onInput sur le champ de sélection des jours pris par un intervenant labo.
     * Permet de recalculer le coût d'une intervention.
     */
    $("#projectcreatelaboratorycontributorform-0-nb_days").on("input", () => {
        const result = calculateContributorPrice(
            $("#projectcreatelaboratorycontributorform-0-nb_days").val(),
            $("#projectcreatelaboratorycontributorform-0-nb_hours").val(),
            getValueFromLaboratorySelected(laboratoriesData),
        )
        $("#projectcreatelaboratorycontributorform-0-price_day").val(result)
    })

    /**
     * Calbacl onInput sur le champ de sélection des heures pris par un intervenant labo.
     * Permet de recalculer le coût d'une intervention.
     */
    $("#projectcreatelaboratorycontributorform-0-nb_hours").on("input", () => {
        const result = calculateContributorPrice(
            $("#projectcreatelaboratorycontributorform-0-nb_days").val(),
            $("#projectcreatelaboratorycontributorform-0-nb_hours").val(),
            getValueFromLaboratorySelected(laboratoriesData),
        )
        $("#projectcreatelaboratorycontributorform-0-price_day").val(result)
    })
})

/**
 * Scope Jquery qui soccupe de gérer la partie dynamique (calcul des coûts ect..) à chaque fois qu'un nouvel élément est ajouté.
 * GESTION MATERIELS/EQUIPEMENTS.
 */
$(() => {
    /**
     * Variable pour garder en mémoire le nombre d'élément ajouté dans le dynamicForm des matériels.
     * Commence toujours à 0 lors de la création de la vue.
     */
    let nbEquipmentLineDuplicated = 0

    /**
     * Callback onChange sur la liste déroulante des laboratoires.
     * Permet de mettre à jours les valeurs dans les listes déroulantes des matériels et de recalculer le coût de chaque élément.
     * En effet, chaque matériel est lié à un labo, de ce fait, le changement d'un labo entraine donc le changement de la liste des matériels à disposition.
     * (Et donc le coût aussi vu que le matériel de chaque élément va changer).
     */
    $("#projectcreaterepaymentform-0-laboratoryselected").change(() => {
        for (let i = 0; i <= nbEquipmentLineDuplicated; i++) {
            $(`#projectcreateequipmentrepaymentform-${i}-equipmentselected`).empty()
            $(`#projectcreateequipmentrepaymentform-${i}-equipmentselected`).append(
                getEquipementsOptionsListFromSelectedLaboratory(equipmentsData, laboratoriesData),
            )

            equipmentsStateList = getEquipementsListFromSelectedLaboratory(equipmentsData, laboratoriesData)
            const result = calculateEquipmentPrice(
                $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                getValueFromEquipmentSelectedByIndex(equipmentsStateList, 0),
            )
            $(`#projectcreateequipmentrepaymentform-${i}-price`).val(result)
        }
    })

    /**
     * Calback onAddItem.
     * Permet de gérer les callback des futurs éléments que l'utilisateur pourra créer.
     */
    $(".dynamicform_wrapper_equipment").on("afterInsert", function (e, item) {
        nbEquipmentLineDuplicated++

        /**
         * On vide la liste déroulantes de toutes ses options, puis la nourrit avec la liste des matériels existants.
         * En sommes, ici, nous rafraichissons la liste déroulante à l'initialisation de la vue.
         */
        $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-equipmentselected`).empty()
        $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-equipmentselected`).append(
            getEquipementsOptionsListFromSelectedLaboratory(equipmentsData, laboratoriesData),
        )

        /**
         * Callback onChange sur la liste déroulante des matériels de l'élément ajouté.
         * Permet de reclaculer le coût d'utilisation d'un matériel.
         */
        $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-equipmentselected`).change(() => {
            const result = calculateEquipmentPrice(
                $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-nb_days`).val(),
                $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-nb_hours`).val(),
                getValueFromEquipmentSelectedByIndex(equipmentsStateList, nbEquipmentLineDuplicated),
            )

            $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-price`).val(result)
        })

        /**
         * Callback onInput sur le champ de sélection des jours d'utilisation d'un élément matériel ajouté.
         * Permet de reclaculer le coût d'utilisation d'un matériel.
         */
        $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-nb_days`).on("input", () => {
            const result = calculateEquipmentPrice(
                $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-nb_days`).val(),
                $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-nb_hours`).val(),
                getValueFromEquipmentSelectedByIndex(equipmentsStateList, nbEquipmentLineDuplicated),
            )
            $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-price`).val(result)
        })

        /**
         * Callback onInput sur le champ de sélection des heures d'utilisation d'un élément matériel ajouté.
         * Permet de recalculer le coût d'utilisation d'un matériel.
         */
        $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-nb_hours`).on("input", () => {
            const result = calculateEquipmentPrice(
                $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-nb_days`).val(),
                $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-nb_hours`).val(),
                getValueFromEquipmentSelectedByIndex(equipmentsStateList, nbEquipmentLineDuplicated),
            )
            $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-price`).val(result)
        })
    })

    /**
     * Calback onRemoveItem.
     */
    $(".dynamicform_wrapper_equipment").on("afterDelete", function (e) {
        nbEquipmentLineDuplicated--
    })
})

/**
 * Scope Jquery qui soccupe de gérer la partie dynamique (calcul des coûts ect..) à chaque fois qu'un nouvel élément est ajouté.
 * GESTION INTERVENANTS.
 */
$(() => {
    /**
     * Variable pour garder en mémoire le nombre d'élément ajouté dans le dynamicForm des matériels.
     * Commence toujours à 0 lors de la création de la vue.
     */
    let nbContributorLineDuplicated = 0

    /**
     * Callback onChange sur la liste déroulante des laboratoires.
     * Permet de recalculer le coût de chaque élément.
     * En effet, chaque intervenant est lié à un labo, de ce fait, le changement d'un labo entraine donc le changement du coût d'un intervenant.
     */
    $("#projectcreaterepaymentform-0-laboratoryselected").change(() => {
        for (let i = 0; i <= nbContributorLineDuplicated; i++) {
            const result = calculateContributorPrice(
                $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                getValueFromLaboratorySelected(laboratoriesData),
            )
            $(`#projectcreatelaboratorycontributorform-${i}-price_day`).val(result)
        }
    })

    /**
     * Calback onAddItem.
     * Permet de gérer les callback des futurs éléments que l'utilisateur pourra créer.
     */
    $(".dynamicform_wrapper_contributor").on("afterInsert", function (e, item) {
        nbContributorLineDuplicated++

        /**
         * Callback onInput sur le champ de sélection des jours pris par un intervenant.
         * Permet de reclaculer le coût d'un intervenant.
         */
        $(`#projectcreatelaboratorycontributorform-${nbContributorLineDuplicated}-nb_days`).on("input", () => {
            const result = calculateContributorPrice(
                $(`#projectcreatelaboratorycontributorform-${nbContributorLineDuplicated}-nb_days`).val(),
                $(`#projectcreatelaboratorycontributorform-${nbContributorLineDuplicated}-nb_hours`).val(),
                getValueFromLaboratorySelected(laboratoriesData),
            )
            $(`#projectcreatelaboratorycontributorform-${nbContributorLineDuplicated}-price_day`).val(result)
        })

        /**
         * Callback onInput sur le champ de sélection des heures prises par un intervenant.
         * Permet de reclaculer le coût d'un intervenant.
         */
        $(`#projectcreatelaboratorycontributorform-${nbContributorLineDuplicated}-nb_hours`).on("input", () => {
            const result = calculateContributorPrice(
                $(`#projectcreatelaboratorycontributorform-${nbContributorLineDuplicated}-nb_days`).val(),
                $(`#projectcreatelaboratorycontributorform-${nbContributorLineDuplicated}-nb_hours`).val(),
                getValueFromLaboratorySelected(laboratoriesData),
            )
            $(`#projectcreatelaboratorycontributorform-${nbContributorLineDuplicated}-price_day`).val(result)
        })
    })

    $(".dynamicform_wrapper_contributor").on("afterDelete", function (e) {
        nbContributorLineDuplicated--
    })
})

/**
 * Fonction permettant de retourner le labo sélectionné.
 * @param {*} laboratoriesData Liste de tous les laboratoires.
 */
const getValueFromLaboratorySelected = (laboratoriesData) => laboratoriesData[$("#projectcreaterepaymentform-0-laboratoryselected option:selected").val()]

/**
 * Fonction qui permet de retourner l'équipement sélectionné sur une ligne précise.
 * @param {*} equipmentsData
 */
const getValueFromEquipmentSelectedByIndex = (equipmentsData, index) =>
    equipmentsData[$(`#projectcreateequipmentrepaymentform-${index}-equipmentselected option:selected`).val()]

/**
 * Fonction qui va être utilisé pour faire le calcul du coût.
 * @param {*} nbDay Nombre de jour
 * @param {*} nbHour Nombre d'heure
 * @param {*} laboratory Un objet Laboratoire
 *
 * @returns Un prix.
 */
const calculateEquipmentPrice = (nbDay, nbHour, equipment) => equipment.price_day * nbDay + equipment.price_hour * nbHour

/**
 * Fonction qui va être utilisé pour faire le calcul du coût d'un contributeur.
 * @param {*} nbDay Nombre de jour
 * @param {*} nbHour Nombre d'heure
 * @param {*} laboratory Un objet Laboratoire
 *
 * @returns Un prix.
 */
const calculateContributorPrice = (nbDay, nbHour, laboratory) => laboratory.price_contributor_day * nbDay + laboratory.price_contributor_hour * nbHour

/**
 * Fonction qui permet de retourner une liste d'option pour la liste déroulate des matériels suivant le laboratoire sélectionné.
 * @param {*} equipmentsData
 * @param {*} laboratoriesData
 */
const getEquipementsOptionsListFromSelectedLaboratory = (equipmentsData, laboratoriesData) => {
    dataToRefresh = equipmentsData.filter((element) => element.laboratory_id == getValueFromLaboratorySelected(laboratoriesData).id)
    results = []

    dataToRefresh.forEach((element, index) => {
        const option = new Option(element.name, index, false, false)
        $(option).html(element.name)
        results.push(option)
    })

    return results
}

/**
 * Fonction qui permet de retourner une liste de matériel associée au laboratoire sélectionné..
 * @param {*} equipmentsData
 * @param {*} laboratoriesData
 */
const getEquipementsListFromSelectedLaboratory = (equipmentsData, laboratoriesData) =>
    equipmentsData.filter((element) => element.laboratory_id == getValueFromLaboratorySelected(laboratoriesData).id)
