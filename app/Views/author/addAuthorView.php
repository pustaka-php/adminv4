<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title text-center">
                <h6>Add Royalty Author</h6><br>
            </div>
        </div>

        <!-- Wizard Form Start -->
        <div class="card">
            <div class="card-body">
                <div class="form-wizard">
                    <form id="author_form">
                        <div class="form-wizard-header overflow-x-auto scroll-sm pb-8 my-32">
                            <ul class="list-unstyled form-wizard-list style-two">
                                <li class="form-wizard-list__item active">
                                    <div class="form-wizard-list__line"><span class="count">1</span></div>
                                    <span class="text text-xs fw-semibold">Author Details</span><br>
                                </li>
                                <li class="form-wizard-list__item">
                                    <div class="form-wizard-list__line"><span class="count">2</span></div>
                                    <span class="text text-xs fw-semibold">Social Media & Description</span>
                                </li>
                                <li class="form-wizard-list__item">
                                    <div class="form-wizard-list__line"><span class="count">3</span></div>
                                    <span class="text text-xs fw-semibold">Contact & Account</span>
                                </li>
                                <li class="form-wizard-list__item">
                                    <div class="form-wizard-list__line"><span class="count">4</span></div>
                                    <span class="text text-xs fw-semibold">Agreement Details</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Step 1: Author Details -->
                        <fieldset class="wizard-fieldset show">
                            <h6 class="text-md text-neutral-500">Author Details</h6><br>
                            <div class="row">
                                <div class="col-6">
                                    <label>Author Type</label>
                                    <div style="display:flex; flex-wrap:wrap; gap:15px; align-items:center; margin-top:5px;">
                                        <div class="form-check" style="display:flex; align-items:center; gap:5px;">
                                            <input class="form-check-input" type="radio" name="author_type_main" id="author_type_1" value="1" checked>
                                            <label class="form-check-label" for="author_type_1">Author</label>
                                        </div>
                                        <div class="form-check" style="display:flex; align-items:center; gap:5px;">
                                            <input class="form-check-input" type="radio" name="author_type_main" id="author_type_2" value="2">
                                            <label class="form-check-label" for="author_type_2">Free Author</label>
                                        </div>
                                        <div class="form-check" style="display:flex; align-items:center; gap:5px;">
                                            <input class="form-check-input" type="radio" name="author_type_main" id="author_type_3" value="3">
                                            <label class="form-check-label" for="author_type_3">Author Through Publisher</label>
                                        </div>
                                    </div>

                                    <!-- Publisher dropdown -->
                                    <div id="publisher_section" class="mt-3" style="display:none;">
                                        <label for="publisher_id">Select Publisher</label>
                                        <select id="publisher_id" name="publisher_id" class="form-control">
                                            <option value="">-- Select Publisher --</option>
                                            <?php if(isset($publishers)): ?>
                                                <?php foreach ($publishers as $pub): ?>
                                                    <option value="<?= $pub['publisher_id']; ?>"><?= esc($pub['publisher_name']); ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <label class="mt-3">Author Name/Pen Name (English)</label>
                                    <input type="text" class="form-control wizard-required" oninput="fill_url_title()" name="author_name" id="author_name">

                                    <label class="mt-3">URL String (only hyphens allowed)</label>
                                    <input class="form-control wizard-required" name="author_url" id="author_url">

                                    <label class="mt-3">Gender</label>
                                    <div style="display:flex; flex-wrap:wrap; gap:15px; align-items:center; margin-top:5px;">
                                        <div class="form-check" style="display:flex; align-items:center; gap:5px;">
                                            <input class="form-check-input" type="radio" name="author_gender" id="gender_m" value="M" checked>
                                            <label class="form-check-label" for="gender_m">Male</label>
                                        </div>
                                        <div class="form-check" style="display:flex; align-items:center; gap:5px;">
                                            <input class="form-check-input" type="radio" name="author_gender" id="gender_f" value="F">
                                            <label class="form-check-label" for="gender_f">Female</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label>Regional Author Names</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="mt-1 form-control" placeholder="Tamil First Name" id="tam_fir_name">
                                            <input type="text" class="mt-1 form-control" placeholder="Telugu First Name" id="tel_fir_name">
                                            <input type="text" class="mt-1 form-control" placeholder="Kannada First Name" id="kan_fir_name">
                                            <input type="text" class="mt-1 form-control" placeholder="Malayalam First Name" id="mal_fir_name">
                                            <input type="text" class="mt-1 form-control" placeholder="English First Name" id="eng_fir_name">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="mt-1 form-control" placeholder="Tamil Last Name" id="tam_lst_name">
                                            <input type="text" class="mt-1 form-control" placeholder="Telugu Last Name" id="tel_lst_name">
                                            <input type="text" class="mt-1 form-control" placeholder="Kannada Last Name" id="kan_lst_name">
                                            <input type="text" class="mt-1 form-control" placeholder="Malayalam Last Name" id="mal_lst_name">
                                            <input type="text" class="mt-1 form-control" placeholder="English Last Name" id="eng_lst_name">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex align-items-center justify-content-end gap-8 mt-3">
                                    <button type="button" class="form-wizard-next-btn btn btn-primary-600 px-32">Next</button>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Step 2 -->
                        <fieldset class="wizard-fieldset">
                            <h6 class="text-md text-neutral-500">Social Media & Description</h6>
                            <div class="row">
                                <div class="col-12">
                                    <label>Facebook</label>
                                    <input type="url" class="form-control" id="fbook_url">
                                    <label class="mt-3">Twitter</label>
                                    <input type="url" class="form-control" id="twitter_url">
                                    <label class="mt-3">Blog</label>
                                    <input type="url" class="form-control" id="blog_url">
                                    <label class="mt-3">Description (English/Regional)</label>
                                    <textarea rows="4" id="pustaka_author_desc" class="form-control"></textarea>
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-end gap-8 mt-3">
                                    <button type="button" class="form-wizard-previous-btn btn btn-neutral-500 border-neutral-100 px-32">Back</button>
                                    <button type="button" class="form-wizard-next-btn btn btn-primary-600 px-32">Next</button>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Step 3 -->
                        <fieldset class="wizard-fieldset">
                            <h6 class="text-md text-neutral-500">Contact & Account Details</h6>
                            <div class="row">
                                <div class="col-12">
                                    <label>Copyright Owner (if different)</label>
                                    <input type="text" class="form-control" id="copyright_owner">
                                    <label class="mt-3">Relationship</label>
                                    <input type="text" class="form-control" id="relationship">
                                    <label class="mt-3">Mobile Number</label>
                                    <input type="tel" class="form-control" id="mob_no">
                                    <label class="mt-3">Email ID</label>
                                    <input type="email" class="form-control" id="email">
                                    <label class="mt-3">Address</label>
                                    <textarea class="form-control" id="address" rows="2"></textarea>
                                    <h6 class="mt-3">Account Details (Optional)</h6>
                                    <label>PAN Number</label>
                                    <input type="text" class="form-control" id="pan_no">
                                    <label class="mt-3">Account Number</label>
                                    <input type="text" class="form-control" id="acc_no">
                                    <label class="mt-3">IFSC Code</label>
                                    <input type="text" class="form-control" id="ifsc_code">
                                    <label class="mt-3">Bank Name and Branch</label>
                                    <input type="text" class="form-control" id="bank_name">
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-end gap-8 mt-3">
                                    <button type="button" class="form-wizard-previous-btn btn btn-neutral-500 border-neutral-100 px-32">Back</button>
                                    <button type="button" class="form-wizard-next-btn btn btn-primary-600 px-32">Next</button>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Step 4 -->
                        <fieldset class="wizard-fieldset">
                            <h6 class="text-md text-neutral-500">Agreement Details</h6>
                            <div class="row">
                                <div class="col-12">
                                    <label>Agreement Details</label>
                                    <input type="text" class="form-control" id="agreement_details">
                                    <label class="mt-3">Ebook Count</label>
                                    <input type="text" class="form-control" id="agreement_ebook_count">
                                    <label class="mt-3">Audiobook Count</label>
                                    <input type="text" class="form-control" id="agreement_audiobook_count">
                                    <label class="mt-3">Paperback Count</label>
                                    <input type="text" class="form-control" id="agreement_paperback_count">
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-end gap-8 mt-3">
                                    <button type="button" class="form-wizard-previous-btn btn btn-neutral-500 border-neutral-100 px-32">Back</button>
                                    <button type="button" class="btn btn-primary-600 px-32" onclick="add_author()">Submit</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <!-- Wizard Form End -->
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
var base_url = "<?= base_url(); ?>";

