function equipmentNameFilterSearch() {
    // Declare variables
    var input, filter, table, tbody, tr, td, i, txtValue;
    input = document.getElementById("equipment-name-search");
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
}