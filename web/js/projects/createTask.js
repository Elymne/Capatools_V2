const $incertudeMap = JSON.parse(
    document.getElementById("coefficient-data-target").textContent
);
const $intervenantMap = JSON.parse(
    document.getElementById("capauser-data-target").textContent
);

var Taskdaydurationlot = "#projectcreatelottaskform-" + 0 + "-day_duration";
$(Taskdaydurationlot).on("input", function (e) {
    OnCalculIncertitudelot(0);
});

var Taskdaydurationlot = "#projectcreatelottaskform-" + 0 + "-hour_duration";
$(Taskdaydurationlot).on("input", function (e) {
    OnCalculIncertitudelot(0);
});

var TaskdaydurationGest =
    "#projectcreategestiontaskform-" + 0 + "-day_duration";
$(TaskdaydurationGest).on("input", function (e) {
    OnCalculIncertitudeGest(0);
});

var TaskdaydurationGest =
    "#projectcreategestiontaskform-" + 0 + "-hour_duration";
$(TaskdaydurationGest).on("input", function (e) {
    OnCalculIncertitudeGest(0);
});

var Userselect = "#projectcreategestiontaskform-" + 0 + "-capa_user_id";
$(TaskdaydurationGest).on("input", function (e) {
    OnCalculIntervenantGest(0);
});

var Userselect = "#projectcreatelottaskform-" + 0 + "-capa_user_id";
$(TaskdaydurationGest).on("input", function (e) {
    OnCalculIntervenantlot(0);
});

function OnCalculIncertitudeGest(id) {
    var Taskdayduration =
        "#projectcreategestiontaskform-" + id + "-day_duration";
    var day = $(Taskdayduration).val();

    var Taskhourduration =
        "#projectcreategestiontaskform-" + id + "-hour_duration";
    var hour = $(Taskhourduration).val();

    var SelectRisk = "#projectcreategestiontaskform-" + id + "-risk";
    incertitude = $(SelectRisk).val();

    var res = CalculTempsincertitude(hour, day, incertitude);

    var SelectRiskDuration =
        "#projectcreategestiontaskform-" + id + "-risk_duration";
    $(SelectRiskDuration).val(
        res.dayIncertitude + "j " + res.hourIncertitude + "h"
    );

    var SelectRiskDuration =
        "#projectcreategestiontaskform-" + id + "-risk_duration_hour";
    var total = res.dayIncertitude + res.hourIncertitude * 7.7;
    $(SelectRiskDuration).val(total);
}

function OnCalculIntervenantGest(id) {
    var elementuser = "#projectcreategestiontaskform-" + id + "-price";

    var Userselect = "#projectcreategestiontaskform-" + id + "-capa_user_id";

    var userid = $(Userselect).val();
    console.log($intervenantMap);
    var intervenantMap = $intervenantMap;
    var priceuser = intervenantMap[userid];
    $(elementuser).val(priceuser);
}

function OnCalculIntervenantlot(id) {
    var elementuser = "#projectcreatelottaskform-" + id + "-price";

    var Userselect = "#projectcreatelottaskform-" + id + "-capa_user_id";

    var userid = $(Userselect).val();

    var intervenantMap = $intervenantMap;
    var priceuser = intervenantMap[userid];
    $(elementuser).val(priceuser);
}
function OnCalculIncertitudelot(id) {
    var Taskdayduration = "#projectcreatelottaskform-" + id + "-day_duration";
    var day = $(Taskdayduration).val();

    var Taskhourduration = "#projectcreatelottaskform-" + id + "-hour_duration";
    var hour = $(Taskhourduration).val();
    console.log(hour);
    var SelectRisk = "#projectcreatelottaskform-" + id + "-risk";
    incertitude = $(SelectRisk).val();

    console.log($(SelectRisk));
    var res = CalculTempsincertitude(hour, day, incertitude);

    var SelectRiskDuration =
        "#projectcreatelottaskform-" + id + "-risk_duration";
    incertitude = $(SelectRiskDuration).val(
        res.dayIncertitude + "j " + res.hourIncertitude + "h"
    );
}

