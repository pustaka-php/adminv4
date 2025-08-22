<?php

namespace App\Models;

use CodeIgniter\Model;

class PodModel extends Model
{
    protected $table = 'pod_publisher';  // optional, set your table name

    public function getPODPublishers()
    {
        // First query
        $pod_publisher_sql = "SELECT * FROM pod_publisher WHERE status=1";
        $pod_publisher_query = $this->db->query($pod_publisher_sql);
        $data['publisher'] = $pod_publisher_query->getResultArray(); // ✅ fixed

        // Second query
        $sql = "SELECT * FROM pod_publisher WHERE status=1";
        $query = $this->db->query($sql);
        $result = $query->getResultArray(); // ✅ fixed

        $data['publisher_details'] = $result[0] ?? null; // avoid undefined index

        return $data;
    }
}
