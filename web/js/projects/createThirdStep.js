// Initialisation des données sous format d'objet Javascript.
const laboratoriesData = JSON.parse(document.getElementById("laboratories-data-target").textContent)
const equipmentsData = JSON.parse(document.getElementById("equipments-data-target").textContent)
const risksData = JSON.parse(document.getElementById("risks-data-target").textContent)

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

    // Par défaut, le temps généré par le risque est à 0.
    $("#projectcreateequipmentrepaymentform-0-time_risk").val(stringifyRiskTime())
    $("#projectcreatelaboratorycontributorform-0-time_risk").val(stringifyRiskTime())

    // Par défaut, le coût généré est de 0.
    $("#projectcreateequipmentrepaymentform-0-price").val(0)
    $("#projectcreatelaboratorycontributorform-0-price").val(0)

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
            getValueFromEquipmentSelectedByIndex(equipmentsStateList),
        )
        $("#projectcreateequipmentrepaymentform-0-price").val(result)
    })

    /**
     * Callback onChange sur la liste déroulante des matériels du premier item.
     * Permet de recalculer le temps additionel lié au risque.
     */
    $("#projectcreateequipmentrepaymentform-0-riskselected").change(() => {
        const riskObject = calculateRiskTime(
            $("#projectcreateequipmentrepaymentform-0-nb_days").val(),
            $("#projectcreateequipmentrepaymentform-0-nb_hours").val(),
            getValueFromEquipmentRiskSelectedByIndex(risksData, 0),
        )
        $("#projectcreateequipmentrepaymentform-0-time_risk").val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
    })

    /**
     * Callback onInput sur le champ de sélection des jours d'utilisation d'un matériel.
     * Permet de reclaculer le coût d'utilisation d'un matériel.
     */
    $("#projectcreateequipmentrepaymentform-0-nb_days").on("input", () => {
        const result = calculateEquipmentPrice(
            $("#projectcreateequipmentrepaymentform-0-nb_days").val(),
            $("#projectcreateequipmentrepaymentform-0-nb_hours").val(),
            getValueFromEquipmentSelectedByIndex(equipmentsStateList),
        )
        $("#projectcreateequipmentrepaymentform-0-price").val(result)
        const riskObject = calculateRiskTime(
            $("#projectcreateequipmentrepaymentform-0-nb_days").val(),
            $("#projectcreateequipmentrepaymentform-0-nb_hours").val(),
            getValueFromEquipmentRiskSelectedByIndex(risksData, 0),
        )
        $("#projectcreateequipmentrepaymentform-0-time_risk").val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
    })

    /**
     * Callback onInput sur le champ de sélection des heures d'utilisation d'un matériel.
     * Permet de recalculer le coût d'utilisation d'un matériel.
     */
    $("#projectcreateequipmentrepaymentform-0-nb_hours").on("input", () => {
        const result = calculateEquipmentPrice(
            $("#projectcreateequipmentrepaymentform-0-nb_days").val(),
            $("#projectcreateequipmentrepaymentform-0-nb_hours").val(),
            getValueFromEquipmentSelectedByIndex(equipmentsStateList),
        )
        $("#projectcreateequipmentrepaymentform-0-price").val(result)
        const riskObject = calculateRiskTime(
            $("#projectcreateequipmentrepaymentform-0-nb_days").val(),
            $("#projectcreateequipmentrepaymentform-0-nb_hours").val(),
            getValueFromEquipmentRiskSelectedByIndex(risksData, 0),
        )
        $("#projectcreateequipmentrepaymentform-0-time_risk").val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
    })

    /**
     * Callback onChange sur la liste déroulante des matériels du premier item.
     * Permet de recalculer le temps additionel lié au risque.
     */
    $("#projectcreatelaboratorycontributorform-0-riskselected").change(() => {
        const riskObject = calculateRiskTime(
            $("#projectcreatelaboratorycontributorform-0-nb_days").val(),
            $("#projectcreatelaboratorycontributorform-0-nb_hours").val(),
            getValueFromContributorRiskSelectedByIndex(risksData, 0),
        )
        $("#projectcreatelaboratorycontributorform-0-time_risk").val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
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
        $("#projectcreatelaboratorycontributorform-0-price").val(result)

        const riskObject = calculateRiskTime(
            $("#projectcreatelaboratorycontributorform-0-nb_days").val(),
            $("#projectcreatelaboratorycontributorform-0-nb_hours").val(),
            getValueFromContributorRiskSelectedByIndex(risksData, 0),
        )
        $("#projectcreatelaboratorycontributorform-0-time_risk").val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
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
        $("#projectcreatelaboratorycontributorform-0-price").val(result)

        const riskObject = calculateRiskTime(
            $("#projectcreatelaboratorycontributorform-0-nb_days").val(),
            $("#projectcreatelaboratorycontributorform-0-nb_hours").val(),
            getValueFromContributorRiskSelectedByIndex(risksData, 0),
        )
        $("#projectcreatelaboratorycontributorform-0-time_risk").val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
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
    $("#projectcreaterepaymentform-laboratoryselected").change(() => {
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

        // Par défaut, le temps généré par le risque est à 0.
        $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-time_risk`).val(stringifyRiskTime())

        // Par défaut, le coût généré est de 0.
        $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-price`).val(0)

        for (let i = 0; i <= nbEquipmentLineDuplicated; i++) {
            /**
             * Callback onChange sur la liste déroulante des matériels de l'élément ajouté.
             * Permet de reclaculer le coût d'utilisation d'un matériel.
             */
            $(`#projectcreateequipmentrepaymentform-${i}-equipmentselected`).change(() => {
                const result = calculateEquipmentPrice(
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                    getValueFromEquipmentSelectedByIndex(equipmentsStateList, nbEquipmentLineDuplicated),
                )

                $(`#projectcreateequipmentrepaymentform-${i}-price`).val(result)
            })

            /**
             * Callback onChange sur la liste déroulante des matériels du premier item.
             * Permet de recalculer le temps additionel lié au risque.
             */
            $(`#projectcreateequipmentrepaymentform-${i}-riskselected`).change(() => {
                const riskObject = calculateRiskTime(
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                    getValueFromEquipmentRiskSelectedByIndex(risksData, i),
                )
                $(`#projectcreateequipmentrepaymentform-${i}-time_risk`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
            })

            /**
             * Callback onInput sur le champ de sélection des jours d'utilisation d'un élément matériel ajouté.
             * Permet de reclaculer le coût d'utilisation d'un matériel.
             */
            $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).on("input", () => {
                const result = calculateEquipmentPrice(
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                    getValueFromEquipmentSelectedByIndex(equipmentsStateList, i),
                )
                $(`#projectcreateequipmentrepaymentform-${i}-price`).val(result)
                const riskObject = calculateRiskTime(
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                    getValueFromEquipmentRiskSelectedByIndex(risksData, i),
                )
                $(`#projectcreateequipmentrepaymentform-${i}-time_risk`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
            })

            /**
             * Callback onInput sur le champ de sélection des heures d'utilisation d'un élément matériel ajouté.
             * Permet de recalculer le coût d'utilisation d'un matériel.
             */
            $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).on("input", () => {
                const result = calculateEquipmentPrice(
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                    getValueFromEquipmentSelectedByIndex(equipmentsStateList, i),
                )
                $(`#projectcreateequipmentrepaymentform-${i}-price`).val(result)
                const riskObject = calculateRiskTime(
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                    getValueFromEquipmentRiskSelectedByIndex(risksData, 0),
                )
                $(`#projectcreateequipmentrepaymentform-${i}-time_risk`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
            })
        }
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
    $("#projectcreaterepaymentform-laboratoryselected").change(() => {
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

        // Par défaut, le temps généré par le risque est à 0.
        $(`#projectcreatelaboratorycontributorform-${nbContributorLineDuplicated}-time_risk`).val(stringifyRiskTime())

        // Par défaut, le coût généré est de 0.
        $(`#projectcreatelaboratorycontributorform-${nbContributorLineDuplicated}-price`).val(0)

        for (let i = 0; i <= nbContributorLineDuplicated; i++) {
            /**
             * Callback onChange sur la liste déroulante des matériels du premier item.
             * Permet de recalculer le temps additionel lié au risque.
             */
            $(`#projectcreatelaboratorycontributorform-${i}-riskselected`).change(() => {
                const riskObject = calculateRiskTime(
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                    getValueFromContributorRiskSelectedByIndex(risksData, 0),
                )
                $(`#projectcreatelaboratorycontributorform-${i}-time_risk`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
            })

            /**
             * Callback onInput sur le champ de sélection des jours pris par un intervenant.
             * Permet de reclaculer le coût d'un intervenant.
             */
            $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).on("input", () => {
                const result = calculateContributorPrice(
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                    getValueFromLaboratorySelected(laboratoriesData),
                )
                $(`#projectcreatelaboratorycontributorform-${i}-price`).val(result)

                const riskObject = calculateRiskTime(
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                    getValueFromContributorRiskSelectedByIndex(risksData, 0),
                )
                $(`#projectcreatelaboratorycontributorform-${i}-time_risk`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
            })

            /**
             * Callback onInput sur le champ de sélection des heures prises par un intervenant.
             * Permet de reclaculer le coût d'un intervenant.
             */
            $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).on("input", () => {
                const result = calculateContributorPrice(
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                    getValueFromLaboratorySelected(laboratoriesData),
                )
                $(`#projectcreatelaboratorycontributorform-${i}-price`).val(result)

                const riskObject = calculateRiskTime(
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                    getValueFromContributorRiskSelectedByIndex(risksData, 0),
                )
                $(`#projectcreatelaboratorycontributorform-${i}-time_risk`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
            })
        }
    })

    $(".dynamicform_wrapper_contributor").on("afterDelete", function (e) {
        nbContributorLineDuplicated--
    })
})

/**
 * Fonction permettant de retourner le labo sélectionné.
 * @param {*} laboratoriesData - Liste de tous les laboratoires.
 */
const getValueFromLaboratorySelected = (laboratoriesData) => laboratoriesData[$("#projectcreaterepaymentform-laboratoryselected option:selected").val()]

/**
 * Fonction qui permet de retourner l'équipement sélectionné sur un élément précis du dynamicView des matériels.
 * @param {*} equipmentsData - Une liste d'équipements/matériels que l'on a au préalable injecté dans la liste déroulante.
 * @param {*} index - Numéro de l'item précis dont on souhaite connaitre l'équipement sélectionné
 */
const getValueFromEquipmentSelectedByIndex = (equipmentsData, index = 0) =>
    equipmentsData[$(`#projectcreateequipmentrepaymentform-${index}-equipmentselected option:selected`).val()]

/**
 * Fonction qui permet de retourner le risque sélectionné sur un élément précis du dynamicView des matériels.
 * @param {*} risksData - Une liste d'objet risque que l'on a au préalable injecté dans la liste déroulante.
 * @param {*} index - Numéro de l'item précis dont on souhaite connaitre l'équipement sélectionné
 */
const getValueFromEquipmentRiskSelectedByIndex = (risksData, index = 0) =>
    risksData[$(`#projectcreateequipmentrepaymentform-${index}-riskselected option:selected`).val()]

/**
 * Fonction qui permet de retourner le risque sélectionné sur un élément précis du dynamicView des matériels.
 * @param {*} risksData - Une liste d'objet risque que l'on a au préalable injecté dans la liste déroulante.
 * @param {*} index - Numéro de l'item précis dont on souhaite connaitre l'équipement sélectionné
 */
const getValueFromContributorRiskSelectedByIndex = (risksData, index = 0) =>
    risksData[$(`#projectcreatelaboratorycontributorform-${index}-riskselected option:selected`).val()]

/**
 * Fonction qui va être utilisé pour faire le calcul du coût.
 * @param {*} nbDay - Nombre de jour
 * @param {*} nbHour - Nombre d'heure
 * @param {*} laboratory - Un objet Laboratoire
 *
 * @returns Un prix.
 */
const calculateEquipmentPrice = (nbDay, nbHour, equipment) => equipment.price_day * nbDay + equipment.price_hour * nbHour

/**
 * Fonction qui va être utilisé pour faire le calcul du coût d'un contributeur.
 * @param {*} nbDay - Nombre de jours
 * @param {*} nbHour - Nombre d'heures
 * @param {*} laboratory - Un objet Laboratoire
 *
 * @returns Un prix.
 */
const calculateContributorPrice = (nbDay, nbHour, laboratory) => laboratory.price_contributor_day * nbDay + laboratory.price_contributor_hour * nbHour

/**
 * Fonction qui va être utilisé pour calculer le temps d'incertitude par rapport au risque.
 * @param {*} nbDay - Nombre de jours
 * @param {*} nbHour - Nombre d'heures
 * @param {*} risk - Un objet risk
 *
 * @return Un objet avec deux valeurs de temps.
 */
const calculateRiskTime = (nbDay, nbHour, risk) => {
    let riskDay = nbDay * risk.coefficient
    let riskHour = nbHour * risk.coefficient

    const decimalDay = riskDay - Math.floor(riskDay)
    riskDay = Math.trunc(riskDay)

    riskHour = Math.round(riskHour + decimalDay * 7.7)
    const additionalDay = Math.trunc(riskHour / 7.7)
    riskHour = riskHour % 7.7

    riskDay = additionalDay + riskDay
    return { riskDay, riskHour }
}

/**
 * Fonction que l'on va utiliser pour retourner l'affichage du temps généré au bon format.
 * @param {*} riskDay
 * @param {*} riskHour
 */
const stringifyRiskTime = (riskDay = 0, riskHour = 0) => `${parseFloat(riskDay).toFixed(0)}d ${parseFloat(riskHour).toFixed(0)}h`

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
