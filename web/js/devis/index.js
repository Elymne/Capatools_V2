$(() => {
    /**
     * Attributes
     */
    const capaIdCheckbox = document.querySelector('input[id="capaid-checkbox"]');
    const capaIdField = $(".capaid-row");

    const projectNameCheckbox = document.querySelector('input[id="projectname-checkbox"]');
    const projectNameField = $(".projectname-row");

    const projectManagerCheckbox = document.querySelector('input[id="projectmanager-checkbox"]');
    const projectManagerField = $(".projectmanager-row");

    const celluleCheckbox = document.querySelector('input[id="cellule-checkbox"]');
    const celluleField = $(".cellule-row");

    const companyCheckbox = document.querySelector('input[id="company-checkbox"]');
    const companyField = $(".company-row");

    const statusCheckbox = document.querySelector('input[id="status-checkbox"]');
    const statusField = $(".status-row");

    const companyNameSelector = $("#company-name-search");

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

    celluleCheckbox.onchange = () => {
        if (celluleCheckbox.checked) {
            celluleField.show();
        } else {
            celluleField.hide();
        }
    };

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

    // Filter data from company name.
    companyNameSelector.on("change", () => {
        var selectedCompany = companyNameSelector.children("option:selected").html();
        var selectedIndex = companyNameSelector.children("option:selected").val();

        console.log(selectedIndex);

        filter = selectedCompany.toUpperCase();
        table = document.getElementById("devis_table");
        tbody = table.getElementsByTagName("tbody")[0];
        tr = tbody.getElementsByTagName("tr");

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByClassName("company-row")[0];
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1 || selectedIndex == "") {
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

function test() {
    var selectedCountry = document.getElementById("company-name-search").children("option:selected").val();
    console.log(`${selectedCountry} selected`);
}
