// Initialisation des données sous format d'objet Javascript.
const laboratoriesData = JSON.parse(document.getElementById("laboratories-data-target").textContent)
const risksData = JSON.parse(document.getElementById("risks-data-target").textContent)

// Liste d'informations relatives au données qui enreichissent le dynamicForm.
const infoData = JSON.parse(document.getElementById("info-data-target").textContent)

const laboratorySelected = infoData.laboratorySelected !== null ? infoData.laboratorySelected : 0
const addedEquipementsOnInit = infoData.equipments
const addedContributorsOnInit = infoData.contributors
const laboxyTimeDay = 7.7
const number = infoData.number

/**
 * Constante que j'utilise pour savoir si le lot actuel de la vue est un lot d'avant projet, c'est-à-dire un lot dont le numéro est égale à 0.
 */
const isPreProject = number === '"0"'

/**
 * Scope de test parce que je ne sais pas trop ce que je fais actuellement, on va voir si ça marche en tout cas.
 * J'pense que j'vais appeler ce scope : THE BEGGIN OF BIG FAT JQUERY CODE OF DOOM.
 */
$(() => {
    /**
     * On cache certains éléments suivant le numéro du lot en cours de modification.
     */
    hideCardInvestPlus(isPreProject)
    hideEquipmentRisk(isPreProject)
    hideContributorRisk(isPreProject)

    /**
     * Explication : Pour chaque equipment de renvoyé dans la vue (des équipements donc qui seront affichés dans la dynamicView), il va nous falloir définir les callback de calcul
     * pour chaque élément.
     * C'est donc ce que l'on fait dans cette boucle.
     */
    addedEquipementsOnInit.forEach((elem, i) => {
        const nbDaysField = $(`#projectcreateequipmentrepaymentform-${i}-nb_days`)
        const nbHoursField = $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`)
        const timeRiskStringifyField = $(`#projectcreateequipmentrepaymentform-${i}-timeriskstringify`)
        const dailyPriceField = $(`#projectcreateequipmentrepaymentform-${i}-daily_price`)
        const totalPriceField = $(`#projectcreateequipmentrepaymentform-${i}-price`)
        const riskSelector = $(`#projectcreateequipmentrepaymentform-${i}-riskselected`)

        initNewEquipementRepaymentAdded(i)
        equipmentRepaymentRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
        equipmentRepaymentTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)

        dailyPriceField.on("input", () => {
            equipmentRepaymentTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)
        })

        riskSelector.change(() => {
            equipmentRepaymentRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
        })

        nbDaysField.on("input", () => {
            equipmentRepaymentTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)
            equipmentRepaymentRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
        })

        nbHoursField.on("input", () => {
            equipmentRepaymentTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)
            equipmentRepaymentRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
        })

        //getIndexSelectorOfEquipment(elem, equipmentsLocalStateList)
    })

    addedContributorsOnInit.forEach((elem, i) => {
        const nbDaysField = $(`#projectcreatelaboratorycontributorform-${i}-nb_days`)
        const nbHoursField = $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`)
        const dailyPriceField = $(`#projectcreatelaboratorycontributorform-${i}-daily_price`)
        const totalPriceField = $(`#projectcreatelaboratorycontributorform-${i}-price`)
        const timeRiskStringifyField = $(`#projectcreatelaboratorycontributorform-${i}-timeriskstringify`)
        const riskSelector = $(`#projectcreatelaboratorycontributorform-${i}-riskselected`)

        initNewLaboratoryContributorAdded(i)
        laboratoryContributorRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
        laboratoryContributorTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)

        riskSelector.change(() => {
            laboratoryContributorRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
        })

        dailyPriceField.on("input", () => {
            laboratoryContributorTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)
        })

        nbDaysField.on("input", () => {
            laboratoryContributorTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)
            laboratoryContributorRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
        })

        nbHoursField.on("input", () => {
            laboratoryContributorTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)
            laboratoryContributorRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
        })
    })
    //end
})

/**
 * Scope Jquery qui soccupe de gérer la partie dynamique (calcul des coûts ect..) à chaque fois qu'un nouvel élément est ajouté.
 * GESTION MATERIELS/EQUIPEMENTS.
 */
