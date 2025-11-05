<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Side Menu Bar -->
        <div class="col-md-3 col-lg-3">
    <div class="card shadow-sm border-0 h-100 bg-transparent">
        <div class="card-header bg-primary py-3 border-0">
            <h6 class="mb-0 fw-semibold">Publishing Plans</h6>
        </div>

        <div class="card-body p-0 bg-transparent mt-2">
            <div class="list-group list-group-flush rounded-0">
                <a href="#pearl" class="list-group-item list-group-item-action d-flex align-items-center border-0 py-2 mb-1" data-bs-toggle="tab" role="tab">
                    <i class="bi bi-diamond me-2 text-info"></i>
                    <span>Pearl Plan</span>
                    <small class="badge bg-danger ms-auto">₹499</small>
                </a>

                <a href="#silver" class="list-group-item list-group-item-action d-flex align-items-center border-0 py-2 mb-1 active bg-primary bg-opacity-25 rounded-3" data-bs-toggle="tab" role="tab">
                    <i class="bi bi-circle me-2 text-secondary"></i>
                    <span>Silver Plan</span>
                    <small class="badge bg-primary ms-auto">₹999</small>
                </a>

                <a href="#silverplus" class="list-group-item list-group-item-action d-flex align-items-center border-0 py-2 mb-1" data-bs-toggle="tab" role="tab">
                    <i class="bi bi-plus-circle me-2 text-success"></i>
                    <span>Silver++ Plan</span>
                    <small class="badge bg-success ms-auto">₹7,999</small>
                </a>

                <a href="#sapphire" class="list-group-item list-group-item-action d-flex align-items-center border-0 py-2 mb-1" data-bs-toggle="tab" role="tab">
                    <i class="bi bi-gem me-2 text-primary"></i>
                    <span>Sapphire Plan</span>
                    <small class="badge bg-primary ms-auto">₹6,999</small>
                </a>

                <a href="#rhodium" class="list-group-item list-group-item-action d-flex align-items-center border-0 py-2 mb-1" data-bs-toggle="tab" role="tab">
                    <i class="bi bi-circle-square me-2 text-info"></i>
                    <span>Rhodium Plan</span>
                    <small class="badge bg-info ms-auto">₹11,999</small>
                </a>

                <a href="#gold" class="list-group-item list-group-item-action d-flex align-items-center border-0 py-2 mb-1" data-bs-toggle="tab" role="tab">
                    <i class="bi bi-star me-2 text-warning"></i>
                    <span>Gold Plan</span>
                    <small class="badge bg-warning ms-auto">₹20,999</small>
                </a>

                <a href="#platinum" class="list-group-item list-group-item-action d-flex align-items-center border-0 py-2" data-bs-toggle="tab" role="tab">
                    <i class="bi bi-award me-2 text-secondary"></i>
                    <span>Platinum Plan</span>
                    <small class="badge bg-secondary ms-auto">₹34,999</small>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Add this script to automatically toggle bg color when switching tabs -->
