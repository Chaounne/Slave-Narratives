<?php
namespace App\Models;

use CodeIgniter\Model;

class ModelVisitor extends Model {

    protected $table='visitor';
    protected $allowedFields=['route','visit_count','date'];

    public function getVisits() {
        $date = date("Y-m-d");

        return $this->asArray()
            ->selectSum('visit_count')
            ->Where(['date' => $date])
            ->notLike("route", "/slave_narratives/narrative/")
            ->findAll();
    }

    public function getVisitsNarratives() {
        $date = date("Y-m-d");

        return $this->asArray()
            ->selectSum('visit_count')
            ->Where(['date' => $date])
            ->Like("route", "/slave_narratives/narrative/")
            ->findAll();
    }

    public function getMonthlyData() {
        // Build the SQL query
        $this->select("DATE_FORMAT(date, '%Y-%m') AS mois, SUM(visit_count) AS nombre_de_visites")
            ->groupBy("mois")
            ->orderBy("mois");

        // Execute the query and return the result as an array
        return $this->findAll();
    }
}