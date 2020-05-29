/**
 * Form steps.
 */
$(() => {
    $("#stepform").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
    });
});

/**
 * Filter from capaid.
 */
function prestaDurationCalcul() {
    const prestationDurationInput = document.getElementById("deviscreateform-service_duration");
    const prestationDurationDayInput = document.getElementById("service-duration-day");
    console.log(prestationDurationInput.value);

    const result = parseInt(prestationDurationInput.value / 7.7);
    prestationDurationDayInput.value = result;
}

/**
 * Filter from capaid.
 */
function prestaDurationCalculUpdateview() {
    const prestationDurationInput = document.getElementById("devisupdateform-service_duration");
    const prestationDurationDayInput = document.getElementById("service-duration-day");
    console.log(prestationDurationInput.value);

    const result = parseInt(prestationDurationInput.value / 7.7);
    prestationDurationDayInput.value = result;
}
