let nameTextFilter = ""; // Stocke le filtre INTERNAL_NAME - (input text)
let nameTypeFilter = ""; // Stocke le filtre INTERNAL_Type - (input text)

/**
 * Permet de filtrer les lignes affichés dans le tabeaux d'éléments contanant les laboratoires
 * par rapport à la chaîne entrée dans le champ de recherche de nom de laboratoire.
 */
const documentNameFilterSearch = () => {
    // Declare variables
    var input, filter, table, tbody, tr, td, i, txtValue;
    input = document.getElementById("document-name-search");
    filter = input.value.toUpperCase();
    table = document.getElementById("admin_table");
    tbody = table.getElementsByTagName("tbody")[0];
    tr = tbody.getElementsByTagName("tr");

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByClassName("name-row")[0];
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
};
/**
 * Fonction qu'on utilise comme callback lorsqu'un utilisateur sélectionne une cellule dans la liste déroulante.
 * Elle sert à filtrer les jalons par cellule.
 */
const onSelectTypeChange = () => {
    TypeNameFilterUpdate();
    startFiltering();
};
/**
 * Fonction qui met à jour les variable de la page jquery concernant les noms de projets.
 */
const documentNameFilterUpdate = () => {
    const input = document.getElementById("indexdocument-name-search");
    nameTextFilter = input.value.toUpperCase();
};

/**
 * Fonction qui met à jour les variable de la page jquery concernant les noms de projets.
 */
const TypeNameFilterUpdate = () => {
    const input = document.getElementById("type-name-search");
    nameTypeFilter = input.value.toUpperCase();
};
/**
 * Fonction qu'on utilise comme callback lorsqu'un utilisateur rentre un champs dans l'input qui sert à filtrer les noms.
 * Elle sert à filtrer les document par nom interne.
 */
const onInputDocumentNameChange = () => {
    documentNameFilterUpdate();
    startFiltering();
};

/**
 * Fonction qui permet de commencer à filtrer le gridview en prennant en compte toutes les valeurs des inputText modifiés par l'utilisateur.
 */
const startFiltering = () => {
    const table = document.getElementById("document_table");
    const tbody = table.getElementsByTagName("tbody")[0];
    const tr = tbody.getElementsByTagName("tr");

    for (let i = 0; i < tr.length; i++) {
        const tdInternalName = tr[i].getElementsByClassName(
            "document-internal_name-row"
        )[0];

        const tdInternaltype = tr[i].getElementsByClassName(
            "document-internal_type-row"
        )[0];

        const txtValueInternalName =
            tdInternalName.textContent || tdInternalName.innerText;
        const txtValueInternaltype =
            tdInternaltype.textContent || tdInternaltype.innerText;

        const isInternalName =
            txtValueInternalName.toUpperCase().indexOf(nameTextFilter) > -1;
        const isInternalType =
            txtValueInternaltype.toUpperCase().indexOf(nameTypeFilter) > -1;

        if (isInternalName && isInternalType) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
};