$(document).ready(function () {

    // Toggle publisher section
    $('input[name="author_type_main"]').change(function () {
        if ($(this).val() == '3') {
            $('#publisher_section').slideDown();
        } else {
            $('#publisher_section').slideUp();
            $('#publisher_id').val('');
            $('#copyright_owner').val('').prop('readonly', false).css('background', '');
        }
    });

    // Auto-fill copyright owner when publisher selected
    $('#publisher_id').change(function () {
        var publisherId = $(this).val();
        if (publisherId) {
            $.ajax({
                url: base_url + 'author/getpublishercopyrightowner',
                type: 'POST',
                data: { publisher_id: publisherId },
                dataType: 'JSON',
                success: function (res) {
                    if (res.status == 1) {
                        $('#copyright_owner')
                            .val(res.copyright_owner)
                            .prop('readonly', true)
                            .css('background', '#e9ecef');
                    } else {
                        $('#copyright_owner')
                            .val('')
                            .prop('readonly', false)
                            .css('background', '');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching publisher data:', error);
                }
            });
        } else {
            $('#copyright_owner')
                .val('')
                .prop('readonly', false)
                .css('background', '');
        }
    });

    // Form wizard navigation
    $(".form-wizard-next-btn").click(function () {
        var parentFieldset = $(this).parents(".wizard-fieldset");
        var nextStep = true;

        parentFieldset.find(".wizard-required").each(function () {
            if ($(this).val() === "") {
                $(this).addClass('is-invalid');
                nextStep = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (nextStep) {
            parentFieldset.removeClass("show");
            parentFieldset.next(".wizard-fieldset").addClass("show");
            var currentActiveStep = $(".form-wizard-list .active");
            currentActiveStep.removeClass("active").addClass("completed");
            currentActiveStep.next().addClass("active");
            $('html, body').animate({ scrollTop: 0 }, 300);
        }
    });

    $(".form-wizard-previous-btn").click(function () {
        var parentFieldset = $(this).parents(".wizard-fieldset");
        parentFieldset.removeClass("show");
        parentFieldset.prev(".wizard-fieldset").addClass("show");
        var currentActiveStep = $(".form-wizard-list .active");
        currentActiveStep.removeClass("active");
        currentActiveStep.prev().removeClass("completed").addClass("active");
        $('html, body').animate({ scrollTop: 0 }, 300);
    });
});

// Auto-fill URL
function fill_url_title() {
    var title = $('#author_name').val();
    var formatted_title = title.replace(/[^a-z\d\s]+/gi, "").split(' ').join('-').toLowerCase();
    $('#author_url').val(formatted_title);
}
function add_author() {
    var authorUrl = $('#author_url').val();
    var imagePath = '';
    if (authorUrl) {
        imagePath = 'author/' + authorUrl + '.jpg';
    }

    var formData = {
        author_type: $('input[name="author_type_main"]:checked').val(),
        publisher_id: $('#publisher_id').val(),
        author_name: $('#author_name').val(),
        author_url: authorUrl,
        author_gender: $('input[name="author_gender"]:checked').val(),
        email: $('#email').val(),
        mob_no: $('#mob_no').val(),
        address: $('#address').val(),
        pan_no: $('#pan_no').val(),
        acc_no: $('#acc_no').val(),
        ifsc_code: $('#ifsc_code').val(),
        bank_name: $('#bank_name').val(),
        agreement_details: $('#agreement_details').val(),
        agreement_ebook_count: $('#agreement_ebook_count').val(),
        agreement_audiobook_count: $('#agreement_audiobook_count').val(),
        agreement_paperback_count: $('#agreement_paperback_count').val(),
        copyright_owner: $('#copyright_owner').val(),
        relationship: $('#relationship').val(),
        fbook_url: $('#fbook_url').val(),
        twitter_url: $('#twitter_url').val(),
        blog_url: $('#blog_url').val(),
        pustaka_author_desc: $('#pustaka_author_desc').val(),
        tam_fir_name: $('#tam_fir_name').val(),
        tam_lst_name: $('#tam_lst_name').val(),
        tel_fir_name: $('#tel_fir_name').val(),
        tel_lst_name: $('#tel_lst_name').val(),
        kan_fir_name: $('#kan_fir_name').val(),
        kan_lst_name: $('#kan_lst_name').val(),
        mal_fir_name: $('#mal_fir_name').val(),
        mal_lst_name: $('#mal_lst_name').val(),
        eng_fir_name: $('#eng_fir_name').val(),
        eng_lst_name: $('#eng_lst_name').val(),
        author_state: '',
        author_img_url: imagePath 
    };

    $.ajax({
        url: base_url + 'author/addauthorpost',
        type: 'POST',
        data: formData,
        dataType: 'JSON',
        success: function (response) {
            if (response.status == 1) {
                alert("Author added successfully!");
                setTimeout(function() {
                window.location.href = base_url + 'author/authordashboard';
            }, 3000);
            } else if (response.status == 2) {
                alert("Author URL already exists!");
            } else {
                alert("Something went wrong.");
            }
        },
        error: function (xhr, status, error) {
            alert("Server error: " + error);
            console.error("AJAX Error:", error);
        }
    });
}
</script>
<?= $this->endSection(); ?>
