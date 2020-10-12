// Liste d'informations relatives au données qui enreichissent le dynamicForm.
const infoData = JSON.parse(document.getElementById('info-data-target').textContent)
const totalHumanCost = infoData.totalHumanCost
const totalCostInvest = infoData.totalCostInvest
const totalCostRepayement = infoData.totalCostRepayement
const managementRate = infoData.managementRate

$(() => {
    let stepsize = 0.5

    //Fin debug
    let InputRateHumamMargin = '#lotsimulate-rate_human_margin'
    $(InputRateHumamMargin).on('blur', function (e) {
        let rate = parseFloat(e.currentTarget.value)
        if (rate < 10 || isNaN(rate)) {
            e.currentTarget.value = 10
        }
    })

    $(InputRateHumamMargin).on('input', function (e) {
        UpdateHumanMargin()
        CalculTotalLot()
    })

    let InputInvestMargin = '#lotsimulate-rate_consumable_investement_margin'
    $(InputInvestMargin).on('blur', function (e) {
        let rate = parseFloat(e.currentTarget.value)
        if (rate < 0 || isNaN(rate)) {
            e.currentTarget.value = 0
        }
    })

    $(InputInvestMargin).on('input', function (e) {
        UpdateInvestMargin()
        CalculTotalLot()
    })

    let InputRepayementMargin = '#lotsimulate-rate_repayement_margin'
    $(InputRepayementMargin).on('blur', function (e) {
        let rate = parseFloat(e.currentTarget.value)
        if (rate < 0.0 || isNaN(rate)) {
            e.currentTarget.value = 0
        }
    })
    $(InputRepayementMargin).on('input', function (e) {
        UpdateRepayementMargin()
        CalculTotalLot()
    })

    let ButtonRateHumamMarginUp = '#lotsimulate-rate_human_marginup'
    $(ButtonRateHumamMarginUp).on('click', function () {
        let rate = parseFloat($(InputRateHumamMargin).val())
        if (!isNaN(rate)) {
            $(InputRateHumamMargin).val(rate + stepsize)
            UpdateHumanMargin()
            CalculTotalLot()
        }
    })

    let ButtonRateHumamMarginDown = '#lotsimulate-rate_human_margindown'
    $(ButtonRateHumamMarginDown).on('click', function () {
        let rate = parseFloat($(InputRateHumamMargin).val())
        if (!isNaN(rate)) {
            rate = rate - stepsize
            if (rate >= 10) {
                $(InputRateHumamMargin).val(rate)
                UpdateHumanMargin()
                CalculTotalLot()
            }
        }
    })

    let ButtonInvestMarginUp = '#lotsimulate-rate_consumable_investement_marginup'
    $(ButtonInvestMarginUp).on('click', function () {
        let rate = parseFloat($(InputInvestMargin).val())
        if (!isNaN(rate)) {
            $(InputInvestMargin).val(rate + stepsize)
            UpdateInvestMargin()
            CalculTotalLot()
        }
    })

    let ButtonInvestMarginDown = '#lotsimulate-rate_consumable_investement_margindown'
    $(ButtonInvestMarginDown).on('click', function () {
        let rate = parseFloat($(InputInvestMargin).val())
        if (!isNaN(rate)) {
            rate = rate - stepsize
            if (rate >= 0) {
                $(InputInvestMargin).val(rate)
                UpdateInvestMargin()
                CalculTotalLot()
            }
        }
    })

    let ButtonRepayementMarginUp = '#lotsimulate-rate_repayement_marginup'
    $(ButtonRepayementMarginUp).on('click', function () {
        let rate = parseFloat($(InputRepayementMargin).val())
        if (!isNaN(rate)) {
            $(InputRepayementMargin).val(rate + stepsize)
            UpdateRepayementMargin()
            CalculTotalLot()
        }
    })
    let ButtonRepayementMarginDown = '#lotsimulate-rate_repayement_margindown'
    $(ButtonRepayementMarginDown).on('click', function () {
        let rate = parseFloat($(InputRepayementMargin).val())
        if (!isNaN(rate)) {
            rate = rate - stepsize
            if (rate >= 0) {
                $(InputRepayementMargin).val(rate)
                UpdateRepayementMargin()
                CalculTotalLot()
            }
        }
    })

    UpdateHumanMargin()
    UpdateInvestMargin()
    UpdateRepayementMargin()
    CalculTotalLot()
})

