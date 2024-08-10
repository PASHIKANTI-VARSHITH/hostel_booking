<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['hostel', 'fees(k)'],
          ['prathiba', 90000],
          ['spoorthy', 77000],
          ['c v Raman', 90000],
          ['nalanda', 88000],
          ['tagore', 88000],
          ['vivekananda', 75000]
          ['bhatnagar', 88000]
          ['ramanujan', 88000]
        ]);

        var options = {
          title: 'Hostel fee structure',
          subtitle: 'fees'
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
  </head>
  <body>
    <div id="columnchart_material" style="width: 800px; height: 500px;"></div>
  </body>
</html>