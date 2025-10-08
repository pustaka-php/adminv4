<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h6 class="text-center">Add Royalty Author</h6><br>
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
                                    <span class="text text-xs fw-semibold">Author Details</span>
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
                            <h6 class="text-md text-neutral-500">Author Details</h6>
                            <div class="row">
                                <div class="col-6">
                                    <label>Author State</label>
                                    <div class="radio">
                                        <input type="radio" name="author_state" id="author_state" value="1" checked />
                                        <label>Author</label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="author_state" id="author_state" value="0" />
                                        <label>Author (through publisher)</label>
                                    </div> 
                                    <label>Author Type</label>
                                    <div class="radio">
                                        <input type="radio" name="author_type" id="author_type" value="Royalty" checked />
                                        <label>Royalty</label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="author_type" id="author_type" value="Free" />
                                        <label>Free</label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="author_type" id="author_type" value="Mag/Pub" />
                                        <label>Magazine/Publisher</label>
                                    </div>
                                    <label class="mt-3">Author Name/Pen Name (English)</label>
                                    <input type="text" class="form-control wizard-required" onInput="fill_url_title()" name="author_name" id="author_name"/>
                                    <label class="mt-3">URL String (only hyphens allowed)</label>
                                    <input class="form-control wizard-required" name="author_url" id="author_url"/>                         
                                    <label class="mt-3">Gender</label>
                                    <div class="radio">
                                        <input type="radio" name="author_gender" value="M" checked />
                                        <label>Male</label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="author_gender" value="F" />
                                        <label>Female</label>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label>Regional Author Names</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="mt-1 form-control" placeholder="Tamil First Name" id="tam_fir_name">
                                            <input type="text" class="mt-1 form-control" placeholder="Telugu First Name" id="tel_fir_name">
                                            <input type="text" class="mt-1 form-control" placeholder="Kannada First Name" id="kan_fir_name">
                                            <input type="text" class="mt-1 form-control" placeholder="Malyalam First Name" id="mal_fir_name">
                                            <input type="text" class="mt-1 form-control" placeholder="English First Name" id="eng_fir_name">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="mt-1 form-control" placeholder="Tamil Last Name" id="tam_lst_name">
                                            <input type="text" class="mt-1 form-control" placeholder="Telugu Last Name" id="tel_lst_name">
                                            <input type="text" class="mt-1 form-control" placeholder="Kannada Last Name" id="kan_lst_name">
                                            <input type="text" class="mt-1 form-control" placeholder="Malyalam Last Name" id="mal_lst_name">
                                            <input type="text" class="mt-1 form-control" placeholder="English Last Name" id="eng_lst_name">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex align-items-center justify-content-end gap-8 mt-3">
                                    <button type="button" class="form-wizard-next-btn btn btn-primary-600 px-32">Next</button>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Step 2: Social Media & Description -->
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
                                    <label class="mt-3">Description - English/Regional (for Pustaka)</label>
                                    <textarea rows="4" id="pustaka_author_desc" class="form-control"></textarea>
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-end gap-8 mt-3">
                                    <button type="button" class="form-wizard-previous-btn btn btn-neutral-500 border-neutral-100 px-32">Back</button>
                                    <button type="button" class="form-wizard-next-btn btn btn-primary-600 px-32">Next</button>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Step 3: Contact & Account -->
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

                        <!-- Step 4: Agreement Details -->
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
                                    <a class="btn btn-primary-600 px-32" onclick="add_author()">Submit</a>
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
<script type="text/javascript">
    // ================= Wizard Step JS =================
    $(document).ready(function() {
        $(".form-wizard-next-btn").on("click", function() {
            var parentFieldset = $(this).parents(".wizard-fieldset");
            var currentActiveStep = $(this).parents(".form-wizard").find(".form-wizard-list .active");
            var nextWizardStep = true;

            parentFieldset.find(".wizard-required").each(function(){
                if($(this).val() == "") {
                    $(this).addClass('is-invalid');
                    nextWizardStep = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if(nextWizardStep) {
                parentFieldset.removeClass("show");
                currentActiveStep.removeClass("active").addClass("activated").next().addClass("active");
                parentFieldset.next(".wizard-fieldset").addClass("show");
            }
        });

        $(".form-wizard-previous-btn").on("click", function() {
            var parentFieldset = $(this).parents(".wizard-fieldset");
            var currentActiveStep = $(this).parents(".form-wizard").find(".form-wizard-list .active");
            parentFieldset.removeClass("show");
            parentFieldset.prev(".wizard-fieldset").addClass("show");
            currentActiveStep.removeClass("active").prev().removeClass("activated").addClass("active");
        });
    });

    function fill_url_title() {
        var title = document.getElementById('author_name').value;
        var formatted_title = title.replace(/[^a-z\d\s]+/gi, "").split(' ').join('-').toLowerCase();
        document.getElementById('author_url').value = formatted_title;
    }
</script>
<?= $this->endSection(); ?>
