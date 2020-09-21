$(() => {
    if ($(window).width() < 980) {
        $("#main").addClass("main-full")
    } else {
        $("#main").removeClass("main-full")
    }

    $(window).on("resize", function () {
        console.log("On change - screen size")
        var win = $(this)
        if (win.width() <= 980) {
            $("#main").addClass("main-full")
        } else {
            $("#main").removeClass("main-full")
        }
    })
})
