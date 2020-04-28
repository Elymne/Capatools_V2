$(() => {
    const typeSelector = $("#companycreateform-type");
    const privateEstablishement = "ENTREPRISE PRIVÉE";

    // Filter data from company name.
    typeSelector.on("change", () => {
        const selectedCompany = typeSelector.children("option:selected").html();

        const filter = selectedCompany.toUpperCase();
        const div = document.getElementsByClassName("field-tva-field")[0];

        if (filter == privateEstablishement) {
            div.style.display = "";
        } else {
            div.style.display = "none";
        }
    });
});
