<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
    // Display selected Excel file name update
    document.getElementById("excelUpload").addEventListener("change", function() {
        const fileName = this.files.length ? this.files[0].name : "No file selected";
        document.getElementById("fileNameDisplay").innerText = fileName;
    });
</script>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?> 

<div class="row justify-content-center">
    <div class="col-md-10">

        <!-- Page Header -->
        <div class="text-center mb-4">
            <h4 class="fw-bold mb-1">Bulk Order Excel Compare</h4>
            <p class="text-muted">
                Upload your Excel sheet to compare values with existing records.
            </p>
        </div>

        <div class="card shadow-sm radius-16 border-0">
            
            <!-- Card Header -->
            <div class="card-header bg-base border-bottom py-16 px-24">
                <h6 class="fw-semibold mb-0 text-lg">Upload Excel File</h6>
            </div>

            <div class="card-body px-4 py-4">

                <!-- Sample Upload Format Image -->
                <div class="mb-4 text-center">
                    <h6 class="fw-semibold mb-2">Sample Upload File Format</h6>

                    <div class="border radius-12 overflow-hidden d-inline-block shadow-sm">
                        <img src="<?= base_url('assets/images/bulk-order-sample.png') ?>" 
                             alt="Sample Excel Format" 
                             class="img-fluid" 
                             style="max-width: 600px;">
                    </div>

                    <p class="text-muted small mt-2 mb-0">
                        Make sure your Excel file follows this format.
                    </p>
                </div>

                <!-- Error Alert -->
                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger radius-8">
                    <strong>Error:</strong> <?= session()->getFlashdata('error') ?>
                </div>
                <?php endif; ?>

                <!-- Success Alert -->
                <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success radius-8">
                    <strong>Success:</strong> <?= session()->getFlashdata('success') ?>
                </div>
                <?php endif; ?>

                <form action="<?= base_url('orders/processUpload') ?>" method="post" enctype="multipart/form-data">

                    <!-- Drag & Click Upload Area -->
                    <label for="excelUpload" 
                        class="w-100 d-flex flex-column align-items-center justify-content-center 
                               border border-dashed border-2 border-gray-400 radius-16 py-40
                               cursor-pointer bg-hover-light transition">

                        <iconify-icon icon="solar:upload-linear" class="text-4xl text-primary-600 mb-2"></iconify-icon>
                        <h6 class="fw-semibold mb-1">Click to Upload Excel</h6>
                        <p class="text-muted mb-0">Only .xlsx or .xls files are allowed</p>
                    </label>

                    <input 
                        type="file" 
                        name="excel_file" 
                        accept=".xlsx,.xls"
                        class="d-none"
                        id="excelUpload"
                        required
                    >

                    <!-- File Name Display -->
                    <div class="mt-3 px-2">
                        <span id="fileNameDisplay" class="text-muted small">
                            No file selected
                        </span>
                    </div>

                    <button type="submit" 
                        class="btn btn-primary w-100 mt-4 py-2 fw-semibold radius-12">
                        Upload & Compare
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>
