/**
 * On load.
 */
$(() => {
    const tcVal = "PROJET TERMINÉ";
    const paVal = "PROJET ANNULÉ";

    const table = document.getElementById("devis_table");
    const tbody = table.getElementsByTagName("tbody")[0];
    const tr = tbody.getElementsByTagName("tr");

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByClassName("status-row")[0];
        txtValue = td.textContent || td.innerText;
        if (
            txtValue.toUpperCase() == tcVal ||
            txtValue.toUpperCase() == paVal
        ) {
            tr[i].style.display = "none";
        } else {
            tr[i].style.display = "";
        }
    }
});

/**
 * Manage table checkbox displaying.
 */
$(() => {
    /**
     * Attributes
     */
    const capaIdCheckbox = document.querySelector(
        'input[id="capaid-checkbox"]'
    );
    const capaIdField = $(".capaid-row");

    const projectNameCheckbox = document.querySelector(
        'input[id="projectname-checkbox"]'
    );
    const projectNameField = $(".projectname-row");

    const projectManagerCheckbox = document.querySelector(
        'input[id="projectmanager-checkbox"]'
    );
    const projectManagerField = $(".projectmanager-row");

    const celluleCheckbox = document.querySelector(
        'input[id="cellule-checkbox"]'
    );
    const celluleField = $(".cellule-row");

    const companyCheckbox = document.querySelector(
        'input[id="company-checkbox"]'
    );
    const companyField = $(".company-row");

    const statusCheckbox = document.querySelector(
        'input[id="status-checkbox"]'
    );
    const statusField = $(".status-row");

    capaIdCheckbox.onchange = () => {
        if (capaIdCheckbox.checked) {
            capaIdField.show();
        } else {
            capaIdField.hide();
        }
    };

    projectNameCheckbox.onchange = () => {
        if (projectNameCheckbox.checked) {
            projectNameField.show();
        } else {
            projectNameField.hide();
        }
    };

    projectManagerCheckbox.onchange = () => {
        if (projectManagerCheckbox.checked) {
            projectManagerField.show();
        } else {
            projectManagerField.hide();
        }
    };
    var elementExists = celluleCheckbox;
    if (elementExists) {
        celluleCheckbox.onchange = () => {
            if (celluleCheckbox.checked) {
                celluleField.show();
            } else {
                celluleField.hide();
            }
        };
    }

    companyCheckbox.onchange = () => {
        if (companyCheckbox.checked) {
            companyField.show();
        } else {
            companyField.hide();
        }
    };

    statusCheckbox.onchange = () => {
        if (statusCheckbox.checked) {
            statusField.show();
        } else {
            statusField.hide();
        }
    };
});

/**
 * Manage searching data.
 */
$(() => {
    const companyNameSelector = $("#company-name-search");

    const bcCheckbox = document.querySelector('input[id="bc-checkbox"]');
    const bcVal = "Devis envoyé";
    const bcVal_2 = "SIGNATURE CLIENT";
    const bcVal_3 = "VALIDATION OPÉRATIONEL";

    const pcCheckbox = document.querySelector('input[id="pc-checkbox"]');
    const pcVal = "PROJET EN COURS";

    const tcCheckbox = document.querySelector('input[id="pt-checkbox"]');
    const tcVal = "PROJET TERMINÉ";

    const paCheckbox = document.querySelector('input[id="pa-checkbox"]');
    const paVal = "PROJET ANNULÉ";

    bcCheckbox.onchange = () => {
        const table = document.getElementById("devis_table");
        const tbody = table.getElementsByTagName("tbody")[0];
        const tr = tbody.getElementsByTagName("tr");

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByClassName("status-row")[0];
            txtValue = td.textContent || td.innerText;
            if (
                !bcCheckbox.checked &&
                (txtValue == bcVal ||
                    txtValue.toUpperCase() == bcVal_2 ||
                    txtValue.toUpperCase() == bcVal_3)
            ) {
                tr[i].style.display = "none";
            }
            if (
                bcCheckbox.checked &&
                (txtValue == bcVal ||
                    txtValue.toUpperCase() == bcVal_2 ||
                    txtValue.toUpperCase() == bcVal_3)
            ) {
                tr[i].style.display = "";
            }
        }
    };

    pcCheckbox.onchange = () => {
        const table = document.getElementById("devis_table");
        const tbody = table.getElementsByTagName("tbody")[0];
        const tr = tbody.getElementsByTagName("tr");

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByClassName("status-row")[0];
            txtValue = td.textContent || td.innerText;

            if (!pcCheckbox.checked && txtValue.toUpperCase() == pcVal) {
                tr[i].style.display = "none";
            }
            if (pcCheckbox.checked && txtValue.toUpperCase() == pcVal) {
                tr[i].style.display = "";
            }
        }
    };

    tcCheckbox.onchange = () => {
        const table = document.getElementById("devis_table");
        const tbody = table.getElementsByTagName("tbody")[0];
        const tr = tbody.getElementsByTagName("tr");

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByClassName("status-row")[0];
            txtValue = td.textContent || td.innerText;
            if (!tcCheckbox.checked && txtValue.toUpperCase() == tcVal) {
                tr[i].style.display = "none";
            }
            if (tcCheckbox.checked && txtValue.toUpperCase() == tcVal) {
                tr[i].style.display = "";
            }
        }
    };

    paCheckbox.onchange = () => {
        const table = document.getElementById("devis_table");
        const tbody = table.getElementsByTagName("tbody")[0];
        const tr = tbody.getElementsByTagName("tr");

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByClassName("status-row")[0];
            txtValue = td.textContent || td.innerText;
            if (!paCheckbox.checked && txtValue.toUpperCase() == paVal) {
                tr[i].style.display = "none";
            }
            if (paCheckbox.checked && txtValue.toUpperCase() == paVal) {
                tr[i].style.display = "";
            }
        }
    };

    // Filter data from company name.
    companyNameSelector.on("change", () => {
        const selectedCompany = companyNameSelector
            .children("option:selected")
            .html();
        const selectedIndex = companyNameSelector
            .children("option:selected")
            .val();

        const filter = selectedCompany.toUpperCase();
        const table = document.getElementById("devis_table");
        const tbody = table.getElementsByTagName("tbody")[0];
        const tr = tbody.getElementsByTagName("tr");

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByClassName("company-row")[0];
            let txtValue = td.textContent || td.innerText;
            if (
                txtValue.toUpperCase().indexOf(filter) > -1 ||
                selectedIndex == ""
            ) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    });
});

/**
 * Filter from capaid.
 */
function capaidFilterSearch() {
    // Declare variables
    var input, filter, table, tbody, tr, td, i, txtValue;
    input = document.getElementById("capa-id-search");
    filter = input.value.toUpperCase();
    table = document.getElementById("devis_table");
    tbody = table.getElementsByTagName("tbody")[0];
    tr = tbody.getElementsByTagName("tr");

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByClassName("capaid-row")[0];
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
