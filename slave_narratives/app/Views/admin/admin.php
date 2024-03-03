<?php
use App\Models\ModelAdmin;

    if (!empty($_SESSION)) {

        // Récupérer le message de fin s'il existe
        $valid_message = isset($_SESSION['valid_message']) ? $_SESSION['valid_message'] : '';
        // Effacement des variables de session
        unset($_SESSION['valid_message']);

        if (!empty($valid_message)) {
            echo('<p class="valid-message">'.$valid_message.'</p>');
        }

        echo('<div id="admin-container">');
            echo('<img id="parchemin-admin" src="'.base_url().'/resources/admin_parchment.png" alt="Parchemin admin">');
            echo('<div id="admin-content">');

                $modelAdmin = model(ModelAdmin::class);
                $admin = $modelAdmin->getAdminFromId($_SESSION['idAdmin']);

                echo('<h3 id="admin-title">'.lang('Admin.welcome').'<br><span id="mail-admin">'.$admin['email'].'</span></h3>');
                
                echo('<a id="modif-infos-link" href="'.site_url().'admin/create"><h3 id="admin-links">'.lang('Admin.option_create').'</h3></a>');
                echo('<a id="modif-infos-link" href="'.site_url().'admin/editMail"><h3 id="admin-links">'.lang('Admin.option_edit_email').'</h3></a>');
                echo('<a id="modif-infos-link" href="'.site_url().'admin/editPassword"><h3 id="admin-links">'.lang('Admin.option_edit_password').'</h3></a>');
                echo('<a id="modif-infos-link" href="'.site_url().'admin/delete"><h3 id="admin-links">'.lang('Admin.option_delete').'</h3></a>');
                echo('<a id="modif-infos-link" href="'.site_url().'admin/stats"><h3 id="admin-links">'.lang('Admin.option_stats').'</h3></a>');
                echo('<a id="modif-infos-link" href="'.site_url().'resources/Documentation_utilisateur.pdf" target="_blank" ><h3 id="admin-links">'.lang('Admin.option_guide').'</h3></a><br>');

                if(isset($stats_daily)){
                    if(isset($stats_daily[0]["visit_count"])){
                        echo("<h3 class='visits'>".lang('Admin.visits') . $stats_daily[0]["visit_count"]. "</h3>");
                    } else {
                        echo("<h3 class='visits'>".lang('Admin.visits') .  "0 </h3>");
                    }
                } else {
                    echo("<h3 class='visits'>".lang('Admin.sql_error')."</h3>");
                }

                if(isset($narratives_stats)){
                    if(isset($narratives_stats[0]["visit_count"])){
                        echo("<h3 class='visits'>".lang('Admin.access') . $narratives_stats[0]["visit_count"]. "</h3>");
                    } else {
                        echo("<h3 class='visits'>".lang('Admin.access') . "0 </h3>");
                    }
                } else{
                    echo("<h3 class='visits'>".lang('Admin.sql_error')."</h3>");
                }

                // Tableau associatif pour stocker les données mensuelles
                $dataForGraph = [];

                // Parcours des données existantes et remplissage du tableau associatif
                foreach ($monthly_data as $data) {
                    // Convertir le mois au format "YYYY-MM" en mois lisible (par exemple, "Janvier 2023")
                    $date = date_create_from_format('Y-m', $data['mois']);
                    $month = date_format($date, 'F Y');

                    // Stocker le nombre de visites dans le tableau associatif
                    $dataForGraph[$month] = (int)$data['nombre_de_visites'];
                }

                // Filtrer les données pour le mois courant
                $currentMonth = date('F Y'); // Récupère le mois courant au format "F Y"
                $currentMonthData = [$currentMonth => $dataForGraph[$currentMonth]];

                //L'affichage du graphique
                echo('<div id="chart-container"><canvas id="visits-chart"></canvas></div>');

            echo('</div>');
        echo('</div>');
    }
?>
<script>
    var ctx = document.getElementById('visits-chart').getContext('2d');

    // Utilisez directement le tableau PHP
    var monthlyData = <?= json_encode($currentMonthData); ?>;

    var chart = new Chart(ctx, {
        type: 'bar', // ou 'line' pour un graphique en ligne
        data: {
            labels: Object.keys(monthlyData),
            datasets: [{
                label: '<?= lang('Admin.visits_in_current_month'); ?>',
                data: Object.values(monthlyData),
                backgroundColor: 'rgba(192,141,75,0.2)', // Couleur de remplissage des barres/points
                borderColor: 'rgb(192,128,75)', // Couleur des bordures des barres/points
                borderWidth: 1 // Largeur des bordures des barres/points
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
</script>
