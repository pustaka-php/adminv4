<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Add Copyright Owner</h5>
    </div>

    <div class="card-body">
        <form action="<?= base_url('author/saveauthorcopyrightdetails'); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label">Author ID</label>
                <input type="text" name="author_id" class="form-control" value="<?= esc($author_id); ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Copyright Owner</label>
                <input type="text" name="copyright_owner" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="<?= base_url('author/editauthor/' . $author_id); ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
<?php if (session()->getFlashdata('success')): ?>
<script>
    alert("<?= session()->getFlashdata('success'); ?>");
    setTimeout(function() {
        window.location.href = "<?= base_url('author/editauthor/' . $author_id); ?>";
    }, 3000);
</script>
<?php endif; ?>
<?= $this->endSection(); ?>
