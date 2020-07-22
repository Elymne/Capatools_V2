const $incertudeMap = JSON.parse(
    document.getElementById("coefficient-data-target").textContent
);
const $intervenantMap = JSON.parse(
    document.getElementById("capauser-data-target").textContent
);
initialisationLotTask();
initialisationGestionTask();

function initialisationLotTask() {
    var ListIndexlotTask = [];
    var regex = new RegExp(
        'id="projectcreatelottaskform-([0-9]*)-title',
        "gim"
    );
    var array1;
    while ((array1 = regex.exec(document.body.innerHTML)) !== null) {
        var element = array1[1];
        OnCalculIncertitudelot(parseInt(element));

        var Taskdaydurationlot =
            "#projectcreatelottaskform-" + element + "-day_duration";
        $(Taskdaydurationlot).on("input", function (e) {
            OnCalculIncertitudelot(parseInt(element));
        });
        var Taskdaydurationlot =
            "#projectcreatelottaskform-" + element + "-hour_duration";
        $(Taskdaydurationlot).on("input", function (e) {
            OnCalculIncertitudelot(parseInt(element));
        });
        var Userselect =
            "#projectcreatelottaskform-" + element + "-capa_user_id";
        $(Userselect).on("input", function (e) {
            OnCalculIntervenantlot(element);
        });
    }
}
function initialisationGestionTask() {
    var ListIndexlotTask = [];
    var regex = new RegExp(
        'id="projectcreategestiontaskform-([0-9]*)-title',
        "gim"
    );
    var array1;
    while ((array1 = regex.exec(document.body.innerHTML)) !== null) {
        var element = array1[1];
        OnCalculIncertitudeGest(parseInt(element));
        var TaskdaydurationGest =
            "#projectcreategestiontaskform-" + element + "-day_duration";
        $(TaskdaydurationGest).on("input", function (e) {
            OnCalculIncertitudeGest(parseInt(element));
        });
        var TaskdaydurationGest =
            "#projectcreategestiontaskform-" + element + "-hour_duration";
        $(TaskdaydurationGest).on("input", function (e) {
            OnCalculIncertitudeGest(parseInt(element));
        });
        var Userselect = "#projectcreategestiontaskform-" + 0 + "-capa_user_id";
        $(TaskdaydurationGest).on("input", function (e) {
            OnCalculIntervenantGest(parseInt(element));
        });
    }
}

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

    var SelectRisk = "#projectcreatelottaskform-" + id + "-risk";
    incertitude = $(SelectRisk).val();

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
    hourIncertitude = Math.round(hourIncertitude);
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
