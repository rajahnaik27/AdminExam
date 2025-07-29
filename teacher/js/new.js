function clickHandle(evt, animalName) {
  let i, tabcontent, tablinks;

  // This is to clear the previous clicked content.
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Set the tab to be "active".
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Display the clicked tab and set it to active.
  document.getElementById(animalName).style.display = "block";
  evt.currentTarget.className += " active";
}

// display chart

var xValues = ["complete checking", "pending checking", ];
var yValues = [35, 65 ];
var barColors = [
  "#21618C",
  "#B5D8EF"
];

new Chart("myCharts", {
  type: "pie",
  data: {
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }],
    labels: xValues,
  },
  options: {
    title: {
      display: true,
    }
    
  }
});

var chart1 = new CanvasJS.Chart("chartContainer1", {
animationEnabled: true,
theme: "dark1", // "light1", "light2", "dark1", "dark2"
backgroundColor: "#4b78bb",

title: {
  text: "Ans Sheets",
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
      { y: 35, label: "Exam 2" },
      { y: 65, label: "Exam 3" },
      { y: 45, label: "Exam 3" },
      
    ],
  },
],
});
chart1.render();

