$(() => {
    const celluleNameSelector = $("#cellule-name-search");

    // Filter data from company name.
    celluleNameSelector.on("change", () => {
        const selectedCellule = celluleNameSelector.children("option:selected").html();
        const selectedIndex = celluleNameSelector.children("option:selected").val();

        console.log(selectedIndex);

        const filter = selectedCellule.toUpperCase();
        const table = document.getElementById("admin_table");
        const tbody = table.getElementsByTagName("tbody")[0];
        const tr = tbody.getElementsByTagName("tr");

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByClassName("cellule-row")[0];
            let txtValue = td.textContent || td.innerText;
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
function usernameFilterSearch() {
    // Declare variables
    var input, filter, table, tbody, tr, td, i, txtValue;
    input = document.getElementById("username-search");
    filter = input.value.toUpperCase();
    table = document.getElementById("admin_table");
    tbody = table.getElementsByTagName("tbody")[0];
    tr = tbody.getElementsByTagName("tr");

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByClassName("username-row")[0];
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