<script>
document.querySelectorAll('.list-group-item').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelectorAll('.list-group-item').forEach(el => el.classList.remove('bg-primary', 'bg-opacity-25', 'active'));
        this.classList.add('bg-primary', 'bg-opacity-25', 'active');
    });
});
</script>



        <!-- Main Content Area -->
        <div class="col-md-9 col-lg-9">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3">
                    <div class="d-flex align-items-center">
                        <iconify-icon icon="mdi:gift-outline" class="fs-2 me-2"></iconify-icon>  
                        <h6 class="mb-0 fw-semibold">Plans Details</h6>
                    </div>
                </div>

                <div class="card-body p-0">
                    <!-- Tab Content -->
                    <div class="tab-content p-4" id="planTabsContent">
                        
                        <!-- Pearl Plan -->
                        <div class="tab-pane fade" id="pearl" role="tabpanel" aria-labelledby="pearl-tab">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="text-danger mb-0">Pearl Plan</h5>
                                <span class="badge bg-danger fs-6">Rs 499</span>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Service Category</th>
                                            <th>Feature</th>
                                            <th>Status in Pearl Package</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Price & Target</td><td>Launch Offer Price</td><td>Rs 499</td></tr>

                                        <tr><td rowspan="3">Book Production</td><td>eBook</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Word document submission</td><td>Accepted</td></tr>
                                        <tr><td>PDF or Hard Copy submission</td><td><span class="badge bg-warning text-dark">Available as an Add-on</span></td></tr>

                                        <tr><td>Hardcopies</td><td>PDF before Publishing</td><td>Provided</td></tr>

                                        <tr><td rowspan="2">Cover Design</td><td>Standard cover design</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Customised cover design</td><td>2 Designs</td></tr>

                                        <tr><td>Proofreading</td><td>Spell check and grammatical error correction</td><td><span class="badge bg-warning text-dark">Available as an Add-on</span></td></tr>

                                        <tr><td rowspan="2">Ownership & Support</td><td>Royalty payout</td><td>Quarterly</td></tr>
                                        <tr><td>Copyright</td><td>Remains with the author</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Silver Plan -->
                        <div class="tab-pane fade show active" id="silver" role="tabpanel" aria-labelledby="silver-tab">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="text-primary mb-0">Silver Plan</h5>
                                <span class="badge bg-primary fs-6">Rs 999</span>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Service Category</th>
                                            <th>Feature</th>
                                            <th>Status in Silver Package</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Price & Target</td><td>Discounted Price</td><td>Rs 999</td></tr>

                                        <tr><td rowspan="3">Book Production</td><td>E book</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Word document submission</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>PDF or Hard Copy Publishing</td><td><span class="badge bg-warning text-dark">Add-on</span></td></tr>

                                        <tr><td>Proofreading Services</td><td>Spell Check and Grammatical Correction</td><td><span class="badge bg-warning text-dark">Add-ons</span></td></tr>

                                        <tr><td>Cover Design</td><td>Standard Cover Design</td><td><span class="badge bg-success">Included</span></td></tr>

                                        <tr><td rowspan="2">Distribution</td><td>Global eBook Distribution (Pustaka, Amazon, etc.)</td><td><span class="badge bg-success">Included (on 8+ channels)</span></td></tr>
                                        <tr><td>Gift Copies for friends/relatives</td><td>10 Copies</td></tr>

                                        <tr><td rowspan="2">Marketing & Promotions</td><td>Author Profile Page</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Video Teaser with Voiceover</td><td><span class="badge bg-warning text-dark">Add-on</span></td></tr>

                                        <tr><td rowspan="4">Ownership & Support</td><td>Copyright / ISBN / E-Certificate</td><td><span class="badge bg-success">All Included</span></td></tr>
                                        <tr><td>Royalty Payout Frequency</td><td>Quarterly</td></tr>
                                        <tr><td>Dedicated Project Consultant</td><td><span class="badge bg-success">Included (via Email)</span></td></tr>
                                        <tr><td>Author Dashboard</td><td><span class="badge bg-success">Included</span></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Silver++ Plan -->
                        <div class="tab-pane fade" id="silverplus" role="tabpanel" aria-labelledby="silverplus-tab">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="text-success mb-0">Silver++ Plan</h5>
                                <span class="badge bg-success fs-6">Rs 7,999</span>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Service Category</th>
                                            <th>Feature</th>
                                            <th>Status in Silver++ Package</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Pricing & Format</td><td>Launch Offer Price</td><td>Rs 7,999</td></tr>

                                        <tr><td rowspan="6">Book Production</td><td>E Book and Paperback</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Word, PDF, or Hard Copy submission</td><td>Accepted</td></tr>
                                        <tr><td>Page Base Count</td><td>100 Pages</td></tr>
                                        <tr><td>Add-on for extra pages</td><td>Rs 450 for every 10 pages beyond the first 100 pages</td></tr>
                                        <tr><td>Standard cover design</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Customised cover design</td><td>5 Designs</td></tr>

                                        <tr><td>Proofreading</td><td>Spell check and grammatical correction</td><td><span class="badge bg-warning text-dark">Available as an Add-on</span></td></tr>

                                        <tr><td rowspan="4">Hardcopies</td><td>PDF before Publishing</td><td>Provided (2 rounds of corrections permitted)</td></tr>
                                        <tr><td>Number of Copies</td><td>24</td></tr>
                                        <tr><td>Additional Copies (Minimum)</td><td>20</td></tr>
                                        <tr><td>Discount on Additional Copies</td><td>40%</td></tr>

                                        <tr><td>Distribution</td><td>Library Order Application Submission</td><td><span class="badge bg-success">Included</span> (Note: order and sales are not guaranteed)</td></tr>

                                        <tr><td rowspan="3">Ownership & Support</td><td>ISBN</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Royalty Payout</td><td>Quarterly</td></tr>
                                        <tr><td>Copyright</td><td>Remains with the author</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Sapphire Plan -->
                        <div class="tab-pane fade" id="sapphire" role="tabpanel" aria-labelledby="sapphire-tab">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="text-primary mb-0">Sapphire Plan</h5>
                                <span class="badge bg-primary fs-6">Rs 6,999</span>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Service Category</th>
                                            <th>Feature</th>
                                            <th>Status in Sapphire Package</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Pricing & Format</td><td>Launch Offer Price</td><td>Rs 6,999</td></tr>

                                        <tr><td rowspan="4">Book Production</td><td>E Book and Paperback</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Word document submission</td><td>Accepted</td></tr>
                                        <tr><td>PDF or Hard Copy submission</td><td>Accepted</td></tr>
                                        <tr><td>Page Base Count</td><td>150 Pages</td></tr>

                                        <tr><td>Extra Pages</td><td>Add-on for extra pages</td><td>Rs 600 for every 10 pages beyond the first 150 pages</td></tr>

                                        <tr><td rowspan="2">Cover Design</td><td>Standard cover design</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Customised cover design</td><td>5 Designs</td></tr>

                                        <tr><td>Proofreading</td><td>Spell check and grammatical correction</td><td><span class="badge bg-warning text-dark">Add-on</span></td></tr>

                                        <tr><td rowspan="4">Hardcopies</td><td>PDF before Publishing</td><td>Provided (2 rounds of corrections permitted)</td></tr>
                                        <tr><td>Number of Copies</td><td>48</td></tr>
                                        <tr><td>Additional Copies (Minimum)</td><td>20</td></tr>
                                        <tr><td>Discount on Additional Copies</td><td>40%</td></tr>

                                        <tr><td rowspan="3">Ownership & Support</td><td>ISBN</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Royalty Payout</td><td>Quarterly</td></tr>
                                        <tr><td>Copyright</td><td>Remains with the author</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Rhodium Plan -->
                        <div class="tab-pane fade" id="rhodium" role="tabpanel" aria-labelledby="rhodium-tab">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="text-info mb-0">Rhodium Plan</h5>
                                <span class="badge bg-info fs-6">Rs 11,999</span>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Service Category</th>
                                            <th>Feature</th>
                                            <th>Status in Rhodium Package</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Price & Target</td><td>Price</td><td>Rs 11,999</td></tr>

                                        <tr><td rowspan="6">Book Production</td><td>eBook & Audio book</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Audiobook Publishing & Distribution</td><td>Available</td></tr>
                                        <tr><td>Audio Duration Included</td><td>5 Hours</td></tr>
                                        <tr><td>Excess Audio Duration Cost</td><td>Rs 2,000 per extra hour</td></tr>
                                        <tr><td>Word document submission</td><td>Accepted</td></tr>
                                        <tr><td>PDF or Hard Copy Publishing</td><td><span class="badge bg-warning text-dark">Add-on</span></td></tr>

                                        <tr><td>Proofreading Services</td><td>Spell Check and Grammatical Correction</td><td><span class="badge bg-warning text-dark">Add-ons</span></td></tr>

                                        <tr><td>Cover Design</td><td>Standard Cover Design</td><td><span class="badge bg-success">Included</span></td></tr>

                                        <tr><td rowspan="2">Distribution</td><td>Global eBook Distribution (Pustaka, Amazon, etc.)</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Gift Copies for friends/relatives</td><td>10 Copies</td></tr>

                                        <tr><td rowspan="2">Marketing & Promotions</td><td>Author Profile Page</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Video Teaser with Voiceover</td><td><span class="badge bg-warning text-dark">Add-on</span></td></tr>

                                        <tr><td rowspan="4">Ownership & Support</td><td>Copyright / ISBN / E-Certificate</td><td><span class="badge bg-success">All Included</span></td></tr>
                                        <tr><td>Royalty Payout Frequency</td><td>Quarterly</td></tr>
                                        <tr><td>Dedicated Project Consultant</td><td><span class="badge bg-success">Included (via Email)</span></td></tr>
                                        <tr><td>Author Dashboard</td><td><span class="badge bg-success">Included</span></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Gold Plan -->
                        <div class="tab-pane fade" id="gold" role="tabpanel" aria-labelledby="gold-tab">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="text-warning mb-0">Gold Plan</h5>
                                <span class="badge bg-warning fs-6">Rs 20,999</span>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Service Category</th>
                                            <th>Feature</th>
                                            <th>Status in Gold Package</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Price & Target -->
                                        <tr>
                                            <td>Price & Target</td>
                                            <td>Discounted Price</td>
                                            <td><strong>Rs 20,999</strong></td>
                                        </tr>

                                        <!-- Book Production -->
                                        <tr>
                                            <td rowspan="5">Book Production</td>
                                            <td>Paperback and eBook</td>
                                            <td><span class="badge bg-success">Included</span></td>
                                        </tr>
                                        <tr>
                                            <td>Audiobook</td>
                                            <td><span class="badge bg-warning text-dark">Add-on</span></td>
                                        </tr>
                                        <tr>
                                            <td>Book Size / Paper Quality</td>
                                            <td>5x8 inches / 70 GSM</td>
                                        </tr>
                                        <tr>
                                            <td>Printing</td>
                                            <td><span class="badge bg-success">Included</span> (Offset available as Add-on)</td>
                                        </tr>
                                        <tr>
                                            <td>Pages Included</td>
                                            <td>200 (Additional pages are Add-ons)</td>
                                        </tr>

                                        <!-- Content Submission -->
                                        <tr>
                                            <td>Content Submission</td>
                                            <td>Word, PDF, and Hard Copy</td>
                                            <td>All Accepted</td>
                                        </tr>

                                        <!-- Proofreading -->
                                        <tr>
                                            <td>Proofreading Services</td>
                                            <td>Spell Check and Grammatical Correction</td>
                                            <td><span class="badge bg-success">Included</span></td>
                                        </tr>

                                        <!-- Cover Design -->
                                        <tr>
                                            <td rowspan="2">Cover Design</td>
                                            <td>Standard Cover Design</td>
                                            <td><span class="badge bg-success">Included</span></td>
                                        </tr>
                                        <tr>
                                            <td>Customised Cover Design</td>
                                            <td>5 Designs</td>
                                        </tr>

                                        <!-- Distribution -->
                                        <tr>
                                            <td rowspan="7">Distribution</td>
                                            <td>Global eBook Distribution (Pustaka, Amazon, etc.)</td>
                                            <td><span class="badge bg-success">Included</span></td>
                                        </tr>
                                        <tr>
                                            <td>PAN India Paperback Distribution</td>
                                            <td><span class="badge bg-success">Included</span> (Online, Bookshop, Offline)</td>
                                        </tr>
                                        <tr>
                                            <td>Global Paperback Distribution (Ingram)</td>
                                            <td><span class="badge bg-warning text-dark">Add-on</span></td>
                                        </tr>
                                        <tr>
                                            <td>Audiobook Distribution (Pustaka, Kuku FM, Amazon Audible, etc.)</td>
                                            <td><span class="badge bg-success">Included</span></td>
                                        </tr>
                                        <tr>
                                            <td>Inventory Management</td>
                                            <td><span class="badge bg-success">Included</span></td>
                                        </tr>
                                        <tr>
                                            <td>Book Fair and Library Distribution</td>
                                            <td><span class="badge bg-warning text-dark">Add-on</span></td>
                                        </tr>
                                        <tr>
                                            <td>Gift Copies for friends/relatives</td>
                                            <td>20 Copies</td>
                                        </tr>

                                        <!-- Hardcopies -->
                                        <tr>
                                            <td rowspan="3">Hardcopies</td>
                                            <td>Sample Copy before Publishing</td>
                                            <td>PDF</td>
                                        </tr>
                                        <tr>
                                            <td>Number of Hard Copies</td>
                                            <td>48</td>
                                        </tr>
                                        <tr>
                                            <td>Discount on Additional Copies</td>
                                            <td>40% (Min. 20 copies)</td>
                                        </tr>

                                        <!-- Marketing & Promotions -->
                                        <tr>
                                            <td rowspan="6">Marketing & Promotions</td>
                                            <td>Facebook and Instagram Ads</td>
                                            <td>50k Impressions</td>
                                        </tr>
                                        <tr>
                                            <td>YouTube Promotion</td>
                                            <td><span class="badge bg-success">Included</span></td>
                                        </tr>
                                        <tr>
                                            <td>Pustaka Featured Book Promotion</td>
                                            <td>1 Month</td>
                                        </tr>
                                        <tr>
                                            <td>Author Profile Page</td>
                                            <td><span class="badge bg-success">Included</span></td>
                                        </tr>
                                        <tr>
                                            <td>Amazon A+ Listing / Prime / Google Ads</td>
                                            <td><span class="badge bg-warning text-dark">Add-ons</span></td>
                                        </tr>
                                        <tr>
                                            <td>Video Teaser with Voiceover</td>
                                            <td><span class="badge bg-warning text-dark">Add-on</span></td>
                                        </tr>

                                        <!-- Ownership & Support -->
                                        <tr>
                                            <td rowspan="5">Ownership & Support</td>
                                            <td>Copyright / ISBN / E-Certificate</td>
                                            <td><span class="badge bg-success">All Included</span></td>
                                        </tr>
                                        <tr>
                                            <td>Royalty Payout Frequency</td>
                                            <td>Quarterly</td>
                                        </tr>
                                        <tr>
                                            <td>Dedicated Project Consultant</td>
                                            <td><span class="badge bg-success">Included</span></td>
                                        </tr>
                                        <tr>
                                            <td>Author Dashboard</td>
                                            <td><span class="badge bg-success">Included</span></td>
                                        </tr>
                                        <tr>
                                            <td>Post-Publishing Support</td>
                                            <td><span class="badge bg-success">Included</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="alert alert-info mt-3">
                                <strong>Note:</strong> The Gold Plan includes 200 pages. If the limit is exceeded, the Gold Plan overage charge is <strong>Rs. 600</strong> for every 10 pages.
                            </div>
                        </div>

                        <!-- Platinum Plan -->
                        <div class="tab-pane fade" id="platinum" role="tabpanel" aria-labelledby="platinum-tab">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="text-secondary mb-0">Platinum Plan</h5>
                                <span class="badge bg-secondary fs-6">Rs 34,999</span>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Service Category</th>
                                            <th>Feature</th>
                                            <th>Status in Platinum Package</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Price & Target</td><td>Discounted Price</td><td>Rs 34,999</td></tr>

                                        <tr><td rowspan="5">Book Production</td><td>Paperback, eBook, and Audiobook</td><td><span class="badge bg-success">All Included</span></td></tr>
                                        <tr><td>Book Size Customization</td><td>Fully Customisable</td></tr>
                                        <tr><td>Paper Quality</td><td>70 GSM or 80 GSM</td></tr>
                                        <tr><td>Printing</td><td><span class="badge bg-success">Included</span> (Offset available as Add-on)</td></tr>
                                        <tr><td>Pages Included</td><td>200 (Additional pages available)</td></tr>

                                        <tr><td>Content Submission</td><td>Word, PDF, and Hard Copy</td><td>All Accepted</td></tr>

                                        <tr><td>Proofreading Services</td><td>Spell Check and Grammatical Correction</td><td><span class="badge bg-success">Included</span></td></tr>

                                        <tr><td rowspan="2">Cover Design</td><td>Standard Cover Design</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Customised Cover Design</td><td>Unlimited</td></tr>

                                        <tr><td rowspan="6">Distribution</td><td>Global eBook Distribution (Pustaka, Amazon, etc.)</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>PAN India Paperback Distribution</td><td><span class="badge bg-success">Included</span> (Online, Bookshop, Offline, Book Fair, Library)</td></tr>
                                        <tr><td>Global Paperback Distribution (Ingram)</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Audiobook Distribution</td><td><span class="badge bg-success">Included</span> (Pustaka, Amazon Audible, etc.)</td></tr>
                                        <tr><td>Inventory Management</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Gift Copies for friends/relatives</td><td>50 Copies</td></tr>

                                        <tr><td rowspan="3">Hardcopies</td><td>Sample Copy before Publishing</td><td>1 Hardcopy</td></tr>
                                        <tr><td>Number of Hard Copies</td><td>100</td></tr>
                                        <tr><td>Discount on Additional Copies</td><td>50% (Min. 20 copies)</td></tr>

                                        <tr><td rowspan="7">Marketing & Promotions</td><td>Facebook and Instagram Ads</td><td>100k Impressions</td></tr>
                                        <tr><td>Premium Ad Placements</td><td>YouTube, Amazon A+ Listing, Amazon Prime, Amazon Ads, Google Ads <span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Amazon Paid Reviews</td><td>5 Reviews</td></tr>
                                        <tr><td>Foreword, Interview, Influencer Reviews, Video Teaser</td><td><span class="badge bg-success">All Included</span></td></tr>
                                        <tr><td>Author Profile Pages</td><td>Author Profile and Amazon Author Profile <span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Book Launch Event</td><td><span class="badge bg-warning text-dark">Add-on</span></td></tr>
                                        <tr><td>Pustaka Featured Book Promotion</td><td>3 Months</td></tr>

                                        <tr><td rowspan="6">Ownership & Support</td><td>Copyright / ISBN / E-Certificate</td><td><span class="badge bg-success">All Included</span></td></tr>
                                        <tr><td>Government Copyright Registration</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Royalty Payout Frequency</td><td>Quarterly</td></tr>
                                        <tr><td>Dedicated Project Consultant</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Author Dashboard</td><td><span class="badge bg-success">Included</span></td></tr>
                                        <tr><td>Post-Publishing Support</td><td><span class="badge bg-success">Included</span></td></tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="alert alert-info mt-3">
                                <strong>Note:</strong> The Platinum Plan includes 200 pages. If the limit is exceeded, the overage charge for the Platinum Plan is <strong>Rs. 900</strong> for every 10 pages.
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>