$(() => {
    /**
     * Variable pour garder en mémoire le nombre d'élément ajouté dans le dynamicForm des matériels.
     * Commence toujours avec le nombre d'éléments lors de l'initialisation (soit 1 à l'init, ce qui veut dire que la première ligne sera la numéro 0).
     */
    let nbEquipmentLineDuplicated = addedEquipementsOnInit.length - 1

    /**
     * Calback onAddItem.
     * Permet de gérer les callback des futurs éléments que l'utilisateur pourra créer.
     */
    $(".dynamicform_wrapper_equipment").on("afterInsert", (e, item) => {
        nbEquipmentLineDuplicated++
        hideEquipmentRisk(isPreProject)

        initNewEquipementRepaymentAdded(nbEquipmentLineDuplicated)

        for (let i = 0; i <= nbEquipmentLineDuplicated; i++) {
            const nbDaysField = $(`#projectcreateequipmentrepaymentform-${i}-nb_days`)
            const nbHoursField = $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`)
            const timeRiskStringifyField = $(`#projectcreateequipmentrepaymentform-${i}-timeriskstringify`)
            const dailyPriceField = $(`#projectcreateequipmentrepaymentform-${i}-daily_price`)
            const totalPriceField = $(`#projectcreateequipmentrepaymentform-${i}-price`)
            const riskSelector = $(`#projectcreateequipmentrepaymentform-${i}-riskselected`)

            hideEquipmentRisk(isPreProject, i)
            equipmentRepaymentRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
            equipmentRepaymentTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)

            dailyPriceField.on("input", () => {
                equipmentRepaymentTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)
            })

            riskSelector.change(() => {
                equipmentRepaymentRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
            })

            nbDaysField.on("input", () => {
                equipmentRepaymentTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)
                equipmentRepaymentRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
            })

            nbHoursField.on("input", () => {
                equipmentRepaymentTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)
                equipmentRepaymentRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
            })
        }
    })

    /**
     * Calback onRemoveItem.
     */
    $(".dynamicform_wrapper_equipment").on("afterDelete", (e) => {
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
     * Commence toujours avec le nombre d'éléments lors de l'initialisation (soit 1 à l'init, ce qui veut dire que la première ligne sera la numéro 0).
     */
    let nbContributorLineDuplicated = addedContributorsOnInit.length - 1

    /**
     * Calback onAddItem.
     * Permet de gérer les callback des futurs éléments que l'utilisateur pourra créer.
     */
    $(".dynamicform_wrapper_contributor").on("afterInsert", (e, item) => {
        nbContributorLineDuplicated++
        hideContributorRisk(isPreProject)

        initNewLaboratoryContributorAdded(nbContributorLineDuplicated)

        for (let i = 0; i <= nbContributorLineDuplicated; i++) {
            const nbDaysField = $(`#projectcreatelaboratorycontributorform-${i}-nb_days`)
            const nbHoursField = $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`)
            const dailyPriceField = $(`#projectcreatelaboratorycontributorform-${i}-daily_price`)
            const totalPriceField = $(`#projectcreatelaboratorycontributorform-${i}-price`)
            const timeRiskStringifyField = $(`#projectcreatelaboratorycontributorform-${i}-timeriskstringify`)
            const riskSelector = $(`#projectcreatelaboratorycontributorform-${i}-riskselected`)

            hideContributorRisk(isPreProject, i)
            laboratoryContributorTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)
            laboratoryContributorRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)

            riskSelector.change(() => {
                laboratoryContributorRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
            })

            dailyPriceField.on("input", () => {
                laboratoryContributorTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)
            })

            nbDaysField.on("input", () => {
                laboratoryContributorTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)
                laboratoryContributorRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
            })

            nbHoursField.on("input", () => {
                laboratoryContributorTotalPriceUpdate(nbDaysField, nbHoursField, dailyPriceField, totalPriceField)
                laboratoryContributorRiskTimeUpdate(nbDaysField, nbHoursField, timeRiskStringifyField, i)
            })
        }
    })

    $(".dynamicform_wrapper_contributor").on("afterDelete", (e) => {
        nbContributorLineDuplicated--
    })
})

