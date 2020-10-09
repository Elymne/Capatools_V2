const $incertudeMap = JSON.parse(
    document.getElementById("coefficient-data-target").textContent
);

const $intervenantMap = JSON.parse(
    document.getElementById("capauser-data-target").textContent
);
nbTaskgestion = 0;
initialisationLotTask();
initialisationGestionTask();

function initialisationLotTask() {
    let regex = new RegExp(
        'id="projectcreatelottaskform-([0-9]*)-title',
        "gim"
    );
    let array1;
    while ((array1 = regex.exec(document.body.innerHTML)) !== null) {
        let element = array1[1];
        OnCalculIncertitudelot(parseInt(element));

        let Taskdaydurationlot =
            "#projectcreatelottaskform-" + element + "-day_duration";
        $(Taskdaydurationlot).on("input", function (e) {
            OnCalculIncertitudelot(parseInt(element));
        });
        let Taskhourdurationlot =
            "#projectcreatelottaskform-" + element + "-hour_duration";
        $(Taskhourdurationlot).on("input", function (e) {
            OnCalculIncertitudelot(parseInt(element));
        });
        let Userselect =
            "#projectcreatelottaskform-" + element + "-capa_user_id";
        $(Userselect).on("input", function (e) {
            OnCalculIntervenantlot(element);
            OnCalculIncertitudelot(parseInt(element));
        });
    }
}

function initialisationGestionTask() {
    let regex = new RegExp(
        'id="projectcreategestiontaskform-([0-9]*)-title',
        "gim"
    );
    let array1;
    while ((array1 = regex.exec(document.body.innerHTML)) !== null) {
        let element = array1[1];
        OnCalculIncertitudeGest(parseInt(element));
        let TaskdaydurationGest =
            "#projectcreategestiontaskform-" + element + "-day_duration";
        $(TaskdaydurationGest).on("input", function (e) {
            OnCalculIncertitudeGest(parseInt(element));
        });
        let TaskhourdurationGest =
            "#projectcreategestiontaskform-" + element + "-hour_duration";
        $(TaskhourdurationGest).on("input", function (e) {
            OnCalculIncertitudeGest(parseInt(element));
        });
        let Userselect = "#projectcreategestiontaskform-" + 0 + "-capa_user_id";
        $(TaskdaydurationGest).on("input", function (e) {
            OnCalculIntervenantGest(parseInt(element));
            OnCalculIncertitudeGest(parseInt(element));
        });
        nbTaskgestion++;

        let boutonfirstadd = "#boutonfirstadd";
        $(boutonfirstadd).hide();
    }
}

function OnCalculIncertitudeGest(id) {
    let Taskdayduration =
        "#projectcreategestiontaskform-" + id + "-day_duration";
    let day = $(Taskdayduration).val();

    let Taskhourduration =
        "#projectcreategestiontaskform-" + id + "-hour_duration";
    let hour = $(Taskhourduration).val();

    let SelectRisk = "#projectcreategestiontaskform-" + id + "-risk";
    incertitude = $(SelectRisk).val();

    let dayIncertitude = CalculTempsincertitude(hour, day, incertitude);

    let SelectRiskDuration =
        "#projectcreategestiontaskform-" + id + "-risk_duration";
    $(SelectRiskDuration).val(dayIncertitude + "j ");

    let SelectRiskDurationhour =
        "#projectcreategestiontaskform-" + id + "-risk_duration_day";

    let SelectPrice = "#projectcreategestiontaskform-" + id + "-price";
    price = $(SelectPrice).val();
    let SelectRiskTotalPrice =
        "#projectcreategestiontaskform-" + id + "-totalprice";
    let totalprice = (dayIncertitude * price).toFixed(2);
    $(SelectRiskTotalPrice).val(totalprice);

    $(SelectRiskDurationhour).val(dayIncertitude);
}

function OnCalculIntervenantGest(id) {
    let elementuser = "#projectcreategestiontaskform-" + id + "-price";

    let Userselect = "#projectcreategestiontaskform-" + id + "-capa_user_id";

    let userid = $(Userselect).val();
    let intervenantMap = $intervenantMap;
    let priceuser = intervenantMap[userid];
    $(elementuser).val(priceuser);
}

function OnCalculIntervenantlot(id) {
    let elementuser = "#projectcreatelottaskform-" + id + "-price";

    let Userselect = "#projectcreatelottaskform-" + id + "-capa_user_id";

    let userid = $(Userselect).val();

    let intervenantMap = $intervenantMap;
    let priceuser = intervenantMap[userid];
    $(elementuser).val(priceuser);
}

function OnCalculIncertitudelot(id) {
    let Taskdayduration = "#projectcreatelottaskform-" + id + "-day_duration";
    let day = $(Taskdayduration).val();

    let Taskhourduration = "#projectcreatelottaskform-" + id + "-hour_duration";
    let hour = $(Taskhourduration).val();

    let SelectRisk = "#projectcreatelottaskform-" + id + "-risk";
    incertitude = $(SelectRisk).val();

    let dayIncertitude = CalculTempsincertitude(hour, day, incertitude);
    let SelectRiskDuration =
        "#projectcreatelottaskform-" + id + "-risk_duration";
    $(SelectRiskDuration).val(dayIncertitude + "j ");

    let SelectRiskDurationhour =
        "#projectcreatelottaskform-" + id + "-risk_duration_day";
    $(SelectRiskDurationhour).val(dayIncertitude);

    let SelectPrice = "#projectcreatelottaskform-" + id + "-price";
    price = $(SelectPrice).val();
    let SelectRiskTotalPrice =
        "#projectcreatelottaskform-" + id + "-totalprice";
    let totalprice = (dayIncertitude * price).toFixed(2);

    $(SelectRiskTotalPrice).val(totalprice);
}

