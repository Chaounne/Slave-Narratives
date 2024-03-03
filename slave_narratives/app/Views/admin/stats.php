<body>
<div id="stats-page">
<?php

$dataForGraph = [];

foreach ($monthly_data as $data) {
    $date = date_create_from_format('Y-m', $data['mois']);
    $month = date_format($date, 'F Y');

    $dataForGraph[$month] = (int)$data['nombre_de_visites'];
}
?>

    <p><?= lang('Admin.year_select') ?></p>

    <select id="year-select">
        <?php
        $currentYear = date('Y');
        $years = array_unique(array_map(function($date) {
            return date('Y', strtotime($date));
        }, array_keys($dataForGraph)));

        foreach ($years as $year) {
            $selected = ($year == $currentYear) ? 'selected' : '';
            echo "<option value=\"$year\" $selected>$year</option>";
        }
        ?>
    </select>

<div id="chart-container">
    <canvas id="visits-chart"></canvas>
</div>
</div>

<script>
    var ctx = document.getElementById('visits-chart').getContext('2d');
    var monthlyData = <?= json_encode($dataForGraph); ?>;
    var currentYear = <?= $currentYear; ?>;

    var defaultData = {};
    for (var month in monthlyData) {
        if (month.includes(currentYear)) {
            defaultData[month] = monthlyData[month];
        }
    }

    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(defaultData),
            datasets: [{
                label: 'Nombre de visites',
                data: Object.values(defaultData),
                backgroundColor: 'rgba(192,141,75,0.2)',
                borderColor: 'rgb(192,128,75)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    document.getElementById('year-select').addEventListener('change', function() {
        var selectedYear = this.value;

        var filteredData = {};
        for (var month in monthlyData) {
            if (month.includes(selectedYear)) {
                filteredData[month] = monthlyData[month];
            }
        }

        chart.data.labels = Object.keys(filteredData);
        chart.data.datasets[0].data = Object.values(filteredData);
        chart.update();
    });
</script>

</body>