//#region Liste des fonctions js

/**
 * Fonction qui permet de retourner le risque sélectionné sur un élément précis du dynamicView des matériels.
 * @param {*} risksData - Une liste d'objet risque que l'on a au préalable injecté dans la liste déroulante.
 * @param {*} index - Numéro de l'item précis dont on souhaite connaitre l'équipement sélectionné
 */
const getValueFromEquipmentRiskSelectedByIndex = (risksData, index = 0, number) => {
    return risksData[$(`#projectcreateequipmentrepaymentform-${index}-riskselected option:selected`).val()]
}

/**
 * Fonction qui permet de retourner le risque sélectionné sur un élément précis du dynamicView des matériels.
 * @param {*} risksData - Une liste d'objet risque que l'on a au préalable injecté dans la liste déroulante.
 * @param {*} index - Numéro de l'item précis dont on souhaite connaitre l'équipement sélectionné
 */
const getValueFromContributorRiskSelectedByIndex = (risksData, index = 0) => {
    return risksData[$(`#projectcreatelaboratorycontributorform-${index}-riskselected option:selected`).val()]
}

/**
 * Fonction qui va être utilisé pour faire le calcul du coût.
 * @param {*} nbDay - Nombre de jour
 * @param {*} nbHour - Nombre d'heure
 * @param {*} daily_price - Le prix renseigné par l'utilisateur
 *
 * @returns Un prix.
 */
const calculateEquipmentPrice = (nbDay, nbHour, daily_price) => {
    return (daily_price * nbDay + (daily_price / laboxyTimeDay) * nbHour).toFixed(2)
}

/**
 * Fonction qui va être utilisé pour faire le calcul du coût d'un contributeur.
 * @param {*} nbDay - Nombre de jours
 * @param {*} nbHour - Nombre d'heures
 * @param {*} daily_price - Un prix
 *
 * @returns Un prix.
 */
const calculateContributorPrice = (nbDay, nbHour, daily_price) => {
    return (daily_price * nbDay + (daily_price / laboxyTimeDay) * nbHour).toFixed(2)
}

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

    riskHour = Math.round(riskHour + decimalDay * laboxyTimeDay)
    const additionalDay = Math.trunc(riskHour / laboxyTimeDay)
    riskHour = riskHour % laboxyTimeDay

    riskDay = additionalDay + riskDay
    return { riskDay, riskHour }
}

/**
 * Fonction que l'on va utiliser pour retourner l'affichage du temps généré au bon format.
 * @param {*} riskDay
 * @param {*} riskHour
 */
const stringifyRiskTime = (riskDay = 0, riskHour = 0) => {
    return `${parseFloat(riskDay).toFixed(0)}j ${parseFloat(riskHour).toFixed(0)}h`
}

/**
 * Fonction assez simple qui va regarder l'id du laboratoire associé à l'équipement fournit en paramètre.
 * Grâce à celui-ci, il va pouvoir retourner un index correspondant à l'item précis de la liste déroulante par rapport au tableau d'éléments enrengistré dans le second paramètre.
 * Si il n'y a pas d'id de l'aboratoire, l'index retourné est 0.
 * @param {*} equipementElem
 */
const getIndexSelectorOfEquipment = (equipementElem, equipmentsLocalStateList) => {
    if (!equipementElem.repayment.null) return 0
}

/**
 * Fonction qui permet de cacher l'une liste sélectionnable des risques.
 * @param {*} number
 */
const hideEquipmentRisk = (bool) => {
    if (bool) {
        $(`.equipment_risk`).hide()
    }
}

/**
 * Fonction qui permet de cacher une des liste sélectionnable des risques.
 * @param {*} number
 */
const hideContributorRisk = (bool) => {
    if (bool) {
        $(`.contributor_risk`).hide()
    }
}

/**
 * Fonction qui permet de cacher la cardview qui gère les investissements éventuels.
 * @param {boolean} bool
 */
const hideCardInvestPlus = (bool) => {
    if (bool) $("#card-invest-plus").hide()
}