function CalculTempsincertitude(hour, day, incertitudestring) {
    var incertitudeMap = $incertudeMap;
    var incertitude = incertitudeMap[incertitudestring];

    var hourIncertitude = hour * incertitude;
    var dayIncertitude = day * incertitude;

    var daydecimal = dayIncertitude - Math.floor(dayIncertitude);
    dayIncertitude = Math.trunc(dayIncertitude);

    hourIncertitude = Math.round(hourIncertitude + daydecimal * 7.7);
    var Additionalday = Math.trunc(hourIncertitude / 7.7);
    hourIncertitude = hourIncertitude % 7.7;

    dayIncertitude = Additionalday + dayIncertitude;

    return { dayIncertitude, hourIncertitude };
}

$(() => {
    $(".dynamicform_wrapperLot").on("afterInsert", function (e, item) {
        //Recherche de l'index courrent
        var seletect = item.innerHTML;
        var regex = new RegExp("projectcreatelottaskform-([0-9]*)-risk");
        var arr = regex.exec(seletect);
        var index = parseInt(arr[1]);

        //Ajout des callbacks pour les élements
        var SelectRisk = "#projectcreatelottaskform-" + index + "-risk";
        $(SelectRisk).on("select2:select", function (e) {
            OnCalculIncertitudelot(index);
        });

        var Taskdayduration =
            "#projectcreatelottaskform-" + index + "-day_duration";
        $(Taskdayduration).val(0);
        $(Taskdayduration).on("input", function (e) {
            OnCalculIncertitudelot(index);
        });

        var Taskhourduration =
            "#projectcreatelottaskform-" + index + "-hour_duration";
        $(Taskhourduration).val(0);
        $(Taskhourduration).on("input", function (e) {
            OnCalculIncertitudelot(index);
        });

        var SelectUser = "#projectcreatelottaskform-" + index + "-capa_user_id";
        $(SelectUser).on("select2:select", function (e) {
            OnCalculIntervenantlot(index);
        });
    });

    $(".dynamicform_wrapperLot").on("beforeDelete", function (e, item) {
        if (!confirm("Are you sure you want to delete this item?")) {
            return false;
        }

        return true;
    });

    $(".dynamicform_wrapperLot").on("limitReached", function (e, item) {
        alert("Limit reached");
    });

    $(".dynamicform_wrapperGest").on("afterInsert", function (e, item) {
        //Recherche de l'index courrent
        var seletect = item.innerHTML;
        var regex = new RegExp("projectcreategestiontaskform-([0-9]*)-risk");
        var arr = regex.exec(seletect);
        var index = parseInt(arr[1]);

        //Ajout des callbacks pour les élements
        var SelectRisk = "#projectcreategestiontaskform-" + index + "-risk";
        $(SelectRisk).on("select2:select", function (e) {
            OnCalculIncertitudeGest(index);
        });

        var Taskdayduration =
            "#projectcreategestiontaskform-" + index + "-day_duration";
        $(Taskdayduration).val(0);
        $(Taskdayduration).on("input", function (e) {
            OnCalculIncertitudeGest(index);
        });

        var Taskhourduration =
            "#projectcreategestiontaskform-" + index + "-hour_duration";
        $(Taskhourduration).val(0);
        $(Taskhourduration).on("input", function (e) {
            OnCalculIncertitudeGest(index);
        });

        var SelectUser =
            "#projectcreategestiontaskform-" + index + "-capa_user_id";
        $(SelectUser).on("select2:select", function (e) {
            OnCalculIntervenantGest(index);
        });
    });

    $(".dynamicform_wrapperGest").on("beforeDelete", function (e, item) {
        if (!confirm("Are you sure you want to delete this item?")) {
            return false;
        }

        return true;
    });

    $(".dynamicform_wrapperGest").on("limitReached", function (e, item) {
        alert("Limit reached");
    });
});
