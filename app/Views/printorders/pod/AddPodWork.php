<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h5 class="text-center">Add New End to End POD</h5>
            </div>
        </div>

        <form id="podForm">
            <?= csrf_field() ?>
            <div class="row">
                <!-- LEFT COLUMN -->
                <div class="col-6">
                    <h6 class="mt-3">Publisher Details</h6>

                    <label class="mt-3">Select Publisher</label>
                    <select name="publisher_id" id="publisher_id" class="form-control">
                        <?php if (isset($publisher_list['publisher'])): ?>
                            <?php foreach ($publisher_list['publisher'] as $pub): ?>
                                <option 
                                    value="<?= esc($pub['id']) ?>"
                                    data-name="<?= esc($pub['publisher_name']) ?>"
                                    data-contact_person="<?= esc($pub['contact_person']) ?>"
                                    data-contact_mobile="<?= esc($pub['contact_mobile']) ?>">
                                    <?= esc($pub['publisher_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <option value="0" data-name="Other">Other</option>
                    </select>

                    <label class="mt-3">Publisher/Customer Name (Optional - only if Other is selected)</label>
                    <input class="form-control" name="custom_publisher_name" id="custom_publisher_name" />

                    <label class="mt-3">Contact Person</label>
                    <input class="form-control" name="publisher_contact" id="publisher_contact" />

                    <label class="mt-3">Contact Mobile</label>
                    <input class="form-control" name="publisher_mobile" id="publisher_mobile" />

                    <h6 class="mt-3">Books Details</h6>

                    <label class="mt-3">Book Title</label>
                    <input class="form-control" name="book_title" id="book_title" />

                    <div class="row">
                        <div class="col-6">
                            <label class="mt-3">Cost per Page</label>
                            <input type="number" class="form-control" name="cost_per_page" id="cost_per_page" />
                        </div>
                        <div class="col-6">
                            <label class="mt-3">Select Language</label>
                            <select name="lang_id" id="lang_id" class="form-control">
                                <?php if (isset($lang_details)): ?>
                                    <?php foreach ($lang_details as $lang): ?>
                                        <option value="<?= esc($lang->language_id) ?>">
                                            <?= esc($lang->language_name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <label class="mt-3">URL Title</label>
                    <input class="form-control" name="url_title" id="url_title" />
                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-6">
                    <h6 class="mt-3">Generic Books Instructions</h6>

                    <label class="mt-3">Request a sample book?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sample_book" value="0" id="sample_yes">
                        <label class="form-check-label" for="sample_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sample_book" value="2" id="sample_no" checked>
                        <label class="form-check-label" for="sample_no">No</label>
                    </div>

                    <label class="mt-3">Layout Description</label>
                    <textarea name="layout_dec" id="layout_dec" rows="5" class="form-control"
                        placeholder="Any specific comments for Layout in general goes here...">Book Size:
Content PaperType:
Binding Type:</textarea>

                    <label class="mt-3">Color Description</label>
                    <textarea name="color_dec" id="color_dec" rows="5" class="form-control"
                        placeholder="Any other comments about the color description goes here...">Content Color:

Inside Picture Color:</textarea>

                    <h6 class="mt-3">Special Instructions</h6>
                    <textarea name="cover_dec" id="cover_dec" rows="7" class="form-control"
                        placeholder="Any specific comments for cover in general goes here...">CoverPaper:
Cover GSM:
Cover Lamination:
ISBN (Barcode):
Price:</textarea>
                </div>
            </div>

            <div class="mt-4 mb-5">
                <button type="button" onclick="add_pod_work()" class="btn btn-outline-success btn-lg">Submit</button>
                <a href="<?= base_url('pod/end_to_end_pod') ?>" class="btn btn-outline-primary btn-lg">Close</a>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const base_url = "<?= site_url() ?>";

    // When publisher is changed, auto fill contact details
    document.getElementById('publisher_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const contact = selectedOption.getAttribute('data-contact_person');
        const mobile = selectedOption.getAttribute('data-contact_mobile');

        document.getElementById('publisher_contact').value = contact ?? '';
        document.getElementById('publisher_mobile').value = mobile ?? '';
    });

    function add_pod_work() {
    const publisher_id = document.getElementById('publisher_id').value;
    const publisher_name = (publisher_id == 0)
        ? document.getElementById('custom_publisher_name').value
        : document.getElementById('publisher_id').options[document.getElementById('publisher_id').selectedIndex].getAttribute('data-name');

    const book_title = document.getElementById('book_title').value.trim();
    const url_title = document.getElementById('url_title').value.trim();

    if (!publisher_name || !book_title || !url_title) {
        Swal.fire('Missing Fields', 'Please fill in all required fields.', 'warning');
        return;
    }

    // dynamic CSRF name/value from CI4
    const csrfName = "<?= csrf_token() ?>";
    const csrfHash = "<?= csrf_hash() ?>";

    // build payload and add CSRF using dynamic key
    const payload = {
        publisher_id: publisher_id,
        publisher_name: publisher_name,
        publisher_contact: $('#publisher_contact').val(),
        publisher_mobile: $('#publisher_mobile').val(),
        book_title: book_title,
        cost_per_page: $('#cost_per_page').val(),
        lang_id: $('#lang_id').val(),
        url_title: url_title,
        sample_book: $('input[name="sample_book"]:checked').val(),
        layout_dec: $('#layout_dec').val(),
        color_dec: $('#color_dec').val(),
        cover_dec: $('#cover_dec').val()
    };
    payload[csrfName] = csrfHash;

   $.ajax({
    url: base_url + '/pod/insertpodwork', 
    type: 'POST',
    dataType: 'json',
    data: payload,
    success: function (data) {
        if (data.status === 1) {
            Swal.fire('Success', 'POD work added successfully!', 'success').then(() => {
                $('#podForm')[0].reset();
            });
        } else {
            Swal.fire('Error', data.message || 'Insert failed', 'error');
        }
    },
    error: function (jqXHR) {
        console.error('Server error:', jqXHR.responseText);
        Swal.fire('Error', 'Server error (500). Check logs.', 'error');
    }
});
    }
</script>

<?= $this->endSection() ?>
