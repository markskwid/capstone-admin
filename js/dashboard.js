
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  const today = new Date()
  
  var data = google.visualization.arrayToDataTable([
  ['Task', 'Customer per month'],
  ['SUCCESSFUL', 8],
  ['CANCELED', 2]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {pieStartAngle: 100, is3D: true, backgroundColor: 'transparent', 'width':480, 'height':300, legend : { position : 'bottom' },
  titleTextStyle: { fontSize: 20}};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}