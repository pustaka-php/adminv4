<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3 class="mb-4">Manage Authors</h3>
            </div>
        </div>
        <table class="zero-config table table-hover mt-4">
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Language</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php if (sizeof($authors_metadata) > 0) { ?>
                    <?php for($i = 0; $i < sizeof($authors_metadata['author_name']); $i++) { ?>
                        <tr>
                            <td style="width: 7%"><?php echo $authors_metadata['author_id'][$i] ?></td>
                            <td style="width: 38%"><?php echo $authors_metadata['author_name'][$i] ?></td>
                            <td><?php echo $authors_metadata['lang_name'][$i] ?></td>
                            <td>
                                <a href="<?php echo base_url()."author/author_details/".$authors_metadata['author_id'][$i] ?>" class="btn  btn-dark bs-tooltip rounded" title="Details">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                                <a href="<?php echo base_url()."author/author_publish_details/".$authors_metadata['author_id'][$i]."/".$authors_metadata['author_name'][$i] ?>" class="btn  btn-dark bs-tooltip rounded" target="_blank" title="Book Publish">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open">
                                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                    </svg>
                                </a>
                                <a href="<?php echo base_url()."author/edit_author/".$authors_metadata['author_id'][$i] ?>" class="btn  btn-dark bs-tooltip rounded" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>

                                <?php if ($authors_metadata['status'][$i] == 0) { ?>
                                    <a href = "<?php echo base_url()."author/activate_author_details/".$authors_metadata['author_id'][$i] ?>" class="btn btn-outline-info" target="_blank">Activate</a>
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
    var base_url = window.location.origin;
    function deactivate_author(author_id) {
        $.ajax ({
            url: base_url + '/adminv3/deactivate_author',
            type: 'POST',
            data: {
                "author_id": author_id
            },
            success: function(data) {
                if (data == 1) {
                    document.getElementById('text').textContent = "You have deactivated the author Successfully";
                    $('#successmsgpop').modal('show');
                }
            }
        });
    }
    function delete_author(author_id) {
        $.ajax ({
            url: base_url + '/adminv3/delete_author',
            type: 'POST',
            data: {
                "author_id": author_id
            },
            success: function(data) {
                if (data == 1) {
                    document.getElementById('text').textContent = "You have deleted the author Successfully";
                    $('#successmsgpop').modal('show');
                }
            }
        });
    }
    
</script>