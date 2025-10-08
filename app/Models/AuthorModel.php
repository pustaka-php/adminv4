<?php 
namespace App\Models;

use CodeIgniter\Model;

class AuthorModel extends Model
{
    protected $table      = 'author_tbl';
    protected $primaryKey = 'author_id';
    protected $returnType = 'array';
    protected $db; 
    
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getAuthorDetails()
    {
        $query = $this->db->table($this->table)
                          ->orderBy('author_name')
                          ->get();

        return $query->getResult();
    }

    public function getRoyaltyDistribution()
    {
        $royalty_author_distribution_query = $this->db->query("SELECT COUNT(*) num_authors, DATE_FORMAT(created_at, '%m-%y') as month_on_board 
            FROM author_tbl 
            WHERE author_type = '1' 
            GROUP BY month_on_board 
            ORDER BY created_at ASC");

        $i = 0;
        $month_on_board = [];
        $num_authors = [];

        foreach ($royalty_author_distribution_query->getResultArray() as $row) {
            $month_on_board[$i] = $row['month_on_board'];
            $num_authors[$i] = $row['num_authors'];
            $i++;
        }

        $result['month_details'] = $month_on_board;
        $result['authors'] = $num_authors;

        return $result;
    }

    public function getFreeDistribution()
    {
        $free_author_distribution_query = $this->db->query("SELECT COUNT(*) num_authors, DATE_FORMAT(created_at, '%m-%y') as month_on_board 
            FROM author_tbl 
            WHERE author_type = '2' 
            GROUP BY month_on_board 
            ORDER BY created_at ASC");

        $i = 0;
        $free_month_on_board = [];
        $free_num_authors = [];

        foreach ($free_author_distribution_query->getResultArray() as $row) {
            $free_month_on_board[$i] = $row['month_on_board'];
            $free_num_authors[$i] = $row['num_authors'];
            $i++;
        }

        $result1['free_month_details'] = $free_month_on_board;
        $result1['free_authors'] = $free_num_authors;

        return $result1;
    }

    public function getMagpubDistribution()
    {
        $magpub_author_distribution_query = $this->db->query("SELECT COUNT(*) num_authors, DATE_FORMAT(created_at, '%m-%y') as month_on_board 
            FROM author_tbl 
            WHERE author_type = '3' 
            GROUP BY month_on_board 
            ORDER BY created_at ASC");

        $i = 0;
        $magpub_month_on_board = [];
        $magpub_num_authors = [];

        foreach ($magpub_author_distribution_query->getResultArray() as $row) {
            $magpub_month_on_board[$i] = $row['month_on_board'];
            $magpub_num_authors[$i] = $row['num_authors'];
            $i++;
        }

        $result2['magpub_month_details'] = $magpub_month_on_board;
        $result2['magpub_authors'] = $magpub_num_authors;

        return $result2;
    }
    public function getDashboardData()
    {
        $query = $this->db->query("SELECT author_type, status, count(*) author_cnt FROM author_tbl GROUP BY author_type, status;");
        $i = 0;
        $result['active_royalty_auth_cnt'] = 0;
        $result['inactive_royalty_auth_cnt'] = 0;
        $result['active_free_auth_cnt'] = 0;
        $result['inactive_free_auth_cnt'] = 0;
        $result['active_mag_auth_cnt'] = 0;
        $result['inactive_mag_auth_cnt'] = 0;
        $result['non-matching-condition'] = 0;

        foreach ($query->getResultArray() as $row) {
            $author_type = $row['author_type'];
            $author_status = $row['status'];
            $author_count = $row['author_cnt'];

            if (($author_status == "1") && ($author_type == "1"))
                $result['active_royalty_auth_cnt'] = $author_count;
            else if (($author_status == "0") && ($author_type == "1"))
                $result['inactive_royalty_auth_cnt'] = $author_count;
            else if (($author_status == "1") && ($author_type == "2"))
                $result['active_free_auth_cnt'] = $author_count;
            else if (($author_status == "0") && ($author_type == "2"))
                $result['inactive_free_auth_cnt'] = $author_count;
            else if (($author_status == "1") && ($author_type == "3"))
                $result['active_mag_auth_cnt'] = $author_count;
            else if (($author_status == "0") && ($author_type == "3"))
                $result['inactive_mag_auth_cnt'] = $author_count;
            else
                $result['non-matching-condition'] = $author_count;

            $i++;
        }

        return $result;
    }

}
