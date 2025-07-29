window.onload = function () {
  var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    title: {},
    data: [
      {
        type: "pie",
        startAngle: 240,
        yValueFormatString: '##0.00"%"',
        indexLabel: "{label} {y}",
        dataPoints: [
          { y: 35, label: "Complete Exam" },
          { y: 65, label: "Pending Exam" },
        ],
      },
    ],
  });
  chart.render();

  var chart1 = new CanvasJS.Chart("chartContainer1", {
    animationEnabled: true,
    theme: "dark1", // "light1", "light2", "dark1", "dark2"
    backgroundColor: "#4b78bb",

    title: {
      text: "Answers Sheet Checking",
    },
    axisY: {
      // title: "Reserves(MMbbl)",
    },
    dataPointWidth: 20,
    data: [
      {
        color: "white",
        type: "column",
        showInLegend: true,
        legendMarkerColor: "grey",
        // legendText: "MMbbl = one million barrels",
        dataPoints: [
          { y: 85, label: "Exam 1" },
          { y: 30, label: "Exam 2" },
          { y: 50, label: "Exam 3" },
          { y: 60, label: "Exam 4" },
          { y: 10, label: "Exam 5" },
        ],
      },
    ],
  });
  chart1.render();
};
