$(document).ready(function () {
    var base;
    var loadingIndicator = $("#loading-indicator");
    var rate_table = $("#rate-table");
    var selectElement = document.getElementById("base");
    var selectTargert = document.getElementById("select-target");
    var selectTime = document.getElementById("select-time");
    var pre_base = selectElement.value;

    /// Function handle change base currency
    $("#base").change(function changeBase() {
        base = $(this).find("option:selected").val();
        selectElement.disabled = true;
        selectTargert.disabled = true;
        selectTime.disabled = true;
        rate_table.addClass("blur");
        lineChart.addClass("blur");
        loadingIndicator.show();

        $.ajax({
            url: "main/public/change-base",
            method: "GET",
            data: {
                base: base,
            },
            datatype: "json",
            success: function (response) {
                targetCurrency = $("#select-target").val();
                timePeriod = $("#select-time").val();

                if (base == targetCurrency) {
                    targetCurrency = pre_lineBase;
                    lineTargetSelect.value = pre_lineBase;
                }

                if (timePeriod == "2 Month") {
                    startDate.setMonth(startDate.getMonth() - 2);
                    startFormat = formatDate(startDate);
                } else if (timePeriod == "1 Month") {
                    startDate.setMonth(startDate.getMonth() - 1);
                    startFormat = formatDate(startDate);
                } else if (timePeriod == "5 Month") {
                    startDate.setMonth(startDate.getMonth() - 5);
                    startFormat = formatDate(startDate);
                } else if (timePeriod == "1 Year") {
                    startDate.setFullYear(startDate.getFullYear() - 1);
                    startFormat = formatDate(startDate);
                }
                $.ajax({
                    url:
                        "https://api.exchangerate.host/timeseries?start_date=" +
                        startFormat +
                        "&end_date=" +
                        currentFormat +
                        "&base=" +
                        base,
                    method: "GET",
                    dataType: "json",
                    success: function (data) {
                        var i = 0;
                        Object.keys(data.rates).forEach((element) => {
                            dateRows[i] = element;
                            rateRows[i] = data.rates[element][targetCurrency];
                            i++;
                        });
                        loadingIndicator.hide();
                        rate_table.removeClass("blur");
                        $("#ratetable").html("");
                        response.forEach(function (val) {
                            //console.log(val);
                            if (val.base != base) {
                                $("#ratetable").append(
                                    "<tr><td>" +
                                        val.code +
                                        "</td><td>" +
                                        val.description +
                                        "</td><td>" +
                                        val.rate +
                                        "</td></tr>"
                                );
                            }
                        });

                        $("#line-chart-title").html(
                            base + " to " + targetCurrency + " conversion table"
                        );

                        myChart.data.datasets[0].data = rateRows;
                        myChart.data.labels = dateRows;
                        myChart.update();
                        lineChart.removeClass("blur");
                        selectElement.disabled = false;
                        selectTargert.disabled = false;
                        selectTime.disabled = false;
                        pre_lineTarget = lineTargetSelect.value;
                        pre_lineBase = lineBaseSelect.value;
                    },
                    error: function (xhr, status, error) {
                        // Handle any errors that occurred during the API call
                        console.error(error);
                        lineChart.removeClass("blur");
                        selectElement.disabled = false;
                        selectTargert.disabled = false;
                        selectTime.disabled = false;
                        alert("Something went wrong. Please try again.");
                    },
                });
            },
            error: function (response) {
                loadingIndicator.hide();
                rate_table.removeClass("blur");
                selectElement.value = pre_base;
                selectElement.disabled = false;
                selectTargert.disabled = false;
                selectTime.disabled = false;
                alert("Something went wrong. Please try again.");
            },
        });
    });

    /// Function handle 'Exchange' button being click
    var amount;
    var convertFrom;
    var convertTo;
    var loadingIndicator_convert = $("#loading-indicator-convert");
    $("#exchangebutton").click(function convert(e) {
        e.preventDefault();
        loadingIndicator_convert.show();

        amount = $("#amount").val();
        convertFrom = $("#convertFrom").val();
        convertTo = $("#choices-multiple-remove-button").val();

        var object = {
            amount: amount,
            convertTo: convertTo,
            convertFrom: convertFrom,
        };

        if (amount == "" || amount <= 0 || amount > 100000000000) {
            alert("Amount value is incorrect");
            loadingIndicator_convert.hide();
        } else if (convertTo == "") {
            alert("Chose currency you want to convert to");
            loadingIndicator_convert.hide();
        } else {
            $.ajax({
                url: "main/public/convert",
                method: "GET",
                data: {
                    obj: object,
                },
                datatype: "json",
                success: function (response) {
                    console.log(response);
                    $("#result").html("");
                    $.each(response, function (i) {
                        // console.log(response[i])
                        $("#result").append(
                            "<tr><td>" +
                                response[i].amount +
                                "</td><td>" +
                                response[i].from +
                                "</td><td>" +
                                response[i].to +
                                "</td><td>" +
                                response[i].result +
                                "</td></tr>"
                        );
                        /*sessionStorage.setItem("amount", response[i].amount);
                        sessionStorage.setItem("from", response[i].from);
                        var toValue = [];
                        toValue = response[i].to;
                        var serializedValues = JSON.stringify(response.to);
                        sessionStorage.setItem("to", serializedValues);*/
                    });
                    loadingIndicator_convert.hide();
                },
                error: function () {
                    alert("Something went wrong. Please try again.");
                    loadingIndicator_convert.hide();
                },
            });
        }
    });

    /// Declare two multiple choice
    var multipleCancelButton = new Choices("#choices-multiple-remove-button", {
        removeItemButton: true,
        maxItemCount: 3,
        searchResultLimit: 3,
        renderChoiceLimit: 169,
    });

    var multipleCancelButton = new Choices("#choices-multiple", {
        removeItemButton: true,
        maxItemCount: 3,
        searchResultLimit: 3,
        renderChoiceLimit: 169,
    });

    ///Diable and Enable 'Get exchange rate' button

    var selectmultiple = document.getElementById("choices-multiple");

    selectmultiple.addEventListener("change", function () {
        validateForm();
    });
    $("#email-input").on("input", function () {
        validateForm();
    });

    function validateForm() {
        var email = $("#email-input").val();
        const regex =
            /([-!#-'*+/-9=?A-Z^-~]+(\.[-!#-'*+/-9=?A-Z^-~]+)*|"([]!#-[^-~ \t]|(\\[\t -~]))+")@([-!#-'*+/-9=?A-Z^-~]+(\.[-!#-'*+/-9=?A-Z^-~]+)*|\[[\t -Z^-~]*])/;

        if (regex.test(email) && selectmultiple.value !== "") {
            $("#email-button").prop("disabled", false);
        } else {
            $("#email-button").prop("disabled", true);
        }
    }

    //// Function handle 'Get exchange rate' button being click
    var email;
    var currencies;
    var icon = document.querySelector(".check-icon");
    $("#email-button").on("click", function registerEmail() {
        $("#email-button").prop("disabled", true);
        base = $("#base").find("option:selected").val();
        email = $("#email-input").val();
        currencies = $('select[name="email-select"]').val();
        console.log(base);

        $.ajax({
            url: "main/public/mailsend",
            method: "POST",
            data: {
                base: base,
                email: email,
                currencies: currencies,
                token: $('meta[name="csrf-token"]').attr("content"),
            },

            success: function (response) {
                $("#email-form").hide();
                $("#email-table h1").hide();
                $("#thankyou").append(
                    "<h1 >Thank you for registering!</h1>" +
                        "<p>You will receive exchange rate from CxC every morning.</p>"
                );
                icon.removeAttribute("hidden");
            },
            error: function () {
                alert("Registration failed. Please try again.");
            },
        });
    });

    // Xử lý 2 dữ liệu ngày lúc load vào page
    function formatDate(date) {
        const day = date.getDate().toString().padStart(2, "0");
        const month = (date.getMonth() + 1).toString().padStart(2, "0");
        const year = date.getFullYear().toString();
        return `${year}-${month}-${day}`;
    }

    var currentDate = new Date();
    var currentFormat = formatDate(currentDate);

    var startDate = new Date();
    startDate.setMonth(startDate.getMonth() - 1);
    var startFormat = formatDate(startDate);

    //khai báo 2 cột x,y trong chart và target currency
    var dateRows = [];
    var rateRows = [];
    var targetCurrency = "VND";
    $.ajax({
        url:
            "https://api.exchangerate.host/timeseries?start_date=" +
            startFormat +
            "&end_date=" +
            currentFormat +
            "&base=USD",
        method: "GET",
        dataType: "json",
        success: function (data) {
            var i = 0;
            Object.keys(data.rates).forEach((element) => {
                dateRows[i] = element;
                rateRows[i] = data.rates[element][targetCurrency];
                i++;
            });
            myChart.data.datasets.data = rateRows;
            myChart.data.labels = dateRows;
            myChart.update();
        },
        error: function (xhr, status, error) {
            // Handle any errors that occurred during the API call
            console.error(error);
            alert("Something went wrong. Please try again.");
        },
    });
    var ctx = document.getElementById("lineChart").getContext("2d");
    var myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: dateRows,
            datasets: [
                {
                    label: targetCurrency,
                    data: rateRows,
                    pointRadius: 0,
                    tension: 0.4,
                },
            ],
        },
        options: {
            plugins: {
                legend: {
                    display: false, // Hide legend labels
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            var label = context.dataset.label || "";
                            var value = context.parsed.y;
                            if (value < 1) {
                                return value.toFixed(8);
                            }
                            return value;
                        },
                    },
                },
            },
            responsive: true,
            interaction: {
                mode: "nearest",
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    ticks: {
                        callback: function (index, value, values) {
                            if (index === 0 || index === values.length - 1) {
                                return this.getLabelForValue(value);
                            }
                            return null; // Hide other tick labels
                        },
                    },
                },
                y: {
                    ticks: {
                        callback: function (value) {
                            if (value < 1) {
                                return value.toFixed(8);
                            }
                            return value;
                        },
                    },
                },
            },
        },
    });

    /// Three select tag for line chart event
    var lineChart = $("#lineChart");
    var timePeriod;
    var lineBaseSelect = document.getElementById("base");
    var pre_lineBase = lineBaseSelect.value;
    var lineTargetSelect = document.getElementById("select-target");
    var pre_lineTarget = lineTargetSelect.value;

    $("#select-target").change(function changeTarget() {
        base = $("#base").val();
        targetCurrency = $(this).find("option:selected").val();
        timePeriod = $("#select-time").val();

        if (base == targetCurrency) {
            base = pre_lineTarget;
            lineBaseSelect.value = pre_lineTarget;
        }
        selectTargert.disabled = true;
        selectTime.disabled = true;
        selectElement.disabled = true;
        lineChart.addClass("blur");

        var startDate = new Date();

        if (timePeriod == "2 Month") {
            startDate.setMonth(startDate.getMonth() - 2);
            startFormat = formatDate(startDate);
        } else if (timePeriod == "1 Month") {
            startDate.setMonth(startDate.getMonth() - 1);
            startFormat = formatDate(startDate);
        } else if (timePeriod == "5 Month") {
            startDate.setMonth(startDate.getMonth() - 5);
            startFormat = formatDate(startDate);
        } else if (timePeriod == "1 Year") {
            startDate.setFullYear(startDate.getFullYear() - 1);
            startFormat = formatDate(startDate);
        }

        $.ajax({
            url:
                "https://api.exchangerate.host/timeseries?start_date=" +
                startFormat +
                "&end_date=" +
                currentFormat +
                "&base=" +
                base,
            method: "GET",
            dataType: "json",
            success: function (data) {
                var i = 0;
                Object.keys(data.rates).forEach((element) => {
                    dateRows[i] = element;
                    rateRows[i] = data.rates[element][targetCurrency];
                    i++;
                });

                $("#line-chart-title").html(
                    base + " to " + targetCurrency + " conversion table"
                );

                console.log(rateRows);

                myChart.data.datasets[0].data = rateRows;
                myChart.data.labels = dateRows;
                myChart.update();
                rateRows = [];
                dateRows = [];
                lineChart.removeClass("blur");
                selectTargert.disabled = false;
                selectTime.disabled = false;
                selectElement.disabled = false;
                pre_lineTarget = lineTargetSelect.value;
                pre_lineBase = lineBaseSelect.value;
            },
            error: function (xhr, status, error) {
                // Handle any errors that occurred during the API call
                console.error(error);
                lineChart.removeClass("blur");
                selectTargert.disabled = false;
                selectTime.disabled = false;
                selectElement.disabled = false;
                alert("Something went wrong. Please try again.");
            },
        });
    });

    $("#select-time").change(function changeTimeLineChart() {
        base = $("#base").find("option:selected").val();
        timePeriod = $(this).val();
        targetCurrency = $("#select-target").val();

        lineChart.addClass("blur");
        selectTargert.disabled = true;
        selectTime.disabled = true;
        var startDate = new Date();

        startDate.setMonth(
            startDate.getMonth() -
                (timePeriod === "2 Month"
                    ? 2
                    : timePeriod === "1 Month"
                    ? 1
                    : timePeriod === "5 Month"
                    ? 5
                    : 12)
        );
        startFormat = formatDate(startDate);

        $.ajax({
            url:
                "https://api.exchangerate.host/timeseries?start_date=" +
                startFormat +
                "&end_date=" +
                currentFormat +
                "&base=" +
                base,
            method: "GET",
            dataType: "json",
            success: function (data) {
                var dateRows = Object.keys(data.rates).map(
                    (element) => element
                );
                var rateRows = Object.keys(data.rates).map(
                    (element) => data.rates[element][targetCurrency]
                );

                myChart.data.datasets[0].data = rateRows;
                myChart.data.labels = dateRows;
                myChart.update();
                rateRows = [];
                dateRows = [];
                lineChart.removeClass("blur");
                selectTargert.disabled = false;
                selectTime.disabled = false;
            },
            error: function (xhr, status, error) {
                // Handle any errors that occurred during the API call
                console.error(error);
                lineChart.removeClass("blur");
                selectTargert.disabled = false;
                selectTime.disabled = false;
                alert("Something went wrong. Please try again.");
            },
        });
    });
});
