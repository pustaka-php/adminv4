<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h6 class="mb-4 text-center">Manage Authors</h6><br>
            </div>
        </div>

        <?php 
            // ✅ Ensure $authors_metadata is always an array
            $authors_metadata = $authors_metadata ?? []; 
        ?>

        <table class="zero-config table table-hover mt-4">
            <thead>
                <th style="width: 180px;">ID</th>
                <th style="width: 150px;">Name</th>
                <th style="width: 150px;">Language</th>
                <th style="width: 150px;">Actions</th>
            </thead>
            <tbody>
                <?php if (!empty($authors_metadata) && !empty($authors_metadata['author_name'])) { ?>
                    <?php for($i = 0; $i < sizeof($authors_metadata['author_name']); $i++) { ?>
                        <tr>
                            <td><?= $authors_metadata['author_id'][$i] ?></td>
                            <td><?= $authors_metadata['author_name'][$i] ?></td>
                            <td><?= $authors_metadata['lang_name'][$i] ?></td>
                            <td>
                                <!-- Details Icon -->
                                <a href="<?= base_url()."author/authordetails/".$authors_metadata['author_id'][$i] ?>" 
                                   class="btn bs-tooltip rounded" title="Details">
                                    <span class="iconify" data-icon="mdi:eye" style="color:#3b82f6; font-size:24px;"></span>
                                </a>

                                <!-- Book Publish Icon -->
                                <a href="<?= base_url()."author/authorpublishdetails/".$authors_metadata['author_id'][$i]."/".$authors_metadata['author_name'][$i] ?>" 
                                   class="btn bs-tooltip rounded" target="_blank" title="Book Publish">
                                    <span class="iconify" data-icon="mdi:book-open-page-variant" style="color:#f59e0b; font-size:24px;"></span>
                                </a>

                                <!-- Edit Icon -->
                                <a href="<?= base_url()."author/editauthor/".$authors_metadata['author_id'][$i] ?>" 
                                   class="btn bs-tooltip rounded" title="Edit">
                                    <span class="iconify" data-icon="mdi:pencil" style="color:#10b981; font-size:24px;"></span>
                                </a>

                                <!-- Activate Author -->
                                <?php if (isset($authors_metadata['status'][$i]) && $authors_metadata['status'][$i] == 0) { ?>
                                    <a href="<?= base_url()."author/activateauthordetails/".$authors_metadata['author_id'][$i] ?>" 
                                       class="btn btn-outline-info" target="_blank">Activate</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4">
                            <center>No Authors Available</center>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    var base_url = "<?= base_url(); ?>";

    function deactivate_author(author_id) {
        $.ajax({
            url: base_url + 'author/deactivateauthor',
            type: 'POST',
            data: { "author_id": author_id },
            success: function(data) {
                if (data == 1) {
                    document.getElementById('text').textContent = "You have deactivated the author successfully.";
                    $('#successmsgpop').modal('show');
                }
            }
        });
    }

    function delete_author(author_id) {
        $.ajax({
            url: base_url + 'author/deleteauthor',
            type: 'POST',
            data: { "author_id": author_id },
            success: function(data) {
                if (data == 1) {
                    document.getElementById('text').textContent = "You have deleted the author successfully.";
                    $('#successmsgpop').modal('show');
                }
            }
        });
    }
</script>

<?= $this->endSection(); ?>
