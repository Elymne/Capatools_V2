$(() => {
    var div = document.getElementById("dom-target")
    var myData = JSON.parse(div.textContent)

    console.log(myData)
})
