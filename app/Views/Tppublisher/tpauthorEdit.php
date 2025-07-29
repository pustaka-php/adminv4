<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="row gy-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-user-edit"></i> Edit Author</h5>
            </div>
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-12">
                        <label class="form-label"><strong><i class="fas fa-building"></i> Publisher</strong></label>
                        <select name="publisher_id" id="publisher_id" class="form-control">
                            <?php if (isset($publisher_details)) {
                                foreach ($publisher_details as $publisher) { ?>
                                    <option value="<?= $publisher['publisher_id'] ?>"
                                        <?= $publisher['publisher_id'] == $authors_data['publisher_id'] ? 'selected' : '' ?>>
                                        <?= $publisher['publisher_name'] ?>
                                    </option>
                            <?php }} ?>
                        </select>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label"><strong><i class="fas fa-user"></i> Author Name</strong></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="f7:person"></iconify-icon>
                            </span>
                            <input type="text" value="<?= $authors_data['author_name'] ?>" class="form-control" id="author_name" name="author_name">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label"><strong><i class="fas fa-phone"></i> Mobile</strong></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="solar:phone-calling-linear"></iconify-icon>
                            </span>
                            <input type="text" value="<?= $authors_data['mobile'] ?>" class="form-control" id="mobile" name="mobile">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label"><strong><i class="fas fa-envelope"></i> Email ID</strong></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mage:email"></iconify-icon>
                            </span>
                            <input type="text" value="<?= $authors_data['email_id'] ?>" class="form-control" id="email_id" name="email_id">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label"><strong><i class="fas fa-align-left"></i> Author Description</strong></label>
                        <textarea name="author_discription" id="author_discription" rows="5" class="form-control"><?= $authors_data['author_discription'] ?></textarea>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label"><strong><i class="fas fa-image"></i> Author Image URL</strong></label>
                        <input type="text" value="<?= $authors_data['author_image'] ?>" class="form-control" id="author_image" name="author_image">
                    </div>
                    
                    <div class="col-12 mt-4 text-center">
                        <button onclick="authors_update()" class="btn btn-success-600 radius-8 px-20 py-11">
                            <i class="fas fa-save"></i> Update
                        </button>

                        <a href="javascript:void(0)" onclick="history.back()" class="btn btn-info-600 radius-8 px-20 py-11">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var base_url = "<?= base_url(); ?>";
    
    function authors_update() {
        event.preventDefault();

        const author_id = <?= $authors_data['author_id']; ?>;
        const publisher_id = $('#publisher_id').val();
        const author_name = $('#author_name').val();
        const mobile = $('#mobile').val();
        const email_id = $('#email_id').val();
        const author_discription = $('#author_discription').val();
        const author_image = $('#author_image').val();

        $.ajax({
            url: base_url + '/tppublisher/editauthorpost',
            type: 'POST',
            data: {
                "author_id": author_id,
                "publisher_id": publisher_id,
                "author_name": author_name,
                "mobile": mobile,
                "email_id": email_id,
                "author_discription": author_discription,
                "author_image": author_image
            },
            success: function(data) {
                if (data != 1) {
                    alert("Author not updated!");
                } else {
                    alert("Author updated successfully!");
                    location.reload();
                }
            },
            error: function() {
                alert("Something went wrong. Try again.");
            }
        });
    }
</script>

<?= $this->endSection(); ?>