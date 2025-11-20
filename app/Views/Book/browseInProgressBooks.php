<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="d-flex justify-content-end align-items-center my-3">
  <a href="<?= base_url('book/getebooksstatus'); ?>" 
           class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
</div>

<div class="row gy-4 mb-24">
    <div class="layout-px-spacing">

        <!-- Normal Books Table -->
        <center><h6>Normal Books</h6></center>
        <table class="table table-hover table-light zero-config">
            <thead class="thead-dark">
                <tr>
          <th width="15%">Title</th>
          <th width="15%">Author</th>
          <th>Priority</th>
          <th class="text-center">Scan</th>
          <th class="text-center">OCR</th>
          <th class="text-center">L1 Proof</th>
          <th class="text-center">L2 Proof</th>
          <th class="text-center">Generation</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($books['normal'] as $book) { ?>
          <tr>
            <td><?php echo $book['book_details']['book_title'] ?></td>
            <td><?php echo $book['book_details']['author_name'] ?></td>
            <td><?php echo $book['book_details']['priority'] ?></td>
            <?php for ($i = 1; $i <= 5; $i++) { ?>
              <td class="text-center">
                <?php //echo $book['stage_details'][$i] ?>
                <?php if ($book['stage_details'][$i] == 1) { ?>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm2 12l-4.5 4.5 1.527 1.5 5.973-6-5.973-6-1.527 1.5 4.5 4.5z"/></svg>
                <?php } else if ($book['stage_details'][$i] == 2) { ?>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                <?php } else { ?>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#FF0101" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6 16.538l-4.592-4.548 4.546-4.587-1.416-1.403-4.545 4.589-4.588-4.543-1.405 1.405 4.593 4.552-4.547 4.592 1.405 1.405 4.555-4.596 4.591 4.55 1.403-1.416z"/></svg>
                <?php } ?>
              </td>
            <?php } ?>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <center><h6 class="mt-4">ReWork Books</h6></center>
    <table class="table zero-config">
      <thead>
        <tr>
          <th>width="15%">Title</th>
          <th>width="15%">Author</th>
          <th>Priority</th>
          <th class="text-center">Scan</th>
          <th class="text-center">OCR</th>
          <th class="text-center">L1 Proof</th>
          <th class="text-center">L2 Proof</th>
          <th class="text-center">Generation</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($books['rework'] as $book) { ?>
          <tr>
            <td><?php echo $book['book_details']['book_title'] ?></td>
            <td><?php echo $book['book_details']['author_name'] ?></td>
            <td><?php echo $book['book_details']['priority'] ?></td>
            <?php for ($i = 1; $i <= 5; $i++) { ?>
              <td class="text-center">
                <?php //echo $book['stage_details'][$i] ?>
                <?php if ($book['stage_details'][$i] == 1) { ?>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm2 12l-4.5 4.5 1.527 1.5 5.973-6-5.973-6-1.527 1.5 4.5 4.5z"/></svg>
                <?php } else if ($book['stage_details'][$i] == 2) { ?>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                <?php } else { ?>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#FF0101" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6 16.538l-4.592-4.548 4.546-4.587-1.416-1.403-4.545 4.589-4.588-4.543-1.405 1.405 4.593 4.552-4.547 4.592 1.405 1.405 4.555-4.596 4.591 4.55 1.403-1.416z"/></svg>
                <?php } ?>
              </td>
            <?php } ?>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="mb-5"></div>
  </div>
</div>
<?= $this->endSection(); ?>