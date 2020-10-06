// Initialisation des données sous format d'objet Javascript.
const laboratoriesData = JSON.parse(
    document.getElementById("laboratories-data-target").textContent
);
const risksData = JSON.parse(
    document.getElementById("risks-data-target").textContent
);

// Liste d'informations relatives au données qui enreichissent le dynamicForm.
const infoData = JSON.parse(
    document.getElementById("info-data-target").textContent
);

// Laboratoire sélectionné.
const laboratorySelected =
    infoData.laboratorySelected !== null ? infoData.laboratorySelected : 0;

// Données des éléments précédements sauvegardé à partir des dynamicForm.
const addedConsummablesOnInit = infoData.consummables;
const addedInvestsOnInit = infoData.invests;
const addedEquipementsOnInit = infoData.equipments;
const addedContributorsOnInit = infoData.contributors;

const number = infoData.number;
const laboxyTimeDay = 7.7;

/**
 * Constante que j'utilise pour savoir si le lot actuel de la vue est un lot d'avant projet, c'est-à-dire un lot dont le numéro est égale à 0.
 */
const isPreProject = number === '"0"';

/**
 * Scope d'initialisation pour préparer le calcul de temps + prix.
 */
$(() => {
    /**
     * On cache certains éléments suivant le numéro du lot en cours de modification.
     */
    hideCardInvestPlus(isPreProject);
    hideEquipmentRisk(isPreProject);
    hideContributorRisk(isPreProject);

    // Quand l'id du premier élément de la liste addedEquipementsOnInit est null, c'est qu'aucun élément n'a été précédement ajouté, ou tous les éléments ont été retiré à la dernière sauvegarde.
    // En résumé, cela veut juste dire que sur la vue, il n'y a aucun équipement d'affiché. On ne fait donc aucun calcul.
    if (addedEquipementsOnInit[0].id != null) {
        addedEquipementsOnInit.forEach((elem, i) => {
            const nbDaysField = $(
                `#projectcreateequipmentrepaymentform-${i}-nb_days`
            );
            const nbHoursField = $(
                `#projectcreateequipmentrepaymentform-${i}-nb_hours`
            );
            const timeRiskStringifyField = $(
                `#projectcreateequipmentrepaymentform-${i}-timeriskstringify`
            );
            const dailyPriceField = $(
                `#projectcreateequipmentrepaymentform-${i}-daily_price`
            );
            const totalPriceField = $(
                `#projectcreateequipmentrepaymentform-${i}-price`
            );
            const riskSelector = $(
                `#projectcreateequipmentrepaymentform-${i}-riskselected`
            );

            initNewEquipementRepaymentAdded(i);
            let riskObject = equipmentRepaymentRiskTimeUpdate(
                nbDaysField,
                nbHoursField,
                timeRiskStringifyField,
                i
            );
            equipmentRepaymentTotalPriceUpdate(
                riskObject.riskDay,
                riskObject.riskHour,
                dailyPriceField,
                totalPriceField
            );

            dailyPriceField.on("input", () => {
                let riskObject = equipmentRepaymentRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                equipmentRepaymentTotalPriceUpdate(
                    riskObject.riskDay,
                    riskObject.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });

            riskSelector.change(() => {
                let riskObject = equipmentRepaymentRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                equipmentRepaymentTotalPriceUpdate(
                    riskObject.riskDay,
                    riskObject.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });

            nbDaysField.on("input", () => {
                let riskObject = equipmentRepaymentRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                equipmentRepaymentTotalPriceUpdate(
                    riskObject.riskDay,
                    riskObject.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });

            nbHoursField.on("input", () => {
                let riskObject = equipmentRepaymentRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                equipmentRepaymentTotalPriceUpdate(
                    riskObject.riskDay,
                    riskObject.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });

            //getIndexSelectorOfEquipment(elem, equipmentsLocalStateList)
        });
    }

    // Quand l'id du premier élément de la liste addedContributorsOnInit est null, c'est qu'aucun élément n'a été précédement ajouté, ou tous les éléments ont été retiré à la dernière sauvegarde.
    // En résumé, cela veut juste dire que sur la vue, il n'y a aucun contributeurs d'affiché. On ne fait donc aucun calcul.
    if (addedContributorsOnInit[0].id != null) {
        addedContributorsOnInit.forEach((elem, i) => {
            const nbDaysField = $(
                `#projectcreatelaboratorycontributorform-${i}-nb_days`
            );
            const nbHoursField = $(
                `#projectcreatelaboratorycontributorform-${i}-nb_hours`
            );
            const dailyPriceField = $(
                `#projectcreatelaboratorycontributorform-${i}-daily_price`
            );
            const totalPriceField = $(
                `#projectcreatelaboratorycontributorform-${i}-price`
            );
            const timeRiskStringifyField = $(
                `#projectcreatelaboratorycontributorform-${i}-timeriskstringify`
            );
            const riskSelector = $(
                `#projectcreatelaboratorycontributorform-${i}-riskselected`
            );

            initNewLaboratoryContributorAdded(i);
            let riskObjectcont = laboratoryContributorRiskTimeUpdate(
                nbDaysField,
                nbHoursField,
                timeRiskStringifyField,
                i
            );
            laboratoryContributorTotalPriceUpdate(
                riskObjectcont.riskDay,
                riskObjectcont.riskHour,
                dailyPriceField,
                totalPriceField
            );

            riskSelector.change(() => {
                let riskObjectcont = laboratoryContributorRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                laboratoryContributorTotalPriceUpdate(
                    riskObjectcont.riskDay,
                    riskObjectcont.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });

            nbDaysField.on("input", () => {
                let riskObjectcont = laboratoryContributorRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                laboratoryContributorTotalPriceUpdate(
                    riskObjectcont.riskDay,
                    riskObjectcont.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });

            nbHoursField.on("input", () => {
                let riskObjectcont = laboratoryContributorRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                laboratoryContributorTotalPriceUpdate(
                    riskObjectcont.riskDay,
                    riskObjectcont.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });
        });
    }

    //end
});

/**
 * Scope Jquery qui soccupe de gérer la partie dynamique (calcul des coûts ect..) à chaque fois qu'un nouvel élément est ajouté.
 * GESTION MATERIELS/EQUIPEMENTS.
 */
$(() => {
    // Cette variable (let) stock le nombre d'équipement lors de l'initialisation de la vue. Si il y a aucun équipement sur la vue, cette variable est à 0.
    let nbEquipmentLinesDuplicated =
        addedEquipementsOnInit[0].id == null
            ? 0
            : addedEquipementsOnInit.length;
    // Si il n'y a aucun équipement, l'index maximum est égale à -1, sinon, l'élément 1 si il existe est égale à 0, puis 1, puis 2...n
    let nbMaxIndexEquipment = nbEquipmentLinesDuplicated - 1;

    hideOrShowMainButton(
        $("#button-equipment-first-add"),
        nbEquipmentLinesDuplicated
    );

    $(".dynamicform_wrapper_equipment").on("afterInsert", (e, item) => {
        nbMaxIndexEquipment++;
        nbEquipmentLinesDuplicated++;

        hideEquipmentRisk(isPreProject);
        hideOrShowMainButton(
            $("#button-equipment-first-add"),
            nbEquipmentLinesDuplicated
        );

        initNewEquipementRepaymentAdded(nbMaxIndexEquipment);

        for (let i = 0; i <= nbMaxIndexEquipment; i++) {
            const nbDaysField = $(
                `#projectcreateequipmentrepaymentform-${i}-nb_days`
            );
            const nbHoursField = $(
                `#projectcreateequipmentrepaymentform-${i}-nb_hours`
            );
            const timeRiskStringifyField = $(
                `#projectcreateequipmentrepaymentform-${i}-timeriskstringify`
            );
            const dailyPriceField = $(
                `#projectcreateequipmentrepaymentform-${i}-daily_price`
            );
            const totalPriceField = $(
                `#projectcreateequipmentrepaymentform-${i}-price`
            );
            const riskSelector = $(
                `#projectcreateequipmentrepaymentform-${i}-riskselected`
            );

            hideEquipmentRisk(isPreProject, i);

            let riskObject = equipmentRepaymentRiskTimeUpdate(
                nbDaysField,
                nbHoursField,
                timeRiskStringifyField,
                i
            );
            equipmentRepaymentTotalPriceUpdate(
                riskObject.riskDay,
                riskObject.riskHour,
                dailyPriceField,
                totalPriceField
            );

            dailyPriceField.on("input", () => {
                let riskObject = equipmentRepaymentRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                equipmentRepaymentTotalPriceUpdate(
                    riskObject.riskDay,
                    riskObject.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });

            riskSelector.change(() => {
                let riskObject = equipmentRepaymentRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                equipmentRepaymentTotalPriceUpdate(
                    riskObject.riskDay,
                    riskObject.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });

            nbDaysField.on("input", () => {
                let riskObject = equipmentRepaymentRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                equipmentRepaymentTotalPriceUpdate(
                    riskObject.riskDay,
                    riskObject.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });

            nbHoursField.on("input", () => {
                let riskObject = equipmentRepaymentRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                equipmentRepaymentTotalPriceUpdate(
                    riskObject.riskDay,
                    riskObject.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });
        }
    });

    $(".dynamicform_wrapper_equipment").on("beforeDelete", (e, item) =>
        confirm("Voulez-vous supprimer cet équipement ?")
    );

    $(".dynamicform_wrapper_equipment").on("afterDelete", (e) => {
        nbMaxIndexEquipment--;
        nbEquipmentLinesDuplicated--;
        hideOrShowMainButton(
            $("#button-equipment-first-add"),
            nbEquipmentLinesDuplicated
        );
    });
});

/**
 * Scope Jquery qui soccupe de gérer la partie dynamique (calcul des coûts ect..) à chaque fois qu'un nouvel élément est ajouté.
 * GESTION INTERVENANTS.
 */
$(() => {
    // Cette variable (let) stock le nombre d'équipement lors de l'initialisation de la vue. Si il y a aucun équipement sur la vue, cette variable est à 0.
    let nbContributorLinesDuplicated =
        addedContributorsOnInit[0].id == null
            ? 0
            : addedContributorsOnInit.length;
    // Si il n'y a aucun équipement, l'index maximum est égale à -1, sinon, l'élément 1 si il existe est égale à 0, puis 1, puis 2...n
    let nbMaxIndexContributor = nbContributorLinesDuplicated - 1;

    hideOrShowMainButton(
        $("#button-labocontributor-first-add"),
        nbContributorLinesDuplicated
    );

    /**
     * Calback onAddItem.
     * Permet de gérer les callback des futurs éléments que l'utilisateur pourra créer.
     */
    $(".dynamicform_wrapper_contributor").on("afterInsert", (e, item) => {
        nbMaxIndexContributor++;
        nbContributorLinesDuplicated++;

        hideContributorRisk(isPreProject);
        hideOrShowMainButton(
            $("#button-labocontributor-first-add"),
            nbContributorLinesDuplicated
        );
        initNewLaboratoryContributorAdded(nbMaxIndexContributor);

        for (let i = 0; i <= nbMaxIndexContributor; i++) {
            const nbDaysField = $(
                `#projectcreatelaboratorycontributorform-${i}-nb_days`
            );
            const nbHoursField = $(
                `#projectcreatelaboratorycontributorform-${i}-nb_hours`
            );
            const dailyPriceField = $(
                `#projectcreatelaboratorycontributorform-${i}-daily_price`
            );
            const totalPriceField = $(
                `#projectcreatelaboratorycontributorform-${i}-price`
            );
            const timeRiskStringifyField = $(
                `#projectcreatelaboratorycontributorform-${i}-timeriskstringify`
            );
            const riskSelector = $(
                `#projectcreatelaboratorycontributorform-${i}-riskselected`
            );

            hideContributorRisk(isPreProject, i);
            let riskObjectcont = laboratoryContributorRiskTimeUpdate(
                nbDaysField,
                nbHoursField,
                timeRiskStringifyField,
                i
            );
            laboratoryContributorTotalPriceUpdate(
                riskObjectcont.riskDay,
                riskObjectcont.riskHour,
                dailyPriceField,
                totalPriceField
            );

            riskSelector.change(() => {
                let riskObjectcont = laboratoryContributorRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                laboratoryContributorTotalPriceUpdate(
                    riskObjectcont.riskDay,
                    riskObjectcont.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });

            dailyPriceField.on("input", () => {
                let riskObjectcont = laboratoryContributorRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                laboratoryContributorTotalPriceUpdate(
                    riskObjectcont.riskDay,
                    riskObjectcont.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });

            nbDaysField.on("input", () => {
                let riskObjectcont = laboratoryContributorRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                laboratoryContributorTotalPriceUpdate(
                    riskObjectcont.riskDay,
                    riskObjectcont.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });

            nbHoursField.on("input", () => {
                let riskObjectcont = laboratoryContributorRiskTimeUpdate(
                    nbDaysField,
                    nbHoursField,
                    timeRiskStringifyField,
                    i
                );
                laboratoryContributorTotalPriceUpdate(
                    riskObjectcont.riskDay,
                    riskObjectcont.riskHour,
                    dailyPriceField,
                    totalPriceField
                );
            });
        }
    });

    $(".dynamicform_wrapper_contributor").on("beforeDelete", (e, item) =>
        confirm("Voulez-vous supprimer ce contributeur ?")
    );

    $(".dynamicform_wrapper_contributor").on("afterDelete", (e) => {
        nbMaxIndexContributor--;
        nbContributorLinesDuplicated--;
        hideOrShowMainButton(
            $("#button-labocontributor-first-add"),
            nbContributorLinesDuplicated
        );
    });
});

/**
 * Scope Jquery pour la gestion des consommables.
 */
$(() => {
    let nbConsummablesLinesDuplicated =
        addedConsummablesOnInit[0].id == null
            ? 0
            : addedConsummablesOnInit.length;
    hideOrShowMainButton(
        $("#button-consummable-first-add"),
        nbConsummablesLinesDuplicated
    );

    $(".dynamicform_wrapper_consumable").on("beforeDelete", (e, item) => {
        confirm("Voulez-vous supprimer ce consommable ?");
    });

    $(".dynamicform_wrapper_consumable").on("afterDelete", (e, item) => {
        nbConsummablesLinesDuplicated--;
        hideOrShowMainButton(
            $("#button-consummable-first-add"),
            nbConsummablesLinesDuplicated
        );
    });

    $(".dynamicform_wrapper_consumable").on("afterInsert", (e, item) => {
        nbConsummablesLinesDuplicated++;
        hideOrShowMainButton(
            $("#button-consummable-first-add"),
            nbConsummablesLinesDuplicated
        );
    });
});

/**
 * Scope Jquery pour la gestion des investissements.
 */
$(() => {
    if (!isPreProject) {
        let nbInvestsLinesDuplicated =
            addedInvestsOnInit[0].id == null ? 0 : addedInvestsOnInit.length;

        hideOrShowMainButton(
            $("#button-invests-first-add"),
            nbInvestsLinesDuplicated
        );

        $(".dynamicform_wrapper_invtest").on("beforeDelete", (e, item) => {
            confirm("Voulez-vous supprimer cet investissement ?");
        });

        $(".dynamicform_wrapper_invtest").on("afterDelete", (e, item) => {
            nbInvestsLinesDuplicated--;
            hideOrShowMainButton(
                $("#button-invests-first-add"),
                nbInvestsLinesDuplicated
            );
        });

        $(".dynamicform_wrapper_invtest").on("afterInsert", (e, item) => {
            nbInvestsLinesDuplicated++;
            hideOrShowMainButton(
                $("#button-invests-first-add"),
                nbInvestsLinesDuplicated
            );
        });
    }
});

//#region Liste des fonctions js

/**
 * Fonction qui permet de retourner le risque sélectionné sur un élément précis du dynamicView des matériels.
 * @param {*} risksData - Une liste d'objet risque que l'on a au préalable injecté dans la liste déroulante.
 * @param {*} index - Numéro de l'item précis dont on souhaite connaitre l'équipement sélectionné
 */
const getValueFromEquipmentRiskSelectedByIndex = (
    risksData,
    index = 0,
    number
) => {
    return risksData[
        $(
            `#projectcreateequipmentrepaymentform-${index}-riskselected option:selected`
        ).val()
    ];
};

/**
 * Fonction qui permet de retourner le risque sélectionné sur un élément précis du dynamicView des matériels.
 * @param {*} risksData - Une liste d'objet risque que l'on a au préalable injecté dans la liste déroulante.
 * @param {*} index - Numéro de l'item précis dont on souhaite connaitre l'équipement sélectionné
 */
const getValueFromContributorRiskSelectedByIndex = (risksData, index = 0) => {
    return risksData[
        $(
            `#projectcreatelaboratorycontributorform-${index}-riskselected option:selected`
        ).val()
    ];
};

/**
 * Fonction qui va être utilisé pour faire le calcul du coût.
 * @param {*} nbDay - Nombre de jour
 * @param {*} nbHour - Nombre d'heure
 * @param {*} daily_price - Le prix renseigné par l'utilisateur
 *
 * @returns Un prix.
 */
const calculateEquipmentPrice = (nbDay, nbHour, daily_price) => {
    return (
        ((nbDay * laboxyTimeDay + nbHour) * daily_price) /
        laboxyTimeDay
    ).toFixed(2);
};

/**
 * Fonction qui va être utilisé pour faire le calcul du coût d'un contributeur.
 * @param {*} nbDay - Nombre de jours
 * @param {*} nbHour - Nombre d'heures
 * @param {*} daily_price - Un prix
 *
 * @returns Un prix.
 */
const calculateContributorPrice = (nbDay, nbHour, daily_price) => {
    return (
        ((nbDay * laboxyTimeDay + nbHour) * daily_price) /
        laboxyTimeDay
    ).toFixed(2);
};

/**
 * Fonction qui va être utilisé pour calculer le temps d'incertitude par rapport au risque.
 * @param {*} nbDay - Nombre de jours
 * @param {*} nbHour - Nombre d'heures
 * @param {*} risk - Un objet risk
 *
 * @return Un objet avec deux valeurs de temps.
 */
const calculateRiskTime = (nbDay, nbHour, risk) => {
    let riskDay = nbDay * risk.coefficient;
    let riskHour = nbHour * risk.coefficient;

    const decimalDay = riskDay - Math.floor(riskDay);
    riskDay = Math.trunc(riskDay);

    riskHour = Math.round(riskHour + decimalDay * laboxyTimeDay);
    const additionalDay = Math.trunc(riskHour / laboxyTimeDay);
    riskHour = riskHour % laboxyTimeDay;

    riskDay = additionalDay + riskDay;
    return { riskDay, riskHour };
};

/**
 * Fonction que l'on va utiliser pour retourner l'affichage du temps généré au bon format.
 * @param {*} riskDay
 * @param {*} riskHour
 */
const stringifyRiskTime = (riskDay = 0, riskHour = 0) => {
    return `${parseFloat(riskDay).toFixed(0)}j ${parseFloat(riskHour).toFixed(
        0
    )}h`;
};

/**
 * Fonction assez simple qui va regarder l'id du laboratoire associé à l'équipement fournit en paramètre.
 * Grâce à celui-ci, il va pouvoir retourner un index correspondant à l'item précis de la liste déroulante par rapport au tableau d'éléments enrengistré dans le second paramètre.
 * Si il n'y a pas d'id de l'aboratoire, l'index retourné est 0.
 * @param {*} equipementElem
 */
const getIndexSelectorOfEquipment = (
    equipementElem,
    equipmentsLocalStateList
) => {
    if (!equipementElem.repayment.null) return 0;
};

/**
 * Fonction qui permet de cacher l'une liste sélectionnable des risques.
 * @param {*} number
 */
const hideEquipmentRisk = (bool) => {
    if (bool) {
        $(`.equipment_risk`).hide();
    }
};

/**
 * Fonction qui permet de cacher une des liste sélectionnable des risques.
 * @param {*} number
 */
const hideContributorRisk = (bool) => {
    if (bool) {
        $(`.contributor_risk`).hide();
    }
};

/**
 * Fonction qui permet de cacher la cardview qui gère les investissements éventuels.
 * @param {boolean} bool
 */
const hideCardInvestPlus = (bool) => {
    if (bool) $("#card-invest-plus").hide();
};

/**
 * Fonction qui permet de définir une valeur par défaut à chaque champs d'un nouvel élément equipement_repayment ajouté.
 * @param {*} index
 */
const initNewEquipementRepaymentAdded = (index) => {
    const dayField = $(`#projectcreateequipmentrepaymentform-${index}-nb_days`);
    const hourField = $(
        `#projectcreateequipmentrepaymentform-${index}-nb_hours`
    );
    const dailyPriceField = $(
        `#projectcreateequipmentrepaymentform-${index}-daily_price`
    );

    if (!dayField.val()) dayField.val(1);

    if (!hourField.val()) hourField.val(0);

    if (!dailyPriceField.val()) dailyPriceField.val(0);
};

/**
 * Fonction qui permet de définir une valeur par défaut à chaque champs d'un nouvel élément laboratory_contributor  ajouté.
 * @param {*} index
 */
const initNewLaboratoryContributorAdded = (index) => {
    const dayField = $(
        `#projectcreatelaboratorycontributorform-${index}-nb_days`
    );
    const hourField = $(
        `#projectcreatelaboratorycontributorform-${index}-nb_hours`
    );
    const dailyPriceField = $(
        `#projectcreatelaboratorycontributorform-${index}-daily_price`
    );

    if (!dayField.val()) dayField.val(1);

    if (!hourField.val()) hourField.val(0);

    if (!dailyPriceField.val()) dailyPriceField.val(0);
};

/**
 * On calcul le coût de risque de l'équipement inscrit dans l'élément corresponant à l'index i.
 * Si aucunes données ne permet de calculer le coût de risque, on part du principe que le jour et l'heure rentré est équivalent à 0,
 * @param {*} nbDaysField
 * @param {*} nbHoursField
 * @param {*} timeRiskStringifyField
 */
const equipmentRepaymentRiskTimeUpdate = (
    nbDaysField,
    nbHoursField,
    timeRiskStringifyField,
    index
) => {
    const riskObject = calculateRiskTime(
        !nbDaysField.val() ? 0 : nbDaysField.val(),
        !nbHoursField.val() ? 0 : nbHoursField.val(),
        getValueFromEquipmentRiskSelectedByIndex(risksData, index, number)
    );
    timeRiskStringifyField.val(
        stringifyRiskTime(riskObject.riskDay, riskObject.riskHour)
    );
    return riskObject;
};

/**
 * On calcul le coût d'utilisation de l'équipement inscrit dans l'élément corresponant à l'index i.
 * Si aucunes données ne permet de calculer le coût, on part du principe que le jour et l'heure rentré est équivalent à 0,
 * @param {*} nbDaysField
 * @param {*} nbHoursField
 * @param {*} dailyPriceField
 */
const equipmentRepaymentTotalPriceUpdate = (
    nbDaysField,
    nbHoursField,
    dailyPriceField,
    totalPriceField
) => {
    const result = calculateEquipmentPrice(
        nbDaysField,
        nbHoursField,
        !dailyPriceField.val() ? 0 : dailyPriceField.val()
    );
    console.log(nbDaysField);
    console.log(nbHoursField);
    totalPriceField.val(result);
};

/**
 * @param {*} nbDaysField
 * @param {*} nbHoursField
 * @param {*} timeRiskStringifyField
 */
const laboratoryContributorRiskTimeUpdate = (
    nbDaysField,
    nbHoursField,
    timeRiskStringifyField,
    index
) => {
    const riskObject = calculateRiskTime(
        !nbDaysField.val() ? 0 : nbDaysField.val(),
        !nbHoursField.val() ? 0 : nbHoursField.val(),
        getValueFromContributorRiskSelectedByIndex(risksData, index)
    );
    timeRiskStringifyField.val(
        stringifyRiskTime(riskObject.riskDay, riskObject.riskHour)
    );
    return riskObject;
};

/**
 *
 * @param {*} nbDaysField
 * @param {*} nbHoursField
 * @param {*} dailyPriceField
 * @param {*} totalPriceField
 */
const laboratoryContributorTotalPriceUpdate = (
    nbDaysField,
    nbHoursField,
    dailyPriceField,
    totalPriceField
) => {
    const result = calculateContributorPrice(
        nbDaysField,
        nbHoursField,
        !dailyPriceField.val() ? 0 : dailyPriceField.val()
    );
    totalPriceField.val(result);
};

/**
 * Fonction qui permet d'afficher ou non le bouton principal si le nombre de ligne dupliqué donné en paramètre est égale à 0.
 * @param {*} button
 * @param {*} nbLinesDuplicated
 */
const hideOrShowMainButton = (button, nbLinesDuplicated) => {
    if (nbLinesDuplicated == 0) button.show();
    else button.hide();
};

//#endregion
