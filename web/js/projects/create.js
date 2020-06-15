$(() => {
    // Notre première page formulaire.
    const firstFormCard = $("#first-form-card");
    const firstNextLink = $("#first-next-link");

    firstNextLink.click(function () {
        firstFormCard.hide();
        secondFormCard.show();
    });

    // Notre deuxième page formulaire.
    const secondFormCard = $("#second-form-card");
    const secondBackLink = $("#second-back-link");
    const secondNextLink = $("#second-next-link");

    secondBackLink.click(function () {
        secondFormCard.hide();
        firstFormCard.show();
    });

    secondNextLink.click(function () {
        secondFormCard.hide();
        thirdFormCard.show();
    });
});
