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

    // Notre deuxième page formulaire.
    const thirdFormCard = $("#third-form-card");
    const thirdBackLink = $("#third-back-link");
    const thirdNextLink = $("#third-next-link");

    thirdBackLink.click(function () {
        thirdFormCard.hide();
        secondFormCard.show();
    });

    thirdNextLink.click(function () {
        alert("Attends un peu");
    });
});
