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
    public function getRoyaltyDashboardData()
    {
        $db = \Config\Database::connect();

        $query = $db->query("SELECT language_tbl.language_name, COUNT(*) as cnt 
            FROM `author_language`, `language_tbl`, `author_tbl` 
            WHERE author_language.language_id = language_tbl.language_id 
            AND author_tbl.author_id = author_language.author_id 
            AND author_tbl.author_type = 1 
            AND author_tbl.status = '1' 
            GROUP BY author_language.language_id");

        $inactive_query = $db->query("SELECT COUNT(*) as cnt FROM `author_tbl` WHERE status = '0' AND author_type = 1");
        $cancelled_query = $db->query("SELECT COUNT(*) as cnt FROM `author_tbl` WHERE status = '2' AND author_type = 1");

        $i = 0;
        $cnt = [];
        $lang_name = [];

        foreach ($query->getResultArray() as $row) {
            $cnt[$i] = $row['cnt'];
            $lang_name[$i] = $row['language_name'];
            $i++;
        }

        $result['lang_name'] = $lang_name;
        $result['author_cnt'] = $cnt;
        $result['inactive_cnt'] = $inactive_query->getResultArray();
        $result['cancelled_cnt'] = $cancelled_query->getResultArray();

        return $result;
    }
    public function getFreeDashboardData()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT language_tbl.language_name, COUNT(*) as cnt 
            FROM author_language, language_tbl, author_tbl 
            WHERE author_language.language_id = language_tbl.language_id 
              AND author_tbl.author_id = author_language.author_id 
              AND author_tbl.author_type = 2 
              AND author_tbl.status = '1' 
            GROUP BY author_language.language_id
        ");

        $inactive_query = $db->query("
            SELECT COUNT(*) as cnt 
            FROM author_tbl 
            WHERE status = '0' 
              AND author_type = 2
        ");

        $cnt = [];
        $lang_name = [];
        $i = 0;

        foreach ($query->getResultArray() as $row) {
            $cnt[$i] = $row['cnt'];
            $lang_name[$i] = $row['language_name'];
            $i++;
        }

        $result['lang_name'] = $lang_name;
        $result['author_cnt'] = $cnt;
        $result['inactive_cnt'] = $inactive_query->getResultArray();

        return $result;
    }

    public function getMagpubDashboardData()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT language_tbl.language_name, COUNT(*) as cnt 
            FROM author_language, language_tbl, author_tbl 
            WHERE author_language.language_id = language_tbl.language_id 
              AND author_tbl.author_id = author_language.author_id 
              AND author_tbl.author_type = 3 
            GROUP BY author_language.language_id
        ");

        $inactive_query = $db->query("
            SELECT COUNT(*) as cnt 
            FROM author_tbl 
            WHERE status = '0' 
              AND author_type = 3
        ");

        $cnt = [];
        $lang_name = [];
        $i = 0;

        foreach ($query->getResultArray() as $row) {
            $cnt[$i] = $row['cnt'];
            $lang_name[$i] = $row['language_name'];
            $i++;
        }

        $result['lang_name'] = $lang_name;
        $result['author_cnt'] = $cnt;
        $result['inactive_cnt'] = $inactive_query->getResultArray();

        return $result;
    }
    public function getAuthorsMetadata()
    {
        $sql = "SELECT author_tbl.author_id, author_tbl.author_name, author_tbl.status, language_tbl.language_name
                FROM author_tbl
                LEFT JOIN author_language ON author_tbl.author_id = author_language.author_id
                JOIN language_tbl ON author_language.language_id = language_tbl.language_id";

        $author_type_where = '';
        $language_where = '';
        
        $uri = service('uri');
        $segment3 = $uri->getSegment(3);
        $segment4 = $uri->getSegment(4);

        if ($segment3 != "") {
            $author_types = [
                "royalty" => 1,
                "free" => 2,
                "magpub" => 3
            ];
            $author_type_where = " WHERE author_tbl.author_type = " . $author_types[$segment3];
        }

        if ($segment4 != "") {
            $languages = [
                "tamil" => 1,
                "kannada" => 2,
                "telugu" => 3,
                "malayalam" => 4,
                "english" => 5
            ];

            if (($segment4 != "inactive") && ($segment4 != "cancelled")) {
                $language_where = ($author_type_where ? " AND " : " WHERE ") . 
                                  "language_tbl.language_id = " . $languages[$segment4] . " AND author_tbl.status = '1'";
            } elseif ($segment4 != "cancelled") {
                $language_where = ($author_type_where ? " AND " : " WHERE ") . "author_tbl.status = '0'";
            } else {
                $language_where = ($author_type_where ? " AND " : " WHERE ") . "author_tbl.status = '2'";
            }
        }

        $sql .= $author_type_where . $language_where;

        $query = $this->db->query($sql);
        log_message('debug', $this->db->getLastQuery());

        $result_array = $query->getResultArray();
        $result = null;

        if (!empty($result_array)) {
            $i = 0;
            foreach ($result_array as $row) {
                $result['author_name'][$i] = $row['author_name'];
                $result['author_id'][$i] = $row['author_id'];
                $result['status'][$i] = $row['status'];
                $result['lang_name'][$i] = $row['language_name'];
                $i++;
            }
        }

        return $result;
    }

    public function getActivateAuthorDetails()
    {
        $uri = service('uri');
        $author_id = $uri->getSegment(3);

        $auth_details = $this->db->query("SELECT * FROM author_tbl WHERE author_id = ?", [$author_id])->getRowArray();
        $result['author_details'] = $auth_details;

        $auth_language = $this->db->query("SELECT * FROM author_language WHERE author_id = ?", [$author_id])->getResultArray();
        $result['author_language'] = $auth_language;

        $copyright_mapping_details = $this->db->query("SELECT * FROM copyright_mapping WHERE author_id = ?", [$author_id])->getResultArray();
        $result['copyright_mapping'] = $copyright_mapping_details;

        $publisher_details = $this->db->query("SELECT * FROM publisher_tbl WHERE user_id = ?", [$auth_details['copyright_owner']])->getRowArray();
        $result['publisher_details'] = $publisher_details;

        $user_details = $this->db->query("SELECT * FROM users_tbl WHERE user_id = ?", [$auth_details['copyright_owner']])->getRowArray();
        $result['user_details'] = $user_details;

        $book_details = $this->db->query("SELECT * FROM book_tbl WHERE author_name = ?", [$author_id])->getResultArray();
        $result['book_details'] = $book_details;

        return $result;
    }

    public function activateAuthor($author_id, $send_mail_flag)
    {
        if ($send_mail_flag) {
            $this->sendActivateAuthorMail($author_id);
        }
        $current_date = date("Y-m-d H:i:s");
        $sql = "UPDATE author_tbl SET status = '1', activated_at = '$current_date' WHERE author_id = ?";
        $this->db->query($sql, [$author_id]);

        return $this->db->affectedRows();
    }
    public function addAuthor()
    {
        $email = $_POST['email'];

        $user_query = $this->db->query("SELECT * FROM users_tbl WHERE email = '$email'");
        if ($user_query->getNumRows() == 1) {
            $user_details_query = $this->db->query("SELECT * FROM users_tbl WHERE email = '$email'");
            $user_details = $user_details_query->getResultArray()[0];
            $copyright_owner = $user_details['user_id'];
        } else {
            $password_str = "books123";
            $password = md5($password_str);
            $user_data = [
                "username" => $_POST['author_name'],
                "password" => $password,
                "email" => $_POST['email'],
                "user_type" => 2
            ];
            $this->db->table("users_tbl")->insert($user_data);
            $copyright_owner = $this->db->insertID();
        }

        $url_name = $_POST['author_url'];
        $builder = $this->db->table('author_tbl');
        $builder->where('url_name', $url_name);
        $author_query = $builder->get();
        log_message('debug', $author_query->getNumRows());

        if ($author_query->getNumRows() == 1) {
            return 2;
        }

        $author_data = [
            "author_name" => $_POST['author_name'],
            "url_name" => $_POST['author_url'],
            "author_type" => $_POST['author_type'],
            "author_image" => $_POST['author_img_url'],
            "copy_right_owner_name" => $_POST['copyright_owner'],
            "copyright_owner" => $copyright_owner,
            "relationship" => $_POST['relationship'],
            "mobile" => $_POST['mob_no'],
            "email" => $_POST['email'],
            "address" => $_POST['address'],
            "agreement_details" => $_POST['agreement_details'],
            "agreement_ebook_count" => $_POST['agreement_ebook_count'],
            "agreement_audiobook_count" => $_POST['agreement_audiobook_count'],
            "agreement_paperback_count" => $_POST['agreement_paperback_count'],
            "fb_url" => $_POST['fbook_url'],
            "twitter_url" => $_POST['twitter_url'],
            "blog_url" => $_POST['blog_url'],
            "description" => $_POST['pustaka_author_desc'],
            "gender" => $_POST['gender']
        ];
        $this->db->table('author_tbl')->insert($author_data);
        $last_inserted_author_id = $this->db->insertID();

        $author_state = $_POST['author_state'];
        if ($author_state == 1) {
            $publisher_data = [
                "publisher_name" => $_POST['author_name'],
                "publisher_image" => $_POST['author_img_url'],
                "mobile" => $_POST['mob_no'],
                "email_id" => $_POST['email'],
                "copyright_owner" => $copyright_owner,
                "bank_acc_no" => $_POST['acc_no'],
                "ifsc_code" => $_POST['ifsc_code'],
                "pan_number" => $_POST['pan_no'],
                "bank_acc_type" => $_POST['bank_name'],
                "status" => 1,
                "created_at" => date("Y-m-d H:i:s")
            ];
            $this->db->table("publisher_tbl")->insert($publisher_data);
        }

        $copyright_data = [
            "copyright_owner" => $copyright_owner,
            "author_id" => $last_inserted_author_id
        ];
        $this->db->table("copyright_mapping")->insert($copyright_data);

        if ($_POST['tam_fir_name'] !== "") {
            $regional_name = $_POST['tam_fir_name'] . ' ' . $_POST['tam_lst_name'];
            $tmp = [
                "display_name1" => $_POST['tam_fir_name'],
                "display_name2" => $_POST['tam_lst_name'],
                "regional_author_name" => $regional_name,
                "author_id" => $last_inserted_author_id,
                "language_id" => 1
            ];
            $this->db->table('author_language')->insert($tmp);
        }

        if ($_POST['tel_fir_name'] !== "") {
            $regional_name = $_POST['tel_fir_name'] . ' ' . $_POST['tel_lst_name'];
            $tmp = [
                "display_name1" => $_POST['tel_fir_name'],
                "display_name2" => $_POST['tel_lst_name'],
                "regional_author_name" => $regional_name,
                "author_id" => $last_inserted_author_id,
                "language_id" => 3
            ];
            $this->db->table('author_language')->insert($tmp);
        }

        if ($_POST['kan_fir_name'] !== "") {
            $regional_name = $_POST['kan_fir_name'] . ' ' . $_POST['kan_lst_name'];
            $tmp = [
                "display_name1" => $_POST['kan_fir_name'],
                "display_name2" => $_POST['kan_lst_name'],
                "regional_author_name" => $regional_name,
                "author_id" => $last_inserted_author_id,
                "language_id" => 2
            ];
            $this->db->table('author_language')->insert($tmp);
        }

        if ($_POST['mal_fir_name'] !== "") {
            $regional_name = $_POST['mal_fir_name'] . ' ' . $_POST['mal_lst_name'];
            $tmp = [
                "display_name1" => $_POST['mal_fir_name'],
                "display_name2" => $_POST['mal_lst_name'],
                "regional_author_name" => $regional_name,
                "author_id" => $last_inserted_author_id,
                "language_id" => 4
            ];
            $this->db->table('author_language')->insert($tmp);
        }

        if ($_POST['eng_fir_name'] !== "") {
            $regional_name = $_POST['eng_fir_name'] . ' ' . $_POST['eng_lst_name'];
            $tmp = [
                "display_name1" => $_POST['eng_fir_name'],
                "display_name2" => $_POST['eng_lst_name'],
                "regional_author_name" => $regional_name,
                "author_id" => $last_inserted_author_id,
                "language_id" => 5
            ];
            $this->db->table('author_language')->insert($tmp);
        }

        if ($last_inserted_author_id > 0) {
            return 1;
        } else {
            return 0;
        }
    }


}
