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
    public function editAuthor()
    {
        $uri = service('uri');
        $author_id = $uri->getSegment(3);

        $author_sql = "SELECT * FROM `author_tbl` WHERE author_id = " . $author_id;
        $author_query1 = $this->db->query($author_sql);
        $author_details = $author_query1->getResultArray()[0];
        $result["author_details"] = $author_details;

        $author_lang_sql = "SELECT * FROM `author_language` WHERE author_id = " . $author_id;
        $author_lang_query = $this->db->query($author_lang_sql);
        $author_lang_details = $author_lang_query->getResultArray()[0];
        $result["author_lang_details"] = $author_lang_details;

        $publisher_sql = "SELECT * FROM `publisher_tbl` WHERE copyright_owner = " . $author_details['copyright_owner'];
        $publisher_query = $this->db->query($publisher_sql);
        if ($publisher_query->getNumRows() == 1) {
            $publisher_details = $publisher_query->getResultArray()[0];
            $result["publisher_details"] = $publisher_details;
        } else {
            $result["publisher_details"] = NULL;
        }

        $copyright_mapping_sql = "SELECT * FROM `copyright_mapping` WHERE author_id = " . $author_id;
        $copyright_mapping_query = $this->db->query($copyright_mapping_sql);
        $copyright_details = $copyright_mapping_query->getResultArray();
        $result["copyright_mapping_details"] = $copyright_details;

        $user_sql = "SELECT * FROM `users_tbl` WHERE user_id = " . $author_details['copyright_owner'];
        $user_query = $this->db->query($user_sql);
        $user_details = $user_query->getResultArray()[0];
        $result["user_details"] = $user_details;

        $author_lang_sql = "SELECT * FROM `author_language` WHERE author_id = " . $author_id;
        $author_lang_query = $this->db->query($author_lang_sql);
        $author_lang_details = $author_lang_query->getResultArray();
        $result["author_language_details"] = $author_lang_details;

        return $result;
    }

    public function editAuthorBasicDetails()
    {
        $post = service('request')->getPost();

        $update_data = [
            "author_name" => $post["author_name"],
            "url_name" => $post["url_name"],
            "author_image" => $post["author_image"],
            "description" => $post["description"],
            "gender" => $post["author_gender"],
            "author_type" => $post["author_type"],
            "copy_right_owner_name" => $post["copy_right_owner_name"],
            "copyright_owner" => $post["copyright_owner"],
            "address" => $post["address"],
            "user_id" => $post["user_id"]
        ];

        $builder = $this->db->table('author_tbl');
        $builder->where('author_id', $post['author_id']);
        $builder->update($update_data);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function editAuthorAgreementDetails()
    {
        $post = service('request')->getPost();

        $update_data = [
            "agreement_details" => $post["agreement_details"],
            "agreement_ebook_count" => $post["agreement_ebook_count"],
            "agreement_audiobook_count" => $post["agreement_audiobook_count"],
            "agreement_paperback_count" => $post["agreement_paperback_count"]
        ];

        $builder = $this->db->table('author_tbl');
        $builder->where('author_id', $post['author_id']);
        $builder->update($update_data);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function editAuthorBankDetails()
    {
        $post = service('request')->getPost();

        $update_data = [
            "bank_acc_no" => $post["bank_acc_no"],
            "bank_acc_name" => $post["bank_acc_name"],
            "bank_acc_type" => $post["bank_acc_type"],
            "ifsc_code" => $post["ifsc_code"],
            "pan_number" => $post["pan_number"],
            "bonus_percentage" => $post["bonus_percentage"]
        ];

        $builder = $this->db->table('publisher_tbl');
        $builder->where('copyright_owner', $post['copyright_owner']);
        $builder->update($update_data);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function editAuthorPublisherDetails()
    {
        $post = service('request')->getPost();

        $update_data = [
            "mobile" => $post["mobile"],
            "email_id" => $post["email_id"],
            "address" => $post["address"],
            "publisher_url_name" => $post["publisher_url_name"],
            "publisher_image" => $post["publisher_image"]
        ];

        $builder = $this->db->table('publisher_tbl');
        $builder->where('copyright_owner', $post['copyright_owner']);
        $builder->update($update_data);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function editAuthorOld($author_id)
    {
        $author_sql = "SELECT * FROM `author_tbl` WHERE author_id = " . $author_id;
        $author_query1 = $this->db->query($author_sql);
        $author_details = $author_query1->getResultArray()[0];

        $author_lang_sql = "SELECT * FROM `author_language` WHERE author_id = " . $author_id;
        $author_lang_query = $this->db->query($author_lang_sql);
        $author_lang_details = $author_lang_query->getResultArray()[0];

        $publisher_sql = "SELECT * FROM `publisher_tbl` WHERE copyright_owner = " . $author_details['copyright_owner'];
        $publisher_query = $this->db->query($publisher_sql);
        $publisher_details = $publisher_query->getResultArray()[0];

        $copyright_mapping_sql = "SELECT copyright_mapping.copyright_owner, author_tbl.author_name FROM `copyright_mapping`, `author_tbl` WHERE copyright_mapping.copyright_owner = " . $author_details['copyright_owner'] . " and author_tbl.author_id = copyright_mapping.author_id";
        $copyright_mapping_query = $this->db->query($copyright_mapping_sql);
        $copyright_details = $copyright_mapping_query->getResultArray();

        $user_sql = "SELECT * FROM `users_tbl` WHERE user_id = " . $author_details['copyright_owner'];
        $user_query = $this->db->query($user_sql);
        $user_details = $user_query->getResultArray()[0];

        $result = [];
        $result['author_name'] = $author_details['author_name'];
        $result['url_name'] = $author_details['url_name'];
        $result['author_image'] = $author_details['author_image'];
        $result['gender'] = $author_details['gender'];
        $result['fbook_url'] = $author_details['fb_url'];
        $result['author_type'] = $author_details['author_type'];
        $result['twitter_url'] = $author_details['twitter_url'];
        $result['blog_url'] = $author_details['blog_url'];
        $result['description'] = $author_details['description'];
        $result['copyright_owner'] = $author_details['copy_right_owner_name'];
        $result['relationship'] = $author_details['relationship'];
        $result['mobile'] = $author_details['mobile'];
        $result['email'] = $author_details['email'];
        $result['address'] = $author_details['address'];

        $result['pan_number'] = $publisher_details['pan_number'];
        $result['bank_acc_no'] = $publisher_details['bank_acc_no'];
        $result['bank_acc_name'] = $publisher_details['bank_acc_name'];
        $result['ifsc_code'] = $publisher_details['ifsc_code'];
        $result['bank_account_type'] = $publisher_details['bank_acc_type'];

        $result['copyright_details'] = $copyright_details;

        $result['username'] = $user_details['username'];
        if ($user_details['password'] == '4732210395731ca375874a1e7c8f62f6')
            $result['password'] = "Deafult Password";
        else
            $result['password'] = "No Deafult Password";

        if ($user_details['user_type'] == 1)
            $result['user_type'] = "Normal User";
        elseif ($user_details['user_type'] == 2)
            $result['user_type'] = "Author";
        else
            $result['user_type'] = $user_details['user_type'];

        if (isset($author_lang_details)) {
            if ($author_lang_details['langauge_id'] == 1) {
                $result['tam_fir_name'] = $author_lang_details['display_name1'];
                $result['tam_lst_name'] = $author_lang_details['display_name2'];
            } elseif ($author_lang_details['langauge_id'] == 2) {
                $result['kan_fir_name'] = $author_lang_details['display_name1'];
                $result['kan_lst_name'] = $author_lang_details['display_name2'];
            } elseif ($author_lang_details['langauge_id'] == 3) {
                $result['tel_fir_name'] = $author_lang_details['display_name1'];
                $result['tel_lst_name'] = $author_lang_details['display_name2'];
            } elseif ($author_lang_details['langauge_id'] == 4) {
                $result['mal_fir_name'] = $author_lang_details['display_name1'];
                $result['mal_lst_name'] = $author_lang_details['display_name2'];
            } elseif ($author_lang_details['langauge_id'] == 5) {
                $result['eng_fir_name'] = $author_lang_details['display_name1'];
                $result['eng_lst_name'] = $author_lang_details['display_name2'];
            }
        }

        return $result;
    }

    public function getEditAuthorLinkData($author_id)
    {
        $sql = "SELECT * FROM author_tbl WHERE author_id = $author_id";
        $query = $this->db->query($sql);
        $link_data = $query->getResultArray();
        $result['link_data'] = $link_data[0];
        return $result;
    }

    public function editAuthorPost()
    {
        $post = service('request')->getPost();

        $data = [
            "author_name" => $post['author_name'],
            "url_name" => $post['author_url'],
            "author_type" => $post['author_type'],
            "author_image" => $post['author_image'],
            "copy_right_owner_name" => $post['copyright_owner'],
            "relationship" => $post['relationship'],
            "mobile" => $post['mob_no'],
            "email" => $post['email'],
            "address" => $post['address'],
            "fb_url" => $post['fbook_url'],
            "twitter_url" => $post['twitter_url'],
            "blog_url" => $post['blog_url'],
            "description" => $post['pustaka_author_desc'],
            "gender" => $post['gender']
        ];

        $builder = $this->db->table('author_tbl');
        $builder->where('author_id', $post['author_id']);
        $builder->update($data);

        $author_sql = "SELECT copyright_owner FROM `author_tbl` WHERE author_id = " . $post['author_id'];
        $author_query1 = $this->db->query($author_sql);
        $author_details = $author_query1->getResultArray()[0];

        $data1 = [
            "bank_acc_no" => $post['acc_no'],
            "ifsc_code" => $post['ifsc_code'],
            "pan_number" => $post['pan_no'],
            "bank_acc_name" => $post['acc_name'],
            "bank_acc_type" => $post['bank_name']
        ];

        $builder = $this->db->table('publisher_tbl');
        $builder->where('copyright_owner', $author_details['copyright_owner']);
        $builder->update($data1);

        // Update author_language
        $lang_fields = [
            'tam' => 1, 'kan' => 2, 'tel' => 3, 'mal' => 4, 'eng' => 5
        ];

        foreach ($lang_fields as $prefix => $lang_id) {
            if (!empty($post[$prefix . '_fir_name'])) {
                $regional_name = $post[$prefix . '_fir_name'] . ' ' . $post[$prefix . '_lst_name'];
                $tmp = [
                    "display_name1" => $post[$prefix . '_fir_name'],
                    "display_name2" => $post[$prefix . '_lst_name'],
                    "regional_author_name" => $regional_name,
                    "author_id" => $post['author_id'],
                    "language_id" => $lang_id
                ];
                $builder = $this->db->table('author_language');
                $builder->where('author_id', $post['author_id']);
                $builder->update($tmp);
            }
        }

        return 1;
    }

    public function editAuthorLinks()
    {
        $post = service('request')->getPost();

        $data = [
            "amazon_link" => $post['amazon_link'],
            "scribd_link" => $post['scribd_link'],
            "googlebooks_link" => $post['google_link'],
            "storytel_link" => $post['storytel_link'],
            "overdrive_link" => $post['overdrive_link'],
            "pinterest_link" => $post['pinterest_link'],
            "pratilipi_link" => $post['pratilipi_link'],
            "audible_link" => $post['audible_link'],
            "odilo_link" => $post['odilo_link']
        ];

        $builder = $this->db->table('author_tbl');
        $builder->where('author_id', $post['author_id']);
        $builder->update($data);

        return 1;
    }
    public function copyrightOwnerDetails($author_id)
    {
        $db = \Config\Database::connect();
        $sql = "SELECT copyright_mapping.copyright_owner, publisher_tbl.publisher_name
                FROM copyright_mapping, publisher_tbl
                WHERE copyright_mapping.copyright_owner = publisher_tbl.copyright_owner
                AND copyright_mapping.author_id = $author_id";

        $query = $db->query($sql);

        return $query->getResultArray();
    }
    public function getauthorPubDetailsDashboard($author_id)
    {
        $db = db_connect();

        $channel_pub_query = "SELECT 
                book_tbl.book_id, 
                book_tbl.book_title, 
                book_tbl.book_category, 
                book_tbl.number_of_page, 
                book_tbl.created_at, 
                book_tbl.status, 
                book_tbl.regional_book_title AS regional_book_title, 
                book_tbl.activated_at AS pub_dt, 
                language_tbl.language_name, 
                book_tbl.download_link, 
                scribd_books.doc_id AS scribd_bk_link, 
                amazon_books.ASIN AS amazon_bk_link, 
                google_books.play_store_link, 
                overdrive_books.sample_link AS overdrive_bk_link,
                storytel_books.isbn AS storytel_isbn
            FROM 
                book_tbl
                LEFT JOIN scribd_books ON book_tbl.book_id = scribd_books.book_id
                LEFT JOIN amazon_books ON book_tbl.book_id = amazon_books.book_id
                LEFT JOIN google_books ON book_tbl.book_id = google_books.book_id
                LEFT JOIN overdrive_books ON book_tbl.book_id = overdrive_books.book_id
                LEFT JOIN storytel_books ON book_tbl.book_id = storytel_books.book_id
                LEFT JOIN language_tbl ON book_tbl.language = language_tbl.language_id
            WHERE 
                book_tbl.author_name = ?
            GROUP BY 
                book_tbl.book_id
            ORDER BY 
                book_tbl.book_id";

        $channel_pub = $db->query($channel_pub_query, [$author_id]);
        return $channel_pub->getResult();
    }
    public function getAuthorDetailsDashboardData($author_id)
    {
        $sql = "SELECT 
                    *,
                    DATE_FORMAT(author_tbl.created_at, '%d %M, %Y') AS formatted_created_at,
                    author_tbl.address AS author_address,
                    author_tbl.agreement_details,
                    author_tbl.copy_right_owner_name,
                    GROUP_CONCAT(DISTINCT publisher_tbl.publisher_name SEPARATOR ', ') AS publisher_names
                FROM 
                    author_tbl, users_tbl, publisher_tbl, copyright_mapping
                WHERE 
                    author_tbl.user_id = users_tbl.user_id
                    AND author_tbl.author_id = copyright_mapping.author_id
                    AND copyright_mapping.copyright_owner = publisher_tbl.copyright_owner
                    AND author_tbl.author_id = $author_id
                GROUP BY 
                    author_tbl.author_id";

        $query = $this->db->query($sql);
        $tmp = $query->getResultArray();
        $result['basic_author_details'] = $tmp[0];

        if ($tmp[0]['password'] == "4732210395731ca375874a1e7c8f62f6") {
            $result['user_password'] = "default";
        } else {
            $result['user_password'] = $tmp[0]['password'];
        }

        $sql = "SELECT 
            COUNT(*) as book_cnt,
            DATE_FORMAT(book_tbl.activated_at, '%m-%y') AS months
        FROM
            author_tbl,
            book_tbl
        WHERE
            book_tbl.author_name = author_tbl.author_id
            AND author_tbl.author_id = $author_id
            AND DATE_FORMAT(book_tbl.activated_at, '%m-%y') IS NOT NULL
        GROUP BY months";

        $query = $this->db->query($sql);
        $tmp = $query->getResultArray();
        $i = 0;
        $author_graph_data['book_graph_data']['total_book_cnt'] = 0;
        foreach ($tmp as $row) {
            $author_graph_data['book_graph_data']['book_cnt'][$i] = $row['book_cnt'];
            $author_graph_data['book_graph_data']['months'][$i] = $row['months'];
            $author_graph_data['book_graph_data']['total_book_cnt'] += $row['book_cnt'];
            $i++;
        }

        $sql = "SELECT 
            SUM(book_tbl.number_of_page) AS number_of_page,
            DATE_FORMAT(book_tbl.activated_at, '%m-%y') AS months
        FROM
            author_tbl,
            book_tbl
        WHERE
            book_tbl.author_name = author_tbl.author_id
            AND author_tbl.author_id = $author_id
            AND DATE_FORMAT(book_tbl.activated_at, '%m-%y') IS NOT NULL
        GROUP BY months";

        $query = $this->db->query($sql);
        $tmp = $query->getResultArray();
        $i = 0;
        $author_graph_data['page_graph_data']['total_page_cnt'] = 0;
        foreach ($tmp as $row) {
            $author_graph_data['page_graph_data']['page_cnt'][$i] = $row['number_of_page'];
            $author_graph_data['page_graph_data']['months'][$i] = $row['months'];
            $author_graph_data['page_graph_data']['total_page_cnt'] += $row['number_of_page'];
            $i++;
        }
        $result['author_graph_data'] = $author_graph_data;

        // Channel Wise Count
        $pustaka_sql = "SELECT
                            COUNT(distinct(book_tbl.book_id)) AS cnt,
                            author_tbl.url_name
                        FROM
                            author_tbl,
                            book_tbl
                        WHERE
                            author_tbl.author_id = book_tbl.author_name
                            AND author_tbl.author_id = $author_id";
        $pustaka_query = $this->db->query($pustaka_sql);
        $pustaka_data = $pustaka_query->getResultArray();
        $channel_wise_cnt['pustaka'] = $pustaka_data[0]['cnt'];

        $amazon_sql = "SELECT
                            COUNT(distinct(amazon_books.book_id)) AS cnt,
                            author_tbl.amazon_link
                        FROM
                            amazon_books,
                            author_tbl,
                            book_tbl
                        WHERE
                            author_tbl.author_id = amazon_books.author_id
                            AND author_tbl.author_id = $author_id
                            AND amazon_books.book_id in (select book_id from book_tbl where status!=0)";
        $amazon_query = $this->db->query($amazon_sql);
        $amazon_data = $amazon_query->getResultArray();
        $channel_wise_cnt['amazon'] = $amazon_data[0]['cnt'];

        $google_sql = "SELECT
                            COUNT(distinct(google_books.book_id)) AS cnt,
                            author_tbl.googlebooks_link
                        FROM
                            google_books,
                            author_tbl
                        WHERE
                            author_tbl.author_id = google_books.author_id
                            AND author_tbl.author_id = $author_id
                            AND google_books.book_id in (select book_id from book_tbl where status!=0)";
        $google_query = $this->db->query($google_sql);
        $google_data = $google_query->getResultArray();
        $channel_wise_cnt['google'] = $google_data[0]['cnt'];

        $overdrive_sql = "SELECT
                            COUNT(distinct(overdrive_books.book_id)) AS cnt,
                            author_tbl.overdrive_link
                        FROM
                            overdrive_books,
                            author_tbl
                        WHERE
                            author_tbl.author_id = overdrive_books.author_id
                            AND author_tbl.author_id = $author_id
                            AND overdrive_books.book_id in (select book_id from book_tbl where status!=0)";
        $overdrive_query = $this->db->query($overdrive_sql);
        $overdrive_data = $overdrive_query->getResultArray();
        $channel_wise_cnt['overdrive'] = $overdrive_data[0]['cnt'];

        $scribd_sql = "SELECT
                            COUNT(distinct(scribd_books.book_id)) AS cnt,
                            author_tbl.scribd_link
                        FROM
                            scribd_books,
                            author_tbl
                        WHERE
                            author_tbl.author_id = scribd_books.author_id
                            AND author_tbl.author_id = $author_id
                            AND scribd_books.book_id in (select book_id from book_tbl where status!=0)";
        $scribd_query = $this->db->query($scribd_sql);
        $scribd_data = $scribd_query->getResultArray();
        $channel_wise_cnt['scribd'] = $scribd_data[0]['cnt'];

        $storytel_sql = "SELECT
                            COUNT(distinct(storytel_books.book_id)) AS cnt,
                            author_tbl.storytel_link
                        FROM
                            storytel_books,
                            author_tbl
                        WHERE
                            author_tbl.author_id = storytel_books.author_id
                            AND author_tbl.author_id = $author_id
                            AND storytel_books.book_id in (select book_id from book_tbl where status!=0)";
        $storytel_query = $this->db->query($storytel_sql);
        $storytel_data = $storytel_query->getResultArray();
        $channel_wise_cnt['storytel'] = $storytel_data[0]['cnt'];

        $pratilipi_sql = "SELECT
                                COUNT(distinct(pratilipi_books.book_id)) AS cnt,
                                author_tbl.pratilipi_link
                            FROM
                                pratilipi_books,
                                author_tbl
                            WHERE
                                author_tbl.author_id = pratilipi_books.author_id
                                AND author_tbl.author_id = $author_id
                                AND pratilipi_books.book_id in (select book_id from book_tbl where status!=0)";
        $pratilipi_query = $this->db->query($pratilipi_sql);
        $pratilipi_data = $pratilipi_query->getResultArray();
        $channel_wise_cnt['pratilipi'] = $pratilipi_data[0]['cnt'];

        $result['channel_wise_cnt'] = $channel_wise_cnt;

        return $result;
    }
     public function getAuthorEbookDetails($author_id)
    {
        // $author_id = $this->db->escape($author_id);

        $sql = "SELECT 
                    COUNT(*) AS ebook_count
                FROM
                    author_tbl
                JOIN
                    book_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE
                    book_tbl.type_of_book = 1
                    AND author_tbl.author_id = $author_id";

        $query = $this->db->query($sql);
        $data['total_count'] = $query->getRowArray();

        $sql1 = "SELECT 
                    COUNT(*) AS ebook_count
                FROM
                    author_tbl
                JOIN
                    book_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE
                    book_tbl.type_of_book = 1
                    AND author_tbl.author_id = $author_id 
                    AND book_tbl.status = 1";

        $query = $this->db->query($sql1);
        $data['active'] = $query->getRowArray();

        $sql2 = "SELECT 
                    COUNT(*) AS ebook_count
                FROM
                    author_tbl
                JOIN
                    book_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE
                    book_tbl.type_of_book = 1
                    AND author_tbl.author_id = $author_id 
                    AND book_tbl.status = 0";

        $query = $this->db->query($sql2);
        $data['inactive'] = $query->getRowArray();

        $sql3 = "SELECT 
                    COUNT(*) AS ebook_count
                FROM
                    author_tbl
                JOIN
                    book_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE
                    book_tbl.type_of_book = 1
                    AND author_tbl.author_id = $author_id 
                    AND book_tbl.status = 2";

        $query = $this->db->query($sql3);
        $data['suspended'] = $query->getRowArray();

        return $data;
    }

    public function getAuthorAudiobkDetails($author_id)
    {
        $author_id = $this->db->escape($author_id);

        $sql = "SELECT 
                    COUNT(*) AS audio_count
                FROM
                    author_tbl
                JOIN
                    book_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE
                    book_tbl.type_of_book = 3
                    AND author_tbl.author_id = $author_id";

        $query = $this->db->query($sql);
        $data['total_count'] = $query->getRowArray();

        $sql1 = "SELECT 
                    COUNT(*) AS audio_count
                FROM
                    author_tbl
                JOIN
                    book_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE
                    book_tbl.type_of_book = 3
                    AND author_tbl.author_id = $author_id 
                    AND book_tbl.status = 1";

        $query = $this->db->query($sql1);
        $data['active'] = $query->getRowArray();

        $sql2 = "SELECT 
                    COUNT(*) AS audio_count
                FROM
                    author_tbl
                JOIN
                    book_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE
                    book_tbl.type_of_book = 3
                    AND author_tbl.author_id = $author_id 
                    AND book_tbl.status = 0";

        $query = $this->db->query($sql2);
        $data['inactive'] = $query->getRowArray();

        $sql3 = "SELECT 
                    COUNT(*) AS audio_count
                FROM
                    author_tbl
                JOIN
                    book_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE
                    book_tbl.type_of_book = 3
                    AND author_tbl.author_id = $author_id 
                    AND book_tbl.status = 2";

        $query = $this->db->query($sql3);
        $data['suspended'] = $query->getRowArray();

        return $data;
    }

    public function getAuthorPaperbackDetails($author_id)
    {
        $author_id = $this->db->escape($author_id);

        $sql = "SELECT 
                    COUNT(*) AS paperback_count
                FROM
                    author_tbl
                JOIN
                    book_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE
                    book_tbl.paper_back_flag = 1
                    AND author_tbl.author_id = $author_id";

        $query = $this->db->query($sql);
        $data['total_counts'] = $query->getRowArray();

        $sql1 = "SELECT 
                    COUNT(*) AS paperback_count
                FROM
                    author_tbl
                JOIN
                    book_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE
                    book_tbl.paper_back_flag = 1
                    AND author_tbl.author_id = $author_id AND book_tbl.status = 1";

        $query = $this->db->query($sql1);
        $data['active'] = $query->getRowArray();

        $sql2 = "SELECT 
                    COUNT(*) AS paperback_count
                FROM
                    author_tbl
                JOIN
                    book_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE
                    book_tbl.paper_back_flag = 1
                    AND author_tbl.author_id = $author_id AND book_tbl.status = 0";

        $query = $this->db->query($sql2);
        $data['inactive'] = $query->getRowArray();

        $sql3 = "SELECT 
                    COUNT(*) AS paperback_count
                FROM
                    author_tbl
                JOIN
                    book_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE
                    book_tbl.paper_back_flag = 1
                    AND author_tbl.author_id = $author_id AND book_tbl.status = 2";

        $query = $this->db->query($sql3);
        $data['suspended'] = $query->getRowArray();

        return $data;
    }
    public function booksTotalCount()
    {
        $uri = service('uri');
        $author_id = $uri->getSegment(3);

        $db = \Config\Database::connect();

        $sql = "SELECT count(*) as ad_cnt FROM audible_books WHERE author_id = $author_id";
        $query = $db->query($sql);
        $data['ad_count'] = $query->getRowArray();

        $sql = "SELECT count(*) as eb_cnt FROM book_tbl WHERE author_name = $author_id";
        $query = $db->query($sql);
        $data['eb_count'] = $query->getRowArray();

        $sql = "SELECT count(*) as pb_cnt FROM book_tbl WHERE paper_back_flag = 1 AND author_name = $author_id";
        $query = $db->query($sql);
        $data['pb_count'] = $query->getRowArray();

        return $data;
    }
    public function authorWiseRoyalty($author_id)
    {
        $db = \Config\Database::connect();
        
        // total royalty revenue
        $total_sql = "SELECT 
                        SUM(revenue) AS total_revenue, 
                        SUM(royalty) AS total_royalty
                      FROM 
                        royalty_consolidation
                      WHERE 
                        author_id = $author_id 
                        AND type IN ('ebook', 'audiobook')";

        $query = $db->query($total_sql);
        $data['details'] = $query->getResultArray();

        // ebook total revenue and royalty
        $ebook_sql = "SELECT 
                        SUM(revenue) AS total_revenue, 
                        SUM(royalty) AS total_royalty
                      FROM 
                        royalty_consolidation
                      WHERE 
                        author_id = $author_id
                        AND pay_status IN ('P', 'O') and type='ebook'";

        $query = $db->query($ebook_sql);
        $data['ebook'] = $query->getResultArray();

        // audiobook total revenue and royalty
        $audiobook_sql = "SELECT 
                            SUM(revenue) AS total_revenue, 
                            SUM(royalty) AS total_royalty
                          FROM 
                            royalty_consolidation
                          WHERE 
                            author_id = $author_id
                            AND pay_status IN ('P', 'O') and type='audiobook'";

        $query = $db->query($audiobook_sql);
        $data['audiobook'] = $query->getResultArray();

        // paperback total revenue and royalty
        $paperback_sql = "SELECT 
                            SUM(revenue) AS total_revenue, 
                            SUM(royalty) AS total_royalty
                          FROM 
                            royalty_consolidation
                          WHERE 
                            author_id = $author_id
                            AND pay_status IN ('P', 'O') and type='paperback'";

        $query = $db->query($paperback_sql);
        $data['paperback'] = $query->getResultArray();

        // ebook detailed by channel
        $ebook_details_sql = "SELECT 
                                fy,
                                sum(revenue) AS full_total_revenue,
                                sum(royalty) AS full_total_royalty,
                                SUM(CASE WHEN channel = 'pustaka' THEN royalty ELSE 0 END) AS total_pustaka_royalty,
                                SUM(CASE WHEN channel = 'amazon' THEN revenue ELSE 0 END) AS total_amazon_revenue,
                                SUM(CASE WHEN channel = 'amazon' THEN royalty ELSE 0 END) AS total_amazon_royalty,
                                SUM(CASE WHEN channel = 'overdrive' THEN revenue ELSE 0 END) AS total_overdrive_revenue,
                                SUM(CASE WHEN channel = 'overdrive' THEN royalty ELSE 0 END) AS total_overdrive_royalty,
                                SUM(CASE WHEN channel = 'scribd' THEN revenue ELSE 0 END) AS total_scribd_revenue,
                                SUM(CASE WHEN channel = 'scribd' THEN royalty ELSE 0 END) AS total_scribd_royalty,
                                SUM(CASE WHEN channel = 'google' THEN revenue ELSE 0 END) AS total_google_revenue,
                                SUM(CASE WHEN channel = 'google' THEN royalty ELSE 0 END) AS total_google_royalty,
                                SUM(CASE WHEN channel = 'storytel' THEN revenue ELSE 0 END) AS total_storytel_revenue,
                                SUM(CASE WHEN channel = 'storytel' THEN royalty ELSE 0 END) AS total_storytel_royalty,
                                SUM(CASE WHEN channel = 'pratilipi' THEN revenue ELSE 0 END) AS total_pratilipi_revenue,
                                SUM(CASE WHEN channel = 'pratilipi' THEN royalty ELSE 0 END) AS total_pratilipi_royalty,
                                SUM(CASE WHEN channel = 'kobo' THEN revenue ELSE 0 END) AS total_kobo_revenue,
                                SUM(CASE WHEN channel = 'kobo' THEN royalty ELSE 0 END) AS total_kobo_royalty
                              FROM 
                                royalty_consolidation
                              WHERE 
                                author_id = $author_id AND type = 'ebook'
                              GROUP BY 
                                fy";

        $query = $db->query($ebook_details_sql);
        $data['ebook_details'] = $query->getResultArray();

        // audiobook detailed by channel
        $audiobook_details_sql = "SELECT 
                                    fy,
                                    sum(revenue) AS full_total_revenue,
                                    sum(royalty) AS full_total_royalty,
                                    SUM(CASE WHEN channel = 'pustaka' THEN royalty ELSE 0 END) AS total_pustaka_royalty,
                                    SUM(CASE WHEN channel = 'overdrive' THEN revenue ELSE 0 END) AS total_overdrive_revenue,
                                    SUM(CASE WHEN channel = 'overdrive' THEN royalty ELSE 0 END) AS total_overdrive_royalty,
                                    SUM(CASE WHEN channel = 'google' THEN revenue ELSE 0 END) AS total_google_revenue,
                                    SUM(CASE WHEN channel = 'google' THEN royalty ELSE 0 END) AS total_google_royalty,
                                    SUM(CASE WHEN channel = 'storytel' THEN revenue ELSE 0 END) AS total_storytel_revenue,
                                    SUM(CASE WHEN channel = 'storytel' THEN royalty ELSE 0 END) AS total_storytel_royalty,
                                    SUM(CASE WHEN channel = 'audible' THEN revenue ELSE 0 END) AS total_audible_revenue,
                                    SUM(CASE WHEN channel = 'audible' THEN royalty ELSE 0 END) AS total_audible_royalty,
                                    SUM(CASE WHEN channel = 'kukufm' THEN revenue ELSE 0 END) AS total_kukufm_revenue,
                                    SUM(CASE WHEN channel = 'kukufm' THEN royalty ELSE 0 END) AS total_kukufm_royalty,
                                    SUM(CASE WHEN channel = 'youtube' THEN revenue ELSE 0 END) AS total_youtube_revenue,
                                    SUM(CASE WHEN channel = 'youtube' THEN royalty ELSE 0 END) AS total_youtube_royalty
                                  FROM 
                                    royalty_consolidation
                                  WHERE 
                                    author_id = $author_id AND type ='audiobook'
                                  GROUP BY 
                                    fy";

        $query = $db->query($audiobook_details_sql);
        $data['audiobook_details'] = $query->getResultArray();

        return $data;
    }
    public function channelWiseChart($author_id)
    {
        $uri = service('uri');
        $db = \Config\Database::connect();

        $pustaka_sql = "SELECT
                            year,
                            month,
                            SUM(revenue) AS pustaka_revenue,
                            SUM(royalty) AS pustaka_royalty
                        FROM 
                            royalty_consolidation 
                        WHERE 
                            channel = 'pustaka' AND author_id = $author_id
                        GROUP BY
                            year, month
                        ORDER BY 
                            year, month";
        $query = $db->query($pustaka_sql);
        $data['pustaka'] = $query->getResultArray();

        $amazon_sql = "SELECT
                            year,
                            month,
                            SUM(revenue) AS amazon_revenue,
                            SUM(royalty) AS amazon_royalty
                        FROM 
                            royalty_consolidation 
                        WHERE 
                            channel = 'amazon' AND author_id = $author_id
                        GROUP BY
                            year, month
                        ORDER BY 
                            year, month";
        $query = $db->query($amazon_sql);
        $data['amazon'] = $query->getResultArray();

        $overdrive_sql = "SELECT
                            year,
                            month,
                            SUM(revenue) AS overdrive_revenue,
                            SUM(royalty) AS overdrive_royalty
                        FROM 
                            royalty_consolidation 
                        WHERE 
                            channel = 'overdrive' AND author_id = $author_id
                        GROUP BY
                            year, month
                        ORDER BY 
                            year, month";
        $query = $db->query($overdrive_sql);
        $data['overdrive'] = $query->getResultArray();

        $scribd_sql = "SELECT
                            year,
                            month,
                            SUM(revenue) AS scribd_revenue,
                            SUM(royalty) AS scribd_royalty
                        FROM 
                            royalty_consolidation 
                        WHERE 
                            channel = 'scribd' AND author_id = $author_id
                        GROUP BY
                            year, month
                        ORDER BY 
                            year, month";
        $query = $db->query($scribd_sql);
        $data['scribd'] = $query->getResultArray();

        $google_sql = "SELECT
                            year,
                            month,
                            SUM(revenue) AS google_revenue,
                            SUM(royalty) AS google_royalty
                        FROM 
                            royalty_consolidation 
                        WHERE 
                            channel = 'google' AND author_id = $author_id
                        GROUP BY
                            year, month
                        ORDER BY 
                            year, month";
        $query = $db->query($google_sql);
        $data['google'] = $query->getResultArray();

        $storytel_sql = "SELECT
                            year,
                            month,
                            SUM(revenue) AS storytel_revenue,
                            SUM(royalty) AS storytel_royalty
                        FROM 
                            royalty_consolidation 
                        WHERE 
                            channel = 'storytel' AND author_id = $author_id
                        GROUP BY
                            year, month
                        ORDER BY 
                            year, month";
        $query = $db->query($storytel_sql);
        $data['storytel'] = $query->getResultArray();

        $pratilipi_sql = "SELECT
                            year,
                            month,
                            SUM(revenue) AS pratilipi_revenue,
                            SUM(royalty) AS pratilipi_royalty
                        FROM 
                            royalty_consolidation 
                        WHERE 
                            channel = 'pratilipi' AND author_id = $author_id
                        GROUP BY
                            year, month
                        ORDER BY 
                            year, month";
        $query = $db->query($pratilipi_sql);
        $data['pratilipi'] = $query->getResultArray();

        $audible_sql = "SELECT
                            year,
                            month,
                            SUM(revenue) AS audible_revenue,
                            SUM(royalty) AS audible_royalty
                        FROM 
                            royalty_consolidation 
                        WHERE 
                            channel = 'audible' AND author_id = $author_id
                        GROUP BY
                            year, month
                        ORDER BY 
                            year, month";
        $query = $db->query($audible_sql);
        $data['audible'] = $query->getResultArray();

        $kobo_sql = "SELECT
                            year,
                            month,
                            SUM(revenue) AS kobo_revenue,
                            SUM(royalty) AS kobo_royalty
                        FROM 
                            royalty_consolidation 
                        WHERE 
                            channel = 'kobo' AND author_id = $author_id
                        GROUP BY
                            year, month
                        ORDER BY 
                            year, month";
        $query = $db->query($kobo_sql);
        $data['kobo'] = $query->getResultArray();

        $kukufm_sql = "SELECT
                            year,
                            month,
                            SUM(revenue) AS kukufm_revenue,
                            SUM(royalty) AS kukufm_royalty
                        FROM 
                            royalty_consolidation 
                        WHERE 
                            channel = 'kukufm' AND author_id = $author_id
                        GROUP BY
                            year, month
                        ORDER BY 
                            year, month";
        $query = $db->query($kukufm_sql);
        $data['kukufm'] = $query->getResultArray();

        $youtube_sql = "SELECT
                            year,
                            month,
                            SUM(revenue) AS youtube_revenue,
                            SUM(royalty) AS youtube_royalty
                        FROM 
                            royalty_consolidation 
                        WHERE 
                            channel = 'youtube' AND author_id = $author_id
                        GROUP BY
                            year, month
                        ORDER BY 
                            year, month";
        $query = $db->query($youtube_sql);
        $data['youtube'] = $query->getResultArray();

        return $data;
    }
    public function authorAmazonDetails($author_id)
    {

        $sql = "SELECT
                    amazon_books.title,
                    amazon_books.asin,
                    amazon_books.ku_activation_date,
                    amazon_books.ku_us_activation_date,
                    amazon_books.ku_uk_activation_date,
                    amazon_books.digital_list_price_inr,
                    amazon_books.digital_list_price_usd
                FROM 
                    amazon_books
                JOIN 
                    author_tbl ON author_tbl.author_id = amazon_books.author_id
                WHERE 
                    author_tbl.author_id = $author_id";

        $query = $this->db->query($sql);
        $data['channel'] = $query->getResultArray();

        $sql1 = "SELECT 
                    COUNT(reference_id) AS total_books,
                    SUM(CASE WHEN ku_enabled = 1 THEN 1 ELSE 0 END) AS total_in_enabled,
                    SUM(CASE WHEN ku_us_enabled = 1 THEN 1 ELSE 0 END) AS total_us_enabled,
                    SUM(CASE WHEN ku_uk_enabled = 1 THEN 1 ELSE 0 END) AS total_uk_enabled
                FROM 
                    amazon_books
                WHERE 
                    author_id = $author_id";

        $query = $this->db->query($sql1);
        $data['count'] = $query->getResultArray();

        return $data;
    }
    public function authorGoogleDetails($author_id)
    {

        $sql = "SELECT 
                    title,
                    publication_date,
                    play_store_link,
                    inr_price_excluding_tax,
                    usd_price_excluding_tax,
                    eur_price_excluding_tax
                FROM 
                    google_books
                WHERE
                    author_id=$author_id";

        $query = $this->db->query($sql);
        $data['google'] = $query->getResultArray();

        $sql1 = "SELECT count(book_id) as total_books FROM pustaka.google_books where author_id=$author_id";
        $query = $this->db->query($sql1);
        $data['count'] = $query->getResultArray();

        return $data;
    }

    public function authorPustakaDetails($author_id)
    {

        $sql = "SELECT 
                    book_tbl.book_title,
                    book_tbl.created_at,
                    book_tbl.url_name,
                    author_tbl.author_id,
                    book_tbl.isbn_number,
                    book_tbl.cost,
                    book_tbl.book_cost_international,
                    book_tbl.type_of_book,
                    book_tbl.paper_back_flag
                FROM 
                    book_tbl
                JOIN
                    author_tbl ON author_tbl.author_id= book_tbl.author_name
                WHERE 
                    author_tbl.author_id= $author_id";

        $query = $this->db->query($sql);
        $data['pustaka'] = $query->getResultArray();

        $sql0 = "SELECT count(book_id) as total_books FROM book_tbl where author_name= $author_id";
        $query = $this->db->query($sql0);
        $data['total'] = $query->getResultArray();

        $sql1 = "SELECT count(book_id) as e_books FROM book_tbl where author_name=$author_id and type_of_book =1";
        $query = $this->db->query($sql1);
        $data['ebook'] = $query->getResultArray();

        $sql2 = "SELECT count(book_id) as audio_books FROM book_tbl where author_name=$author_id and type_of_book =3";
        $query = $this->db->query($sql2);
        $data['audiobook'] = $query->getResultArray();

        $sql3 = "SELECT count(book_id) as paperbacks FROM book_tbl where author_name=$author_id  and paper_back_flag = 1";
        $query = $this->db->query($sql3);
        $data['paperback'] = $query->getResultArray();

        return $data;
    }

    public function authorStorytelsDetails($author_id)
    {
        $sql = "SELECT 
                    storytel_books.title, 
                    storytel_books.publication_date,
                    author_tbl.storytel_link
                FROM 
                    storytel_books
                JOIN 
                    author_tbl ON author_tbl.author_id = storytel_books.author_id
                WHERE 
                    author_tbl.author_id= $author_id";

        $query = $this->db->query($sql);
        $data['storytel_books'] = $query->getResultArray();

        $sql1 = "SELECT count(book_id) as total_books FROM storytel_books where author_id= $author_id";
        $query = $this->db->query($sql1);
        $data['count'] = $query->getResultArray();

        return $data;
    }

    public function authorsOverdriveDetails($author_id)
    {

        $sql = "SELECT 
                    title,
                    whs_usd,
                    sample_link,
                    onsale_date
                FROM 
                    overdrive_books 
                WHERE 
                    author_id=$author_id
                GROUP BY
                    title";

        $query = $this->db->query($sql);
        $data['overdrive_book'] = $query->getResultArray();

        $sql1 = "SELECT count(book_id) as total_books FROM overdrive_books where author_id=$author_id";
        $query = $this->db->query($sql1);
        $data['total_books'] = $query->getResultArray();

        $sql2 = "SELECT count(book_id) as ebook FROM overdrive_books where author_id=$author_id and type_of_book=1";
        $query = $this->db->query($sql2);
        $data['ebook'] = $query->getResultArray();

        $sql3 = "SELECT count(book_id) FROM overdrive_books where author_id=$author_id and type_of_book=3";
        $query = $this->db->query($sql3);
        $data['audiobook'] = $query->getResultArray();

        return $data;
    }

    public function authorsPratilipiDetails($author_id)
    {
        $sql = "SELECT 
                    content_titles,
                    series_url,
                    number_of_parts,
                    uploaded_date
                FROM 
                    pratilipi_books
                WHERE 
                    author_id=$author_id";

        $query = $this->db->query($sql);
        $data['pratilipi_books'] = $query->getResultArray();

        $sql1 = "SELECT count(book_id) as total_books FROM pratilipi_books where author_id=$author_id";
        $query = $this->db->query($sql1);
        $data['total_books'] = $query->getResultArray();

        return $data;
    }

    public function authorScribdDetails($author_id)
    {
        $sql = "SELECT 
                    title,
                    updated_at,
                    author_id,
                    doc_id 
                FROM 
                    scribd_books
                WHERE 
                    author_id=$author_id
                GROUP BY 
                    title";

        $query = $this->db->query($sql);
        $data['scribd_books'] = $query->getResultArray();

        $sql1 = "SELECT count(book_id) as total_books FROM scribd_books where author_id=$author_id";
        $query = $this->db->query($sql1);
        $data['count'] = $query->getResultArray();

        return $data;
    }

}