function CalculTempsincertitude(hour = 0, day = 0, incertitudestring) {
    let incertitudeMap = $incertudeMap;
    let incertitude = incertitudeMap[incertitudestring];
    let dayIncertitude = (parseInt(day) + parseInt(hour) / 7.7) * incertitude;
    return dayIncertitude;
}

$(() => {
    $(".dynamicform_wrapperLot").on("afterInsert", function (e, item) {
        //Recherche de l'index courrent
        let seletect = item.innerHTML;
        let regex = new RegExp("projectcreatelottaskform-([0-9]*)-risk");
        let arr = regex.exec(seletect);
        let index = parseInt(arr[1]);

        // On calcul de base pour fixer un prix à 0.
        OnCalculIncertitudelot(index);

        //Ajout des callbacks pour les élements
        let SelectRisk = "#projectcreatelottaskform-" + index + "-risk";
        $(SelectRisk).on("select2:select", function (e) {
            OnCalculIncertitudelot(index);
        });
        $(SelectRisk).val("1");

        let Taskdayduration =
            "#projectcreatelottaskform-" + index + "-day_duration";
        $(Taskdayduration).val(1);
        $(Taskdayduration).on("input", function (e) {
            OnCalculIncertitudelot(index);
        });

        let Taskhourduration =
            "#projectcreatelottaskform-" + index + "-hour_duration";
        $(Taskhourduration).val(0);
        $(Taskhourduration).on("input", function (e) {
            OnCalculIncertitudelot(index);
        });

        let TaskRiskduration =
            "#projectcreatelottaskform-" + index + "-risk_duration";
        $(TaskRiskduration).val("1j 0h");

        let SelectUser = "#projectcreatelottaskform-" + index + "-capa_user_id";
        $(SelectUser).on("select2:select", function (e) {
            OnCalculIntervenantlot(index);
            OnCalculIncertitudelot(index);
        });

        let TaskNumber = "#projectcreatelottaskform-" + index + "-number";
        $(TaskNumber).val(index);
        OnCalculIntervenantlot(index);
    });

    $(".dynamicform_wrapperLot").on("beforeDelete", function (e, item) {
        if (!confirm("Voulez-vous supprimer cette tâche?")) {
            return false;
        }

        return true;
    });

    $(".dynamicform_wrapperLot").on("limitReached", function (e, item) {
        alert("Limite atteinte");
    });

    $(".dynamicform_wrapperGest").on("afterInsert", function (e, item) {
        //Recherche de l'index courrent
        let seletect = item.innerHTML;
        let regex = new RegExp("projectcreategestiontaskform-([0-9]*)-risk");
        let arr = regex.exec(seletect);
        let index = parseInt(arr[1]);

        let boutonfirstadd = "#boutonfirstadd";
        $(boutonfirstadd).hide();
        nbTaskgestion++;
        OnCalculIncertitudeGest(index);

        //Ajout des callbacks pour les élements
        let SelectRisk = "#projectcreategestiontaskform-" + index + "-risk";
        $(SelectRisk).on("select2:select", function (e) {
            OnCalculIncertitudeGest(index);
        });

        $(SelectRisk).val("1");
        let Taskdayduration =
            "#projectcreategestiontaskform-" + index + "-day_duration";
        $(Taskdayduration).val(1);
        $(Taskdayduration).on("input", function (e) {
            OnCalculIncertitudeGest(index);
        });

        let Taskhourduration =
            "#projectcreategestiontaskform-" + index + "-hour_duration";
        $(Taskhourduration).val(0);
        $(Taskhourduration).on("input", function (e) {
            OnCalculIncertitudeGest(index);
        });

        let TaskRiskduration =
            "#projectcreategestiontaskform-" + index + "-risk_duration";
        $(TaskRiskduration).val("1j 0h");

        let SelectUser =
            "#projectcreategestiontaskform-" + index + "-capa_user_id";
        $(SelectUser).on("select2:select", function (e) {
            OnCalculIntervenantGest(index);
            OnCalculIncertitudeGest(index);
        });
        OnCalculIntervenantlot(index);
    });

    $(".dynamicform_wrapperGest").on("beforeDelete", function (e, item) {
        if (!confirm("Voulez-vous supprimer cette tâche ?")) {
            return false;
        }

        return true;
    });

    $(".dynamicform_wrapperGest").on("limitReached", function (e, item) {
        alert("Limite atteinte");
    });

    $(".dynamicform_wrapperGest").on("afterDelete", (e, item) => {
        nbTaskgestion--;
        if (nbTaskgestion == 0) {
            let boutonfirstadd = "#boutonfirstadd";
            $(boutonfirstadd).show();
        }
    });
});

/**
 * Scope à l'initialisation de la vue.
 * En gros, si les premiers éléments à l'init sont vides. on place des valeurs par défaut dans les champs numériques.
 */
$(() => {
    const pt = $("#projectcreategestiontaskform-0-capa_user_id").val();
    const po = $("#projectcreategestiontaskform-0-risk").val();

    if (pt == "" || po == "") {
        $("#projectcreategestiontaskform-0-day_duration").val(1);
        $("#projectcreategestiontaskform-0-hour_duration").val(0);
        $("#projectcreategestiontaskform-0-risk_duration").val("1j");
    }

    const ot = $("#projectcreatelottaskform-0-capa_user_id").val();
    const oo = $("#projectcreatelottaskform-0-risk").val();

    if (ot == "" || oo == "") {
        $("#projectcreatelottaskform-0-day_duration").val(1);
        $("#projectcreatelottaskform-0-hour_duration").val(0);
        $("#projectcreatelottaskform-0-risk_duration").val("1j");
    }
});
