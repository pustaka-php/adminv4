<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
    function updateTotalQty() {
        let totalQty = 0;
        document.querySelectorAll('input[name^="bk_qty"]').forEach(qtyInput => {
            let qty = parseInt(qtyInput.value) || 0;
            totalQty += qty;
        });
        document.getElementById('total_qty').innerText = totalQty;
    }

    function handleTransportChange(select) {
        const textBox = select.nextElementSibling;
        const hiddenInput = document.getElementById("transport_input");

        if (select.value === "Others") {
            textBox.classList.remove("d-none");
            textBox.value = "";
            hiddenInput.value = "";
            textBox.oninput = () => {
                hiddenInput.value = "Others - " + textBox.value;
            };
        } else {
            textBox.classList.add("d-none");
            textBox.value = "";
            hiddenInput.value = select.value;
        }
    }

    function setAllQuantities() {
        const quantityValue = document.getElementById('defaultQty').value;
        const quantityInputs = document.querySelectorAll('input[name^="bk_qty"]');
        
        quantityInputs.forEach(input => {
            input.value = quantityValue;
        });
        
        updateTotalQty();
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Loaded - Initializing scripts');

        // Handle Transport dropdown
        const transportSelect = document.querySelector('select.form-select');
        if (transportSelect) {
            handleTransportChange(transportSelect);
            transportSelect.addEventListener('change', function() {
                handleTransportChange(this);
            });
        }

        // Update total when user types manually
        document.querySelectorAll('input[name^="bk_qty"]').forEach(qtyInput => {
            qtyInput.addEventListener('input', updateTotalQty);
        });

        // Set All Quantities when text input changes
        const defaultQtyInput = document.getElementById('defaultQty');
        if (defaultQtyInput) {
            defaultQtyInput.addEventListener('input', setAllQuantities);
        }
        
        updateTotalQty();
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div class="card basic-data-table">
    <div class="card-body">
        <h5 class="card-title mb-0">
            <i class="fas fa-book-open-reader me-2"></i>Publisher Selected Books List
        </h5>
        <div class="mb-3 d-flex justify-content-end align-items-center">
            <label for="defaultQty" class="me-2 fw-bold">Set Quantity for All:</label>
            <input type="number" 
                   id="defaultQty" 
                   class="form-control form-control-sm" 
                   style="width: 120px;" 
                   placeholder="Enter Qty"
                   min="0"
                   value="">
        </div>
    </div>

    <div class="card-body">
        <form action="<?= base_url('tppublisherdashboard/tppublisherorderstock') ?>" method="POST">
            <input type="hidden" name="num_of_books" value="<?= count($tppublisher_selected_books_data); ?>">
            <input type="hidden" name="selected_book_list" id="selected_book_list" value="<?= $tppublisher_selected_book_id; ?>">

            <!-- Book Table -->
            <div class="card-body p-4">
                <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="500">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Sku no</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Stock In Hand</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (empty($tppublisher_selected_books_data)) {
                            echo '<tr><td colspan="7" class="text-center text-danger">No books found in selected books data</td></tr>';
                        }
                        
                        foreach ($tppublisher_selected_books_data as $i => $book): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($book['sku_no']) ?></td>
                                <td>
                                    <?= esc($book['book_title']) ?><br>
                                    <small class="text-muted">
                                        Pages: <?= esc($book['number_of_page']) ?> | ISBN: <?= esc($book['isbn']) ?>
                                    </small>
                                </td>
                                <td><?= esc($book['author_name']) ?></td>
                                <td><?= esc($book['stock_in_hand']) ?></td>
                                <td>
                                    <?= esc($book['price']) ?>
                                    <input type="hidden" name="price<?= $i + 1 ?>" value="<?= esc($book['price']) ?>">
                                </td>
                                <td>
                                    <input type="number" 
                                           name="bk_qty<?= $i + 1 ?>" 
                                           class="form-control form-control-sm quantity-input" 
                                           placeholder="0" 
                                           min="0"
                                           value=""
                                           required>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mb-3 text-end">
                <span class="fw-bold fs-6">Total Quantity:</span>
                <span id="total_qty" class="fw-bold fs-6">0</span>
            </div>

            <!-- Rest of your form remains the same -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3" style="max-width: 300px;">
                        <label class="form-label"><i class="fas fa-user me-2"></i>Contact Person</label>
                        <input type="text" name="contact_person" placeholder="Enter contact person name" required
                            class="form-control form-control-sm">
                    </div>
                    <div class="mb-3" style="max-width: 300px;">
                        <label class="form-label"><i class="fas fa-city me-2"></i>City</label>
                        <input type="text" name="city" placeholder="Enter city" required
                            class="form-control form-control-sm">
                    </div>
                    <label class="form-label">
                        <i class="fas fa-map-marker-alt me-2"></i>Shipping Address
                    </label>
                    <textarea name="address" placeholder="Enter full shipping address" required
                        class="form-control form-control-sm" style="height:180px;"></textarea>
                </div>
                <div class="col-md-6">
                    <div class="mb-3" style="max-width: 300px;">
                        <label class="form-label"><i class="fas fa-phone me-2"></i>Mobile Number</label>
                        <input type="tel" name="mobile" placeholder="Enter mobile number" required
                            class="form-control form-control-sm">
                    </div>
                    <div class="mb-3" style="max-width: 300px;">
                        <label class="form-label"><i class="fas fa-calendar-alt me-2"></i>Shipping Date</label>
                        <input type="date" name="ship_date" required class="form-control form-control-sm">
                    </div>
                    <div class="mb-3" style="max-width: 300px;">
                        <label class="form-label"><i class="fas fa-truck me-2"></i>Transport</label>
                        <select class="form-select form-select-sm" onchange="handleTransportChange(this)" required>
                            <option value="">Select Transport</option>
                            <option value="ST Courier">ST COURIER</option>
                            <option value="KPN">KPN</option>
                            <option value="MSS">MSS</option>
                            <option value="Rathimeena">RATHIMEENA</option>
                            <option value="VRL">VRL</option>
                            <option value="Rajangam Roadways">RAJANGAM ROADWAYS</option>
                            <option value="Bus Transport">BUS TRANSPORT</option>
                            <option value="Others">Others</option>
                        </select>
                        <input type="text" class="form-control form-control-sm mt-2 d-none"
                               placeholder="Enter transport name" id="transport_other">
                        <input type="hidden" name="transport" id="transport_input" value="">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="fas fa-comment-dots me-2"></i>Comments</label>
                <textarea name="comments" placeholder="Any comments (optional)" 
                    class="form-control form-control-sm" style="height:120px;"></textarea>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success me-2">
                    <i class="fas fa-arrow-right me-2"></i>Next
                </button>
                <a href="<?= base_url('tppublisherdashboard/tppublisherdashboard') ?>" class="btn btn-danger">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>