function UpdateHumanMargin() {
    let totalcostwithmargin = '#lotsimulate-total_cost_human_with_margin'
    let LotrateMargin = '#lotsimulate-rate_human_margin'
    let resultattwithmargin = totalHumanCost * (1 + $(LotrateMargin).val() / 100)

    if (isNaN(resultattwithmargin)) {
        resultattwithmargin = 0
    }
    $(totalcostwithmargin).val(new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(resultattwithmargin.toFixed(2)))
}

function UpdateInvestMargin() {
    let totalcostwithmargin = '#lotsimulate-total_cost_invest_with_margin'
    let LotrateMargin = '#lotsimulate-rate_consumable_investement_margin'
    let resultattwithmargin = totalCostInvest * (1 + $(LotrateMargin).val() / 100)
    if (isNaN(resultattwithmargin)) {
        resultattwithmargin = 0
    }
    $(totalcostwithmargin).val(new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(resultattwithmargin.toFixed(2)))
}

function UpdateRepayementMargin() {
    let totalcostwithmargin = '#lotsimulate-total_cost_repayement_with_margin'
    let LotrateMargin = '#lotsimulate-rate_repayement_margin'
    let totalcost = '#lotsimulate-totalcostrepayement'
    let resultattwithmargin = totalCostRepayement * (1 + $(LotrateMargin).val() / 100)
    if (isNaN(resultattwithmargin)) {
        resultattwithmargin = 0
    }
    $(totalcostwithmargin).val(new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(resultattwithmargin.toFixed(2)))
}

function CalculTotalLot() {
    let totalcosthuman = '#lotsimulate-totalcosthuman'
    let totalcostinvest = '#lotsimulate-totalcostinvest'
    let totalcostrepayement = '#lotsimulate-totalcostrepayement'

    let totalcostlot = '#lotsimulate-total_cost_lot'
    let totalcosthumanwithmargin = '#lotsimulate-total_cost_human_with_margin'
    let totalcostinvestwithmargin = '#lotsimulate-total_cost_invest_with_margin'
    let totalcostrepayementwithmargin = '#lotsimulate-total_cost_repayement_with_margin'
    let totalcosthumanprice = Number(
        $(totalcosthuman)
            .val()
            .replace(',', '.')
            .replace(/[^0-9.-]+/g, ''),
    )
    let totalcostinvestprice = Number(
        $(totalcostinvest)
            .val()
            .replace(',', '.')
            .replace(/[^0-9.-]+/g, ''),
    )
    let totalcostrepayementprice = Number(
        $(totalcostrepayement)
            .val()
            .replace(',', '.')
            .replace(/[^0-9.-]+/g, ''),
    )
    let totalcosthumanwithmarginprice = Number(
        $(totalcosthumanwithmargin)
            .val()
            .replace(',', '.')
            .replace(/[^0-9.-]+/g, ''),
    )
    let totalcostinvestwithmarginprice = Number(
        $(totalcostinvestwithmargin)
            .val()
            .replace(',', '.')
            .replace(/[^0-9.-]+/g, ''),
    )
    let totalcostrepayementwithmarginprice = Number(
        $(totalcostrepayementwithmargin)
            .val()
            .replace(',', '.')
            .replace(/[^0-9.-]+/g, ''),
    )

    let totalcost = totalcosthumanprice + totalcostinvestprice + totalcostrepayementprice
    let totalcostwithMargin = totalcosthumanwithmarginprice + totalcostinvestwithmarginprice + totalcostrepayementwithmarginprice
    $(totalcostlot).val(new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(totalcostwithMargin.toFixed(2)))

    let averagelotmargin = '#lotsimulate-average_lot_margin'

    let average = totalcostwithMargin / totalcost - 1
    if (isNaN(average)) {
        average = 0
    }
    $(averagelotmargin).val(new Intl.NumberFormat('fr-FR', { style: 'percent', maximumFractionDigits: 2 }).format(average))

    let supportcost = '#lotsimulate-support_cost'
    let totalcostlotwithsupport = '#lotsimulate-total_cost_lot_with_support'

    let ratesupp = managementRate

    let totalwithsupport = totalcostwithMargin / (1 - ratesupp / 100)
    let support = totalwithsupport * (ratesupp / 100)
    $(supportcost).val(new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(support.toFixed(2)))

    $(totalcostlotwithsupport).val(new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(totalwithsupport.toFixed(2)))
}
