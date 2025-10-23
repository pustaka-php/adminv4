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

        // Inactive authors
        $inactive_query = $db->query("
            SELECT COUNT(*) AS cnt
            FROM author_tbl
            WHERE status = '0' AND author_type = 1
        ");

        // Cancelled authors
        $cancelled_query = $db->query("
            SELECT COUNT(*) AS cnt
            FROM author_tbl
            WHERE status = '2' AND author_type = 1
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
        $result['cancelled_cnt'] = $cancelled_query->getResultArray();

        return $result;
    }

    public function getFreeDashboardData()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT l.language_name, COUNT(*) AS cnt
            FROM author_language al
            JOIN language_tbl l ON al.language_id = l.language_id
            JOIN author_tbl a ON a.author_id = al.author_id
            WHERE a.author_type = 2
            AND a.status = '1'
            GROUP BY al.language_id
        ");

        $inactive_query = $db->query("
            SELECT COUNT(*) AS cnt
            FROM author_tbl
            WHERE status = '0' AND author_type = 2
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
            SELECT l.language_name, COUNT(*) AS cnt
            FROM author_language al
            JOIN language_tbl l ON al.language_id = l.language_id
            JOIN author_tbl a ON a.author_id = al.author_id
            WHERE a.author_type = 3
            GROUP BY al.language_id
        ");

        $inactive_query = $db->query("
            SELECT COUNT(*) AS cnt
            FROM author_tbl
            WHERE status = '0' AND author_type = 3
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
        $channels = ['pustaka', 'amazon', 'google', 'overdrive', 'scribd', 'storytel', 'pratilipi'];
        $channel_sqls = [
            'pustaka' => "SELECT COUNT(distinct(book_tbl.book_id)) AS cnt, author_tbl.url_name
                        FROM author_tbl, book_tbl
                        WHERE author_tbl.author_id = book_tbl.author_name
                            AND author_tbl.author_id = $author_id",
            'amazon' => "SELECT COUNT(distinct(amazon_books.book_id)) AS cnt, author_tbl.amazon_link
                        FROM amazon_books, author_tbl, book_tbl
                        WHERE author_tbl.author_id = amazon_books.author_id
                        AND author_tbl.author_id = $author_id
                        AND amazon_books.book_id in (select book_id from book_tbl where status!=0)",
            'google' => "SELECT COUNT(distinct(google_books.book_id)) AS cnt, author_tbl.googlebooks_link
                        FROM google_books, author_tbl
                        WHERE author_tbl.author_id = google_books.author_id
                        AND author_tbl.author_id = $author_id
                        AND google_books.book_id in (select book_id from book_tbl where status!=0)",
            'overdrive' => "SELECT COUNT(distinct(overdrive_books.book_id)) AS cnt, author_tbl.overdrive_link
                            FROM overdrive_books, author_tbl
                            WHERE author_tbl.author_id = overdrive_books.author_id
                            AND author_tbl.author_id = $author_id
                            AND overdrive_books.book_id in (select book_id from book_tbl where status!=0)",
            'scribd' => "SELECT COUNT(distinct(scribd_books.book_id)) AS cnt, author_tbl.scribd_link
                        FROM scribd_books, author_tbl
                        WHERE author_tbl.author_id = scribd_books.author_id
                        AND author_tbl.author_id = $author_id
                        AND scribd_books.book_id in (select book_id from book_tbl where status!=0)",
            'storytel' => "SELECT COUNT(distinct(storytel_books.book_id)) AS cnt, author_tbl.storytel_link
                        FROM storytel_books, author_tbl
                        WHERE author_tbl.author_id = storytel_books.author_id
                            AND author_tbl.author_id = $author_id
                            AND storytel_books.book_id in (select book_id from book_tbl where status!=0)",
            'pratilipi' => "SELECT COUNT(distinct(pratilipi_books.book_id)) AS cnt, author_tbl.pratilipi_link
                            FROM pratilipi_books, author_tbl
                            WHERE author_tbl.author_id = pratilipi_books.author_id
                            AND author_tbl.author_id = $author_id
                            AND pratilipi_books.book_id in (select book_id from book_tbl where status!=0)"
        ];

        $channel_wise_cnt = [];
        foreach ($channels as $ch) {
            $query = $this->db->query($channel_sqls[$ch]);
            $tmp = $query->getResultArray();
            $channel_wise_cnt[$ch] = $tmp[0]['cnt'];
        }
        $result['channel_wise_cnt'] = $channel_wise_cnt;

        return $result;
    }
    public function editAuthor()
    {
        $uri = service('uri');
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
    public function editAuthorBasicDetails($post)
    {
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


    public function editAuthorAgreementDetails($post)
    {
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


}
