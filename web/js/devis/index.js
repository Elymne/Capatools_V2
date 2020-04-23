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
});
