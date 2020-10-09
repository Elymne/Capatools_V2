$(() => {
    const privateEstablishementString = 'ENTREPRISE PRIVÉE'
    const tvaBlockDiv = $('#tva-block')
    const typeSelector = $('#companycreateform-select_type')

    hideOrShowTvaField(privateEstablishementString, tvaBlockDiv, typeSelector)

    // Filter data from company name.
    typeSelector.on('change', () => {
        hideOrShowTvaField(privateEstablishementString, tvaBlockDiv, typeSelector)
    })
})

const hideOrShowTvaField = (privateEstablishementString, tvaBlockDiv, typeSelector) => {
    const filter = typeSelector.children('option:selected').html().toUpperCase()

    if (filter == privateEstablishementString) {
        tvaBlockDiv.show()
    } else {
        tvaBlockDiv.hide()
    }
}
