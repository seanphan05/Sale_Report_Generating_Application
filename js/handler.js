$(document).ready(function () {
    // Login Page
    $("#login-form-submit").on('click', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        const loginErrorMsg = document.getElementById("login-error-msg-holder");
        
        var clerkName = document.getElementById("username-field").value;
        var dateInfo = document.getElementById("date-field").value;
        var shiftInfo = document.getElementById("shift-field").value;
        var password = document.getElementById("password-field").value;

        if (clerkName === "" || dateInfo === "" || shiftInfo === "" || password === "") {
            loginErrorMsg.innerHTML = "Please fill out all fields!";
            loginErrorMsg.style.display = "block";
        } else if (password === "") {
            var json = {clerkName: clerkName, dateInfo: dateInfo, shiftInfo: shiftInfo, code: password};
            $.ajax({
                method: "POST",
                url: "wp-content/themes/lotterytheme/main/verification.php",
                data: json,
                success: function() {
                    alert("You have successfully logged in.");
                    window.location.href="http://lotteryreport.ezyro.com/wp-content/themes/lotterytheme/main/main.php"; } 
            })
        } else {
            loginErrorMsg.innerHTML = "Invalid Verification Code! Please try again.";
            loginErrorMsg.style.display = "block";
            }
        });

    // Send data after submitting
    $("#submit").one('click', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var i;
        var jsonSale = {};
        for (i = 1; i < 34; i++) {
            var sale = document.getElementById("add_game" + ('0' + i).slice(-2)).innerHTML;
            if (sale !== "0") {
                jsonSale["game" + ('0' + i).slice(-2)] = sale; }
        }
        $.ajax({
            method: "POST",
            url: "updateSale.php",
            data: jsonSale,
            success: function (data) {
                $("#add_sale_message").show();
                document.getElementById("add_sale_message").innerHTML = data;
                document.getElementById("submit").disabled = true;
            }
        })
    });

    // Return Ticket
    $("#returnTicket").one('click', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var gameID = $("#returnList").val();
        var noReturn = $("#returnTicketNum").val();
        var action = "return";
        var json = {action: action, gameID: gameID, noReturn: noReturn};

        $.ajax({
            method: "POST",
            url: "updateSale.php",
            data: json,
            success: function (data) {
                $("#returnSection").hide();
                $("#returnTicket").hide();
                $("#returnMessage").show();
                document.getElementById("returnMessage").innerHTML = data;
                $("#returnAnotherTicket").show();
            }
        })
    });


    // Pack Activation
    $(document).ready(function(){
        $('#activatePack').one('click', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var checkValues = $('input[name=checkboxlist]:checked').map(function()
            {
                return $(this).val();
            }).get();

            $.ajax({
                url: 'packActivate.php',
                method: "POST",
                data: {selectedGames: checkValues},
                success:function(data){
                    document.getElementById("nav-message").innerHTML = data;
                    $("#activation_section").hide();
                }
            });
        });
    });

    // View Report
    $("#showReport").one('click', function (e) {
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: "printReport.php",
            success: function (data) {
                $("#scratcher_report").html(data);
                $("#print").show();
            }
        })
    });

    // Shift Close
    $("#closeShift").one('click', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            method: "POST",
            url: "closeShift.php",
            success: function () {
                $("#close_shift_message").show();
                $("#scratcher_report").hide();
            }
        })
    });

    //Sign Off
    // View Report
    $("#signOff").one('click', function (e) {
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: "signOff.php",
            success: function () {
                window.location.href='http://lotteryreport.ezyro.com';
            }
        })
    });
});
