<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h6 class="text-center">Activate Author</h6><br><br>
            </div>
        </div>

        <?php 
            // Convert author type numeric value to text
            if ($author['author_details']['author_type'] == 1) {
                $author['author_details']['author_type'] = "Royalty";
            } elseif ($author['author_details']['author_type'] == 2) {
                $author['author_details']['author_type'] = "Magazine";
            } elseif ($author['author_details']['author_type'] == 3) {
                $author['author_details']['author_type'] = "Free Author";
            }

            // Handle regional names
            $author_language = "";
            $author_lang = $author['author_language'] ?? [];
            foreach ($author_lang as $auth_lang) {
                if (!empty($auth_lang['regional_author_name'])) {
                    $author_language .= $auth_lang['regional_author_name'] . ",";
                }
            }
            $author_language = rtrim($author_language, ",");

            // Convert gender abbreviation
            $gender = $author['author_details']['gender'] ?? '';
            if (strtoupper($gender) == 'M') {
                $gender = 'Male';
            } elseif (strtoupper($gender) == 'F') {
                $gender = 'Female';
            } else {
                $gender = 'Not specified';
            }

            // Generate author link
            $pustakaUrl = config('App')->pustaka_url ?? '';
            $authorUrl = $pustakaUrl . "/home/author/" . strtolower($author['author_details']['url_name']);
        ?>

        <div class="row">
            <!-- Personal Details Card -->
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-1 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Personal Details</p><br>
                                <p style="margin-bottom: 0.75rem;">
                                    Author Name : <span style="font-weight:600;"><?= esc($author['author_details']['author_name']); ?></span>
                                </p>
                            </div>
                            <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:account" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>

                        <div class="mt-3">
                            <p style="margin-bottom: 0.75rem;">
                                Gender : <span style="font-weight:600;"><?= esc($gender); ?></span>
                            </p>

                            <p style="margin-bottom: 0.75rem;">
                                Regional Names : <span style="font-weight:600;"><?= esc($author_language); ?></span>
                            </p>

                            <p class="fw-medium mb-1">Author Image :</p>
                            <?php if (!empty($imgSrc)): ?>
                                <img src="<?= esc($imgSrc); ?>" alt="Author Image" style="max-height:150px;" class="img-fluid rounded mb-3">
                            <?php else: ?>
                                <span class="text-warning">No image</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Details Card -->
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-2 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Professional Details</p><br>
                                <p style="margin-bottom: 0.75rem;">
                                    Author Type : <span style="font-weight:600;"><?= esc($author['author_details']['author_type']); ?></span>
                                </p>
                            </div>
                            <div class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="fa-solid:award" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>

                        <div class="mt-3">
                            <p style="margin-bottom: 0.75rem;">
                                Copyright Owner : <span style="font-weight:600;"><?= esc($author['author_details']['copy_right_owner_name']); ?></span>
                            </p>

                            <p style="margin-bottom: 0.75rem;">
                                Description : 
                                <?php if (empty($author['author_details']['description'])): ?>
                                    <span class="text-warning" style="font-weight:600;">Not set</span>
                                <?php else: ?>
                                    <span class="text-success" style="font-weight:600;">Set</span>
                                <?php endif; ?>
                            </p>

                            <p style="margin-bottom: 0.75rem;">
                                Link : 
                                <a target="_blank" href="<?= esc($authorUrl); ?>" class="text-decoration-underline" style="font-weight:600;">
                                    <?= esc($authorUrl); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row">
            <!-- Left Table -->
            <div class="col-md-6">
                <div class="card shadow-none border bg-gradient-start-4 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Author Table</th>
                                        <th>User Table</th>
                                        <th>Publisher Table</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Name</td>
                                        <td><?= esc($author['author_details']['author_name']); ?></td>
                                        <td><?= esc($author['user_details']['username']); ?></td>
                                        <td><?= esc($author['publisher_details']['publisher_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><?= esc($author['author_details']['email']); ?></td>
                                        <td><?= esc($author['user_details']['email']); ?></td>
                                        <td><?= esc($author['publisher_details']['email_id']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Copyright Owner/User ID</td>
                                        <td><?= esc($author['author_details']['copyright_owner']) ?> | <?= esc($author['author_details']['user_id']) ?></td>
                                        <td><?= esc($author['user_details']['user_id']); ?></td>
                                        <td><?= esc($author['publisher_details']['copyright_owner']); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>        
            </div>
            <!-- Right Table -->
            <div class="col-md-6">
                <div class="card shadow-none border bg-gradient-start-5 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">    
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Book Id</th>
                                        <th>Book Title</th>
                                        <th>Copyright Owner</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($author['book_details'] as $book): ?>
                                        <tr>
                                            <td><?= esc($book['book_id']); ?></td>
                                            <td><?= esc($book['book_title']); ?></td>
                                            <td><?= esc($book['copyright_owner']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <div style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-top: 20px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <input type="checkbox" id="send_mail_input" checked
                    style="appearance: auto !important; -webkit-appearance: checkbox !important; width: 18px; height: 18px; cursor: pointer;">
                <label for="send_mail_input" style="margin: 0; cursor: pointer;">Send eMail to Author</label>
            </div>
            <a href=" " onclick="activate_author(<?= (int)$author['author_details']['author_id'] ?>)" class="btn btn-outline-success-600 radius-8" style="padding: 6px 14px; font-size: 14px;">
            ACTIVATE
            </a>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    var base_url = "<?= esc(base_url()); ?>";
    function activate_author(author_id) {
    let send_mail = document.getElementById("send_mail_input").checked;

    $.ajax({
        url: base_url + "author/activateauthor",
        type: "POST",
        dataType: "json",
        data: {
            author_id: author_id,
            send_mail: send_mail
        },
        success: function(data) {
            console.log(data);
            if (data.status == 1) {
                alert("Activated author successfully");
                window.location.href = base_url + "author/manageauthors/royalty/inactive";
            } else {
                alert(data.error ?? "Error occurred. Please try again.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText);
            alert("AJAX error. Please check console/logs.");
        }
    });
}
</script>
<?= $this->endSection(); ?>
