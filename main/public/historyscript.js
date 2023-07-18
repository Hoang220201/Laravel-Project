$(document).ready(function () {
    var date;
    var loadingIndicatorHistory = $("#loading-indicator-history");
    var history_table = $("#history-table");
    var selectBase = document.getElementById("basehistory");
    var inputDate = document.getElementById("date");


    var multipleCancelButton = new Choices("#choices-multiple-remove-button", {
        removeItemButton: true,
        maxItemCount: 5,
        searchResultLimit: 5,
        renderChoiceLimit: 169,
    });

    function disableSelectInput() {
        selectBase.disabled = true;
        inputDate.disabled = true;
      }
      
      // Function to enable the select element
    function enableSelectInput() {
        selectBase.disabled = false;
        inputDate.disabled = false;
      }
    

    $("#basehistory").change(function () {
        disableSelectInput();
        history_table.addClass("blur");
        loadingIndicatorHistory.show();
        base = $(this).find("option:selected").val();
        date = $("#date").val();
        $.ajax({
            url: "https://api.exchangerate.host/"+ date +"?base="+ base,
            method: "GET",
            /*data: {
                base: base,
                date: date,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },*/
            datatype: "json",
            success: function (data) {
                $("#historytable").html("");
                Object.keys(data.rates).forEach((key)=>{
                    if (key != base) {
                        $("#historytable").append(
                            "<tr><td>" +
                                key +
                                "</td><td>" +
                                data.rates[key] +
                                "</td></tr>"
                        );
                    }
                });
                /*for (var key in obj) {
                    if (key != base) {
                        $("#historytable").append(
                            "<tr><td>" +
                                key +
                                "</td><td>" +
                                obj[key] +
                                "</td></tr>"
                        );
                    }
                }*/
                history_table.removeClass("blur");
                loadingIndicatorHistory.hide();
                enableSelectInput();
            },
        });

        startDate = new Date(date);
        startDate.setMonth(startDate.getMonth() - 1);
        startFormat = formatDate(startDate);

        $.ajax({
            url:
                "https://api.exchangerate.host/timeseries?start_date=" +
                startFormat +
                "&end_date=" +
                date +
                "&base=" +
                base,
            method: "GET",
            dataType: "json",
            success: function (data) {
                console.log(data);
                Object.keys(data.rates).forEach((element) => {
                    if (element == startFormat) {
                        $.each(currencyRows, function (i) {
                            dataRows[i] = (
                                ((data.rates[date][currencyRows[i]] -
                                    data.rates[startFormat][currencyRows[i]]) /
                                    data.rates[startFormat][currencyRows[i]]) *
                                100
                            ).toFixed(2);
                        });
                    }
                });
                $("#barchart-title").html(
                    " (in " + base + ") from " + startFormat + " to " + date
                );
                console.log(dataRows);
                myChart.data.datasets[0].data = dataRows;
                myChart.update();
            },
            error: function (xhr, status, error) {
                // Handle any errors that occurred during the API call
                console.error(error);
            },
        });

    });

    $("#date").on("change", function () {
        history_table.addClass("blur");
        loadingIndicatorHistory.show();
        base = $("#basehistory").find("option:selected").val();
        date = $(this).val();
        disableSelectInput();

        $.ajax({
            url: "/historyChange",
            method: "GET",
            data: {
                base: base,
                date: date,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            datatype: "json",
            success: function (response) {
                $("#historytable").html("");
                const obj = response.rates;
                for (var key in obj) {
                    if (key != base) {
                        $("#historytable").append(
                            "<tr><td>" +
                                key +
                                "</td><td>" +
                                obj[key] +
                                "</td></tr>"
                        );
                    }
                }
                history_table.removeClass("blur");
                loadingIndicatorHistory.hide();
                enableSelectInput();
            },
        });

        currentDate = $(this).val();
        startDate = new Date(currentDate);
        startDate.setMonth(startDate.getMonth() - 1);
        startFormat = formatDate(startDate);

        $.ajax({
            url:
                "https://api.exchangerate.host/timeseries?start_date=" +
                startFormat +
                "&end_date=" +
                currentDate +
                "&base=" +
                base,
            method: "GET",
            dataType: "json",
            success: function (data) {
                console.log(data);
                Object.keys(data.rates).forEach((element) => {
                    if (element == startFormat) {
                        $.each(currencyRows, function (i) {
                            dataRows[i] = (
                                ((data.rates[currentDate][currencyRows[i]] -
                                    data.rates[startFormat][currencyRows[i]]) /
                                    data.rates[startFormat][currencyRows[i]]) *
                                100
                            ).toFixed(2);
                        });
                    }
                });
                $("#barchart-title").html(
                    "( in " +
                        base +
                        ") from " +
                        startFormat +
                        " to " +
                        currentDate
                );
                console.log(dataRows);
                myChart.data.datasets[0].data = dataRows;
                myChart.update();
            },
            error: function (xhr, status, error) {
                // Handle any errors that occurred during the API call
                console.error(error);
            },
        });
    });

    $(".barbutton").click(function () {
        //đổi nút đang được chọn
        $(".barbutton").removeClass("selected");
        $(this).addClass("selected");

        //đổi biểu đổi

        var current_button = $(this).attr("id");
        base = $("#basehistory").find("option:selected").val();
        currentDate = $("#date").val();
        startDate = new Date(currentDate);

        if (current_button == "2M") {
            startDate.setMonth(startDate.getMonth() - 2);
            startFormat = formatDate(startDate);
        } else if (current_button == "1M") {
            startDate.setMonth(startDate.getMonth() - 1);
            startFormat = formatDate(startDate);
        } else if (current_button == "5M") {
            startDate.setMonth(startDate.getMonth() - 5);
            startFormat = formatDate(startDate);
        } else if (current_button == "1Y") {
            startDate.setFullYear(startDate.getFullYear() - 1);
            startFormat = formatDate(startDate);
        }
        console.log(startFormat);

        $.ajax({
            url:
                "https://api.exchangerate.host/timeseries?start_date=" +
                startFormat +
                "&end_date=" +
                currentDate +
                "&base=" +
                base,
            method: "GET",
            dataType: "json",
            success: function (data) {
                console.log(data);
                Object.keys(data.rates).forEach((element) => {
                    if (element == startFormat) {
                        $.each(currencyRows, function (i) {
                            dataRows[i] = (
                                ((data.rates[currentDate][currencyRows[i]] -
                                    data.rates[startFormat][currencyRows[i]]) /
                                    data.rates[startFormat][currencyRows[i]]) *
                                100
                            ).toFixed(2);
                            //console.log(dataRows[i]);
                        });
                    }
                });
                $("#barchart-title").html(
                    "(in " +
                        base +
                        ") from " +
                        startFormat +
                        " to " +
                        currentDate
                );
                //console.log(dataRows);
                myChart.data.datasets[0].data = dataRows;
                myChart.update();
            },
            error: function (xhr, status, error) {
                // Handle any errors that occurred during the API call
                console.error(error);
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

    //khai báo 2 cột x,y trong chart
    var currencyRows = ["EUR", "CLF", "JPY", "CZK", "AUD"];
    var dataRows = [];
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
            //console.log(data);
            //currencyRows = Object.keys(data.rates[startFormat]);
            Object.keys(data.rates).forEach((element) => {
                if (element == startFormat) {
                    $.each(currencyRows, function (i) {
                        dataRows[i] = (
                            ((data.rates[currentFormat][currencyRows[i]] -
                                data.rates[startFormat][currencyRows[i]]) /
                                data.rates[startFormat][currencyRows[i]]) *
                            100
                        ).toFixed(2);
                    });
                }
            });
            $("#barchart-title").html(
                " (in USD) from " + startFormat + " to " + currentFormat
            );
            myChart.data.datasets[0].data = dataRows;
            myChart.update();
        },
        error: function (xhr, status, error) {
            // Handle any errors that occurred during the API call
            console.error(error);
        },
    });

    var ctx = document.getElementById("barChart").getContext("2d");
    var myChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: currencyRows,
            datasets: [
                {
                    label: "Percent",
                    data: dataRows,
                    backgroundColor: function (context) {
                        const value = context.dataset.data[context.dataIndex];
                        return value < 0 ? "#CC0000" : "#A6DAF4";
                    },
                    borderColor: "#000000", // Màu viền cột
                    borderWidth: 2, // Độ dày viền cột
                },
            ],
        },
        options: {
            plugins: {
                legend: {
                    display: false, // Hide legend labels
                },
            },
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true, // Bắt đầu từ 0 trên trục
                },
                x: {
                    ticks: {
                        callback: (value, index, values) => {
                            return value + "%"; // Add percentage symbol to the tick value
                        },
                    },
                },
            },
            indexAxis: "y",
        },
    });
});
