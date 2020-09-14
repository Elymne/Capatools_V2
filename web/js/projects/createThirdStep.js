// Initialisation des données sous format d'objet Javascript.
const laboratoriesData = JSON.parse(document.getElementById("laboratories-data-target").textContent)
const risksData = JSON.parse(document.getElementById("risks-data-target").textContent)

// Liste d'informations relatives au données qui enreichissent le dynamicForm.
const infoData = JSON.parse(document.getElementById("info-data-target").textContent)

const laboratorySelected = infoData.laboratorySelected !== null ? infoData.laboratorySelected : 0
const addedEquipementsOnInit = infoData.equipments
const addedContributorsOnInit = infoData.contributors
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
        /**
         * On calcul le coût de risque de l'équipement inscrit dans l'élément corresponant à l'index i.
         * Si aucunes données ne permet de calculer le coût de risque, on part du principe que le jour et l'heure rentré est équivalent à 0,
         */
        const riskObject = calculateRiskTime(
            !$(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
            !$(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
            getValueFromEquipmentRiskSelectedByIndex(risksData, i, number),
        )
        $(`#projectcreateequipmentrepaymentform-${i}-timeriskstringify`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))

        /**
         * On calcul le coût d'utilisation de l'équipement inscrit dans l'élément corresponant à l'index i.
         * Si aucunes données ne permet de calculer le coût, on part du principe que le jour et l'heure rentré est équivalent à 0,
         */
        const result = calculateEquipmentPrice(
            !$(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
            !$(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
            !$(`#projectcreateequipmentrepaymentform-${i}-daily_price`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-daily_price`).val(),
        )
        $(`#projectcreateequipmentrepaymentform-${i}-price`).val(result)

        /**
         * Callback input sur le prix journalier pour modifier le prix total.
         */
        $(`#projectcreateequipmentrepaymentform-${i}-daily_price`).on("input", () => {
            const result = calculateEquipmentPrice(
                $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                !$(`#projectcreateequipmentrepaymentform-${i}-daily_price`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-daily_price`).val(),
            )

            $(`#projectcreateequipmentrepaymentform-${i}-price`).val(result)
        })

        /**
         * Callback onChange sur la liste déroulante des matériels du premier item.
         * Permet de recalculer le temps additionel lié au risque.
         */
        $(`#projectcreateequipmentrepaymentform-${i}-riskselected`).change(() => {
            const riskObject = calculateRiskTime(
                !$(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                !$(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                getValueFromEquipmentRiskSelectedByIndex(risksData, 0),
            )
            $(`#projectcreateequipmentrepaymentform-${i}-timeriskstringify`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
        })

        /**
         * Callback onInput sur le champ de sélection des jours d'utilisation d'un matériel.
         * Permet de reclaculer le coût d'utilisation d'un matériel.
         */
        $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).on("input", () => {
            const result = calculateEquipmentPrice(
                !$(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                !$(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                !$(`#projectcreateequipmentrepaymentform-${i}-daily_price`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-daily_price`).val(),
            )

            $(`#projectcreateequipmentrepaymentform-${i}-price`).val(result)

            const riskObject = calculateRiskTime(
                !$(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                !$(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                getValueFromEquipmentRiskSelectedByIndex(risksData, i),
            )
            $(`#projectcreateequipmentrepaymentform-${i}-timeriskstringify`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
        })

        /**
         * Callback onInput sur le champ de sélection des heures d'utilisation d'un matériel.
         * Permet de recalculer le coût d'utilisation d'un matériel.
         */
        $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).on("input", () => {
            const result = calculateEquipmentPrice(
                !$(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                !$(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                !$(`#projectcreateequipmentrepaymentform-${i}-daily_price`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-daily_price`).val(),
            )
            $(`#projectcreateequipmentrepaymentform-${i}-price`).val(result)
            const riskObject = calculateRiskTime(
                !$(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                !$(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                getValueFromEquipmentRiskSelectedByIndex(risksData, i),
            )
            $(`#projectcreateequipmentrepaymentform-${i}-timeriskstringify`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
        })

        //getIndexSelectorOfEquipment(elem, equipmentsLocalStateList)
    })

    addedContributorsOnInit.forEach((elem, i) => {
        /**
         * Mise en place des valeur par défaut dans les prix et les co$uts en temps.
         */
        const result = calculateContributorPrice(
            !$(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
            !$(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
            !$(`#projectcreatelaboratorycontributorform-${i}-daily_price`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-daily_price`).val(),
        )
        $(`#projectcreatelaboratorycontributorform-${i}-price`).val(result)

        const riskObject = calculateRiskTime(
            !$(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
            !$(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
            getValueFromContributorRiskSelectedByIndex(risksData, 0),
        )
        $(`#projectcreatelaboratorycontributorform-${i}-timeriskstringify`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))

        /**
         * Callback onChange sur la liste déroulante des matériels du premier item.
         * Permet de recalculer le temps additionel lié au risque.
         */
        $(`#projectcreatelaboratorycontributorform-${i}-riskselected`).change(() => {
            const riskObject = calculateRiskTime(
                !$(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                !$(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                getValueFromContributorRiskSelectedByIndex(risksData, i),
            )
            $(`#projectcreatelaboratorycontributorform-${i}-timeriskstringify`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
        })

        /**
         * Calbacl onInput sur le champ de sélection du prix journalier pris par un intervenant labo.
         * Permet de recalculer le coût d'une intervention.
         */
        $(`#projectcreatelaboratorycontributorform-${i}-daily_price`).on("input", () => {
            console.log($(`#projectcreatelaboratorycontributorform-${i}-daily_price`).val())

            const result = calculateContributorPrice(
                !$(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                !$(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                !$(`#projectcreatelaboratorycontributorform-${i}-daily_price`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-daily_price`).val(),
            )
            $(`#projectcreatelaboratorycontributorform-${i}-price`).val(result)
        })

        /**
         * Calbacl onInput sur le champ de sélection des jours pris par un intervenant labo.
         * Permet de recalculer le coût d'une intervention.
         */
        $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).on("input", () => {
            const result = calculateContributorPrice(
                !$(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                !$(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                !$(`#projectcreatelaboratorycontributorform-${i}-daily_price`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-daily_price`).val(),
            )
            $(`#projectcreatelaboratorycontributorform-${i}-price`).val(result)

            const riskObject = calculateRiskTime(
                !$(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                !$(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                getValueFromContributorRiskSelectedByIndex(risksData, 0),
            )
            $(`#projectcreatelaboratorycontributorform-${i}-timeriskstringify`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
        })

        /**
         * Calbacl onInput sur le champ de sélection des heures pris par un intervenant labo.
         * Permet de recalculer le coût d'une intervention.
         */
        $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).on("input", () => {
            const result = calculateContributorPrice(
                !$(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                !$(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                !$(`#projectcreatelaboratorycontributorform-${i}-daily_price`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-daily_price`).val(),
            )
            $(`#projectcreatelaboratorycontributorform-${i}-price`).val(result)

            const riskObject = calculateRiskTime(
                !$(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                !$(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val() ? 0 : $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                getValueFromContributorRiskSelectedByIndex(risksData, 0),
            )
            $(`#projectcreatelaboratorycontributorform-${i}-timeriskstringify`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
        })
    })
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

        // Par défaut, le temps généré par le risque est à 0.
        $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-timeriskstringify`).val(stringifyRiskTime())

        // Par défaut, le coût généré est de 0.
        $(`#projectcreateequipmentrepaymentform-${nbEquipmentLineDuplicated}-price`).val(0)

        for (let i = 0; i <= nbEquipmentLineDuplicated; i++) {
            /**
             * Cache la liste des risques si le lot est le n°0
             */
            hideEquipmentRisk(isPreProject, i)

            /**
             * Callback input sur le prix journalier pour modifier le prix total.
             */
            $(`#projectcreateequipmentrepaymentform-${i}-daily_price`).on("input", () => {
                console.log("HAHA")

                const result = calculateEquipmentPrice(
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                    !$(`#projectcreateequipmentrepaymentform-${i}-daily_price`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-daily_price`).val(),
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
                $(`#projectcreateequipmentrepaymentform-${i}-timeriskstringify`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
            })

            /**
             * Callback onInput sur le champ de sélection des jours d'utilisation d'un élément matériel ajouté.
             * Permet de reclaculer le coût d'utilisation d'un matériel.
             */
            $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).on("input", () => {
                const result = calculateEquipmentPrice(
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                    !$(`#projectcreateequipmentrepaymentform-${i}-daily_price`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-daily_price`).val(),
                )
                $(`#projectcreateequipmentrepaymentform-${i}-price`).val(result)
                const riskObject = calculateRiskTime(
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                    getValueFromEquipmentRiskSelectedByIndex(risksData, i),
                )
                $(`#projectcreateequipmentrepaymentform-${i}-timeriskstringify`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
            })

            /**
             * Callback onInput sur le champ de sélection des heures d'utilisation d'un élément matériel ajouté.
             * Permet de recalculer le coût d'utilisation d'un matériel.
             */
            $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).on("input", () => {
                const result = calculateEquipmentPrice(
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                    !$(`#projectcreateequipmentrepaymentform-${i}-daily_price`).val() ? 0 : $(`#projectcreateequipmentrepaymentform-${i}-daily_price`).val(),
                )
                $(`#projectcreateequipmentrepaymentform-${i}-price`).val(result)
                const riskObject = calculateRiskTime(
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_days`).val(),
                    $(`#projectcreateequipmentrepaymentform-${i}-nb_hours`).val(),
                    getValueFromEquipmentRiskSelectedByIndex(risksData, 0),
                )
                $(`#projectcreateequipmentrepaymentform-${i}-timeriskstringify`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
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

        // Par défaut, le temps généré par le risque est à 0.
        $(`#projectcreatelaboratorycontributorform-${nbContributorLineDuplicated}-timeriskstringify`).val(stringifyRiskTime())

        // Par défaut, le coût généré est de 0.
        $(`#projectcreatelaboratorycontributorform-${nbContributorLineDuplicated}-price`).val(0)

        for (let i = 0; i <= nbContributorLineDuplicated; i++) {
            /**
             *
             */
            hideContributorRisk(isPreProject, i)

            /**
             * Callback onChange sur la liste déroulante des matériels du premier item.
             * Permet de recalculer le temps additionel lié au risque.
             */
            $(`#projectcreatelaboratorycontributorform-${i}-riskselected`).change(() => {
                const riskObject = calculateRiskTime(
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                    getValueFromContributorRiskSelectedByIndex(risksData, i),
                )
                $(`#projectcreatelaboratorycontributorform-${i}-timeriskstringify`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
            })

            /**
             * Calbacl onInput sur le champ de sélection du prix journalier pris par un intervenant labo.
             * Permet de recalculer le coût d'une intervention.
             */
            $(`#projectcreatelaboratorycontributorform-${i}-daily_price`).on("input", () => {
                console.log($(`#projectcreatelaboratorycontributorform-${i}-daily_price`).val())

                const result = calculateContributorPrice(
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                    $(`#projectcreatelaboratorycontributorform-${i}-daily_price`).val(),
                )
                $(`#projectcreatelaboratorycontributorform-${i}-price`).val(result)
            })

            /**
             * Callback onInput sur le champ de sélection des jours pris par un intervenant.
             * Permet de reclaculer le coût d'un intervenant.
             */
            $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).on("input", () => {
                const result = calculateContributorPrice(
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                    $(`#projectcreatelaboratorycontributorform-${i}-daily_price`).val(),
                )
                $(`#projectcreatelaboratorycontributorform-${i}-price`).val(result)

                const riskObject = calculateRiskTime(
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                    getValueFromContributorRiskSelectedByIndex(risksData, i),
                )
                $(`#projectcreatelaboratorycontributorform-${i}-timeriskstringify`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
            })

            /**
             * Callback onInput sur le champ de sélection des heures prises par un intervenant.
             * Permet de reclaculer le coût d'un intervenant.
             */
            $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).on("input", () => {
                const result = calculateContributorPrice(
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                    $(`#projectcreatelaboratorycontributorform-${i}-daily_price`).val(),
                )
                $(`#projectcreatelaboratorycontributorform-${i}-price`).val(result)

                const riskObject = calculateRiskTime(
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_days`).val(),
                    $(`#projectcreatelaboratorycontributorform-${i}-nb_hours`).val(),
                    getValueFromContributorRiskSelectedByIndex(risksData, i),
                )
                $(`#projectcreatelaboratorycontributorform-${i}-timeriskstringify`).val(stringifyRiskTime(riskObject.riskDay, riskObject.riskHour))
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
const getValueFromEquipmentRiskSelectedByIndex = (risksData, index = 0, number) =>
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
 * @param {*} daily_price - Le prix renseigné par l'utilisateur
 *
 * @returns Un prix.
 */
const calculateEquipmentPrice = (nbDay, nbHour, daily_price) => (daily_price * nbDay + (daily_price / 7) * nbHour).toFixed(2)

/**
 * Fonction qui va être utilisé pour faire le calcul du coût d'un contributeur.
 * @param {*} nbDay - Nombre de jours
 * @param {*} nbHour - Nombre d'heures
 * @param {*} daily_price - Un prix
 *
 * @returns Un prix.
 */
const calculateContributorPrice = (nbDay, nbHour, daily_price) => (daily_price * nbDay + (daily_price / 7) * nbHour).toFixed(2)

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
 * @param {*} bool
 */
const hideCardInvestPlus = (bool) => {
    if (bool) $("#card-invest-plus").hide()
}

//#endregion
