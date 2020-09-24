// Ces variables servent à stocker l'états de certains champs de filtres.
let nameTextFilter = "" // Stocke le filtre INTERNAL_NAME - Nom du projet. (input text)
let numberTextFilter = "" // Stocke le filtre NUMBER - Le numéro de jalon. (input text)
let celluleFilter = "" // Stocke le filtre CELLULE - La cellule. (select list)
let celluleFilterIndex = "" // Stocke l'index de filtre de la cellule.

// Stocke les valeurs des combobox.
let statusInProg = false
let statusFacturing = false
let statusFactured = false
let statusPayed = false

const stateList = {
    inProg: "En cours",
    facturing: "Facturation en cours",
    factured: "Facturé",
    payed: "Payé",
}

$(() => {
    // On lance cette fonction pour regarder l'état des combobox et lancer le filtrage à l'init de la vue.
    projectNameFilterUpdate()
    NumberFilterUpdate()
    celluleNameFilterUpdate()
    statusFilterUpdate()

    startFiltering()
})

/**
 * Fonction qu'on utilise comme callback lorsqu'un utilisateur rentre un champs dans l'input qui sert à filtrer les noms.
 * Elle sert à filtrer les jalons par nom interne.
 */
const onInputNameChange = () => {
    projectNameFilterUpdate()
    startFiltering()
}

/**
 * Fonction qui met à jour les variable de la page jquery concernant les noms de projets.
 */
const projectNameFilterUpdate = () => {
    const input = document.getElementById("project-name-search")
    nameTextFilter = input.value.toUpperCase()
}

/**
 * Fonction qu'on utilise comme callback lorsqu'un utilisateur rentre un champs dans l'input qui sert à filtrer les numéro de jalon.
 * Elle sert à filtrer les jalons par nom interne.
 */
const onInputNumberChange = () => {
    NumberFilterUpdate()
    startFiltering()
}

/**
 * Fonction qui met à jour les variable de la page jquery concernant les numéro de jalons..
 */
const NumberFilterUpdate = () => {
    const input = document.getElementById("project-number-search")
    numberTextFilter = input.value.toUpperCase()
}

/**
 * Fonction qu'on utilise comme callback lorsqu'un utilisateur sélectionne une cellule dans la liste déroulante.
 * Elle sert à filtrer les jalons par cellule.
 */
const onSelectCelluleChange = () => {
    celluleNameFilterUpdate()
    startFiltering()
}

/**
 * Fonction qui met à jour les variable de la page jquery concernant les cellules..
 */
const celluleNameFilterUpdate = () => {
    const celluleNameSelector = $("#selectlist-cellule-search")
    celluleFilter = celluleNameSelector.children("option:selected").html().toUpperCase()
    celluleFilterIndex = celluleNameSelector.children("option:selected").val()
}

/**
 * Fonction qu'on utilise comme callback lorsqu'un utilisateur check une des checkbox de status.
 * Elle sert à filtrer les jalons par cellule.
 */
const onCheckboxStatusChange = () => {
    statusFilterUpdate()
    startFiltering()
}

/**
 * Fonction qui met à jour les variable de la page jquery concernant les statuts.
 */
const statusFilterUpdate = () => {
    statusInProg = document.querySelector('input[id="inprog-checkbox"]').checked
    statusFacturing = document.querySelector('input[id="inprog-checkbox"]').checked
    statusFactured = document.querySelector('input[id="inprog-checkbox"]').checked
    statusPayed = document.querySelector('input[id="inprog-checkbox"]').checked
}

/**
 * Fonction qui permet de commencer à filtrer le gridview en prennant en compte toutes les valeurs des inputText modifiés par l'utilisateur.
 */
const startFiltering = () => {
    const table = document.getElementById("milestones_table")
    const tbody = table.getElementsByTagName("tbody")[0]
    const tr = tbody.getElementsByTagName("tr")

    for (let i = 0; i < tr.length; i++) {
        const tdInternalName = tr[i].getElementsByClassName("project-internal_name-row")[0]
        const tdNumber = tr[i].getElementsByClassName("project-number-row")[0]
        const tdCellule = tr[i].getElementsByClassName("project-cellule-row")[0]
        const tdInProgStatus = tr[i].getElementsByClassName("project-status-row")[0]

        const txtValueInternalName = tdInternalName.textContent || tdInternalName.innerText
        const txtValueNumber = tdNumber.textContent || tdNumber.innerText
        const txtValueCellule = tdCellule.textContent || tdCellule.innerText
        const txtValueStatus = tdInProgStatus.textContent || tdInProgStatus.innerText

        const isInternalName = txtValueInternalName.toUpperCase().indexOf(nameTextFilter) > -1
        const isNumber = txtValueNumber.toUpperCase().indexOf(numberTextFilter) > -1
        const isCellule = txtValueCellule.toUpperCase().indexOf(celluleFilter) > -1 || celluleFilterIndex == ""

        const isStatusInProg = statusInProg && txtValueStatus.toUpperCase() == stateList.inProg.toUpperCase()
        const isStatusFacturing = statusFacturing && txtValueStatus.toUpperCase() == stateList.facturing.toUpperCase()
        const isStatusFactured = statusFactured && txtValueStatus.toUpperCase() == stateList.factured.toUpperCase()
        const isStatusPayed = statusPayed && txtValueStatus.toUpperCase() == stateList.payed.toUpperCase()

        if (isInternalName && isNumber && isCellule && (isStatusInProg || isStatusFacturing || isStatusFactured || isStatusPayed)) {
            tr[i].style.display = ""
        } else {
            tr[i].style.display = "none"
        }
    }
}
