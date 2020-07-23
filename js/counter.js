function getId(obj) {
    var name = obj.className;
    var adds = 'add_'.concat(name);
    var add_message = 'add_message_'.concat(name);
    var unit_price = 'price_'.concat(name);
    var add_price = 'add_price_'.concat(name);
    var arr = [];
    arr.push(adds, add_message, unit_price, add_price);
    return (arr);
}

function addFunction(obj, num) {
    var idName = getId(obj)[0];
    var idMessage = getId(obj)[1];
    var idUnitPrice = getId(obj)[2];
    var idPrice = getId(obj)[3];

    var current = parseInt(document.getElementById(idName).innerHTML);
    var grandTotal = parseInt(document.getElementById("total_add_price").innerHTML);
    var unitPrice = parseInt(document.getElementById(idUnitPrice).innerHTML);
    current += num;
    var total = current*unitPrice;
    grandTotal += num*unitPrice;

    document.getElementById(idMessage).style.display = "block";
    document.getElementById("total_add_message").style.display = "block";
    document.getElementById(idName).innerHTML = current;
    document.getElementById(idPrice).innerHTML = '$' + total;
    document.getElementById("total_add_price").innerHTML = grandTotal;
    document.getElementById(idName).style.color = "red";
    document.getElementById(idPrice).style.color = "red";
    document.getElementById(idName).style.fontWeight = "bold";
    document.getElementById(idPrice).style.fontWeight = "bold";
}

function resetCount(obj) {
    var idName = getId(obj)[0];
    var idPrice = getId(obj)[3];
    var grandTotal = parseInt(document.getElementById("total_add_price").innerHTML);
    var total = parseInt(document.getElementById(idPrice).innerHTML.substring(1));
    grandTotal -= total;

    document.getElementById("total_add_price").innerHTML = grandTotal;
    document.getElementById(idName).innerHTML = "0";
    document.getElementById(idPrice).innerHTML = "0";
    document.getElementById(idName).style.color = "blue";
    document.getElementById(idPrice).style.color = "blue";
    document.getElementById(idName).style.fontWeight = "normal";
    document.getElementById(idPrice).style.fontWeight = "normal";
}

function activate() {
    window.location.href='activation.php';
}

function current() {
    window.location.href='current.php';
}

function closeShift() {
    window.location.href='close_shift.php';
}

function returnTicket() {
    window.location.href='return.php';
}

function refresh() {
    window.location.reload();
}

function home() {
    window.location.href='main.php';
}

function printReport() {
    document.getElementById("closeShift").disabled = false;
    document.getElementById("reminder").style.display = "none";
    window.print();
    return false;
}

function testMode() {
    var change = document.getElementById("toggle");
    if (change.innerHTML === "Test Mode On") {
        change.innerHTML = "Test Mode Off";
        document.getElementById("testCol").style.display = "none";
    } else {
        change.innerHTML = "Test Mode On";
        document.getElementById("testCol").style.display = "block";}
}


