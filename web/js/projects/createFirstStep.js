/**
 * Gestion du JQUERY dans la première étape de la création d'un projet.
 */
$(() => {
    let duplicatedLots = 0

    //frameElement()
    $(".dynamicform_wrapper").on("beforeDelete", (e, item) => {
        confirm("Etes-vous sûr de vouloir supprimer ce lot ?")
    })

    $(".dynamicform_wrapper").on("afterDelete", (e, item) => {
        duplicatedLots--

        //Je reorganise tout les N° de lot
        let regex = new RegExp("projectcreatelotform-([0-9]*)-id_string", "gim")
        let array1
        //
        while ((array1 = regex.exec(document.body.innerHTML)) !== null) {
            let element = parseInt(array1[1])
            let id_string = "#projectcreatelotform-" + element + "-id_string"
            element += 1
            $(id_string).val("Lot N°" + element + " ")
        }

        hideOrShowMainButton($("#button-lot-first-add"), duplicatedLots)
    })

    $(".dynamicform_wrapper").on("afterInsert", (e, item) => {
        duplicatedLots++

        //Recherche de l'index courrent
        let seletect = item.innerHTML
        let regex = new RegExp("projectcreatelotform-([0-9]*)-id_string")
        let arr = regex.exec(seletect)
        let index = parseInt(arr[1])
        let id_string = "#projectcreatelotform-" + index + "-id_string"
        $(id_string).val("Lot N°" + (index + 1) + " ")

        hideOrShowMainButton($("#button-lot-first-add"), duplicatedLots)
    })
})

/**
 * Fonction qui permet d'afficher ou non le bouton principal si le nombre de ligne dupliqué donné en paramètre est égale à 0.
 * @param {*} button
 * @param {*} nbLinesDuplicated
 */
const hideOrShowMainButton = (button, nbLinesDuplicated) => {
    if (nbLinesDuplicated == 0) button.show()
    else button.hide()
}
