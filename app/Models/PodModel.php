<?php

namespace App\Models;

use CodeIgniter\Model;

class PodModel extends Model
{

    public function getPODPublishers()
    {
        // First query
        $pod_publisher_sql = "SELECT * FROM pod_publisher WHERE status=1";
        $pod_publisher_query = $this->db->query($pod_publisher_sql);
        $data['publisher'] = $pod_publisher_query->getResultArray(); //  fixed

        // Second query
        $sql = "SELECT * FROM pod_publisher WHERE status=1";
        $query = $this->db->query($sql);
        $result = $query->getResultArray(); //  fixed

        $data['publisher_details'] = $result[0] ?? null; // avoid undefined index

        return $data;
    }

    public function PodpublisherSubmit($publisher_data)
    {
        $db = db_connect();

        if ($db->table('pod_publisher')->insert($publisher_data)) {
            return ['status' => 'success'];
        }
        return ['status' => 'error'];
    }


}
