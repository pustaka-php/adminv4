<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
    // Add to selected book list (if needed)
    function AddToBookList(book_id) {
        let selectedInput = document.getElementById('selected_book_list');
        let existingList = selectedInput.value;
        let updatedList = existingList ? book_id + ',' + existingList : book_id;
        selectedInput.value = updatedList;
    }

    // Update total quantity display
    function updateTotalQty() {
        let totalQty = 0;
        document.querySelectorAll('input[name^="bk_qty"]').forEach(qtyInput => {
            let qty = parseInt(qtyInput.value) || 0;
            totalQty += qty;
        });
        document.getElementById('total_qty').innerText = totalQty;
    }

    // Handle transport dropdown
    function handleTransportChange(select) {
        const textBox = select.nextElementSibling;       // the textbox for "Others"
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

    document.addEventListener('DOMContentLoaded', function() {
        const select = document.querySelector('select.form-select');
        handleTransportChange(select);

        // Recalculate total on quantity input change
        document.querySelectorAll('input[name^="bk_qty"]').forEach(qtyInput => {
            qtyInput.addEventListener('input', updateTotalQty);
        });
    });
</script>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>

<div class="card basic-data-table">
    <div class="card-body">
        <h5 class="card-title mb-0">
            <i class="fas fa-book-open-reader me-2"></i>Publisher Selected Books List
        </h5>
    </div>

    <div class="card-body">
        <form action="<?= base_url('tppublisherdashboard/tppublisherorderstock') ?>" method="POST">
            <input type="hidden" name="num_of_books" value="<?= count($tppublisher_selected_books_data); ?>">
            <input type="hidden" name="selected_book_list" id="selected_book_list" value="<?= $tppublisher_selected_book_id; ?>">

            <!-- Book Table -->
            <div class="card-body p-4">
                <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="200">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Sku No</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Stock In Hand</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tppublisher_selected_books_data as $i => $book): ?>
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
                                ₹<?= esc($book['price']) ?>
                                <input type="hidden" name="price<?= $i + 1 ?>" value="<?= esc($book['price']) ?>">
                            </td>
                            <td>
                                <input type="number" name="bk_qty<?= $i + 1 ?>" class="form-control form-control-sm" placeholder="0" required>
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

            <!-- Shipping Address -->
            <div class="mb-3" style="max-width: 400px;">
                <label class="form-label"><i class="fas fa-map-marker-alt me-2"></i>Shipping Address</label>
                <textarea name="address" placeholder="Enter full shipping address" required 
                    class="form-control form-control-sm" style="height:180px;"></textarea>
            </div>

            <!-- Mobile -->
            <div class="mb-3" style="max-width: 300px;">
                <label class="form-label"><i class="fas fa-phone me-2"></i>Mobile Number</label>
                <input type="tel" name="mobile" placeholder="Enter mobile number" required class="form-control form-control-sm">
            </div>

            <!-- Shipping Date -->
            <div class="mb-4" style="max-width: 300px;">
                <label class="form-label"><i class="fas fa-calendar-alt me-2"></i>Shipping Date</label>
                <input type="date" name="ship_date" required class="form-control form-control-sm">
            </div>

            <!-- Transport -->
            <div class="mb-4" style="max-width: 300px;">
                <label class="form-label"><i class="fas fa-truck me-2"></i>Transport</label>
                <select class="form-select form-select-sm" onchange="handleTransportChange(this)" required>
                <option value="">Select Transport</option>
                <option value="KPN">KPN</option>
                <option value="MSS">MSS</option>
                <option value="RATHIMEENA">RATHIMEENA</option>
                <option value="VRL">VRL</option>
                <option value="RAJANGAM ROADWAYS">RAJANGAM ROADWAYS</option>
                <option value="BUS TRANSPORT">BUS TRANSPORT</option>
                <option value="Others">Others</option>
            </select>

            <input type="text" class="form-control form-control-sm mt-2 d-none" placeholder="Enter transport name">
            <input type="hidden" name="transport" id="transport_input" value="KPN">

                        </div>

            <!-- Buttons -->
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