/**
 * Fonction qui permet de définir une valeur par défaut à chaque champs d'un nouvel élément equipement_repayment ajouté.
 * @param {*} index
 */
const initNewEquipementRepaymentAdded = (index) => {
    const dayField = $(`#projectcreateequipmentrepaymentform-${index}-nb_days`)
    const hourField = $(`#projectcreateequipmentrepaymentform-${index}-nb_hours`)
    const dailyPriceField = $(`#projectcreateequipmentrepaymentform-${index}-daily_price`)

    if (!dayField.val()) dayField.val(1)

    if (!hourField.val()) hourField.val(0)

    if (!dailyPriceField.val()) dailyPriceField.val(0)
}

/**
 * Fonction qui permet de définir une valeur par défaut à chaque champs d'un nouvel élément laboratory_contributor  ajouté.
 * @param {*} index
 */
const initNewLaboratoryContributorAdded = (index) => {
    const dayField = $(`#projectcreatelaboratorycontributorform-${index}-nb_days`)
    const hourField = $(`#projectcreatelaboratorycontributorform-${index}-nb_hours`)
    const dailyPriceField = $(`#projectcreatelaboratorycontributorform-${index}-daily_price`)

    if (!dayField.val()) dayField.val(1)

    if (!hourField.val()) hourField.val(0)

    if (!dailyPriceField.val()) dailyPriceField.val(0)
}

/**
 * On calcul le coût de risque de l'équipement inscrit dans l'élément corresponant à l'index i.
 * Si aucunes données ne permet de calculer le coût de risque, on part du principe que le jour et l'heure rentré est équivalent à 0,
 * @param {*} nbDaysField
 * @param {*} nbHoursField
 * @param {*} timeRiskStringifyField
 */
const equipmentRepaymentRiskTimeUpdate = (nbDaysField, nbHoursField, timeRiskStringifyField, index) => {
    const riskObject = calculateRiskTime(
        !nbDaysField.val() ? 0 : nbDaysField.val(),
        !nbHoursField.val() ? 0 : nbHoursField.val(),
        getValueFromEquipmentRiskSelectedByIndex(risksData, index, number),
    )
    timeRiskStringifyField.val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
}

/**
 * On calcul le coût d'utilisation de l'équipement inscrit dans l'élément corresponant à l'index i.
 * Si aucunes données ne permet de calculer le coût, on part du principe que le jour et l'heure rentré est équivalent à 0,
 * @param {*} nbDaysField
 * @param {*} nbHoursField
 * @param {*} dailyPriceField
 */
const equipmentRepaymentTotalPriceUpdate = (nbDaysField, nbHoursField, dailyPriceField, totalPriceField) => {
    const result = calculateEquipmentPrice(
        !nbDaysField.val() ? 0 : nbDaysField.val(),
        !nbHoursField.val() ? 0 : nbHoursField.val(),
        !dailyPriceField.val() ? 0 : dailyPriceField.val(),
    )
    totalPriceField.val(result)
}

/**
 *
 * @param {*} nbDaysField
 * @param {*} nbHoursField
 * @param {*} timeRiskStringifyField
 */
const laboratoryContributorRiskTimeUpdate = (nbDaysField, nbHoursField, timeRiskStringifyField, index) => {
    const riskObject = calculateRiskTime(
        !nbDaysField.val() ? 0 : nbDaysField.val(),
        !nbHoursField.val() ? 0 : nbHoursField.val(),
        getValueFromContributorRiskSelectedByIndex(risksData, index),
    )
    timeRiskStringifyField.val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
}

/**
 *
 * @param {*} nbDaysField
 * @param {*} nbHoursField
 * @param {*} dailyPriceField
 * @param {*} totalPriceField
 */
const laboratoryContributorTotalPriceUpdate = (nbDaysField, nbHoursField, dailyPriceField, totalPriceField) => {
    const result = calculateContributorPrice(
        !nbDaysField.val() ? 0 : nbDaysField.val(),
        !nbHoursField.val() ? 0 : nbHoursField.val(),
        !dailyPriceField.val() ? 0 : dailyPriceField.val(),
    )
    totalPriceField.val(result)
}

//#endregion
