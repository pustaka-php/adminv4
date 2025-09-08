<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div id="content" class="main-content">
  <div class="layout-px-spacing">

    <div class="page-header">
      <div class="page-title">
        <h3>Scribd Details</h3>
      </div>
    </div>
    <div class="row mt-5">
        <div class="card col-2 mr-auto ml-5">
            <div class="icon-svg">
                <center><img class="img-fluid mb-1" src="<?php echo base_url();?>assets/img/tamil-logo.jpg"></img>
            </div>
        </div>
        <div class="card col-2 mr-auto">
            <div class="icon-svg">
                <center><img class="img-fluid mb-1" src="<?php echo base_url();?>assets/img/kannada-logo.png"></img>
            </div>
        </div>
        <div class="card col-2 mr-auto">
            <div class="icon-svg">
                <center><img class="img-fluid mb-1" src="<?php echo base_url();?>assets/img/telugu-logo.jpg"></img>
            </div>
        </div>
        <div class="card col-2 mr-auto">
            <div class="icon-svg">
                <center><img class="img-fluid mb-1" src="<?php echo base_url();?>assets/img/malayalam-logo.png"></img>
            </div>
        </div>
        <div class="card col-2 mr-5">
            <div class="icon-svg">
                <center><img class="img-fluid mb-1" src="<?php echo base_url();?>assets/img/english-logo.png"></img>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="card col-2 mr-auto ml-5 bg-success">
            <div class="icon-svg">
                <a href="<?php echo base_url(); ?>adminv3/scribd_published_tamil" target="_blank"><h5> published: <?php echo $scribd['scr_tml_cnt']; ?></h5></a>
            </div>
        </div>
        <div class="card col-2 mr-auto bg-warning">
            <div class="icon-svg">
                <a href="<?php echo base_url(); ?>adminv3/scribd_published_kannada" target="_blank"><h5> published: <?php echo $scribd['scr_kan_cnt']; ?></h5></a>
            </div>
        </div>
        <div class="card col-2 mr-auto bg-warning">
            <div class="icon-svg">
                <a href="<?php echo base_url(); ?>adminv3/scribd_published_telugu" target="_blank"><h5> published: <?php echo $scribd['scr_tel_cnt']; ?></h5></a>
            </div>
        </div>
        <div class="card col-2 mr-auto bg-warning">
            <div class="icon-svg">
                <a href="<?php echo base_url(); ?>adminv3/scribd_published_malayalam" target="_blank"><h5> published: <?php echo $scribd['scr_mlylm_cnt']; ?></h5></a>
            </div>
        </div>
        <div class="card col-2 mr-5 bg-danger">
            <div class="icon-svg">
                <a href="<?php echo base_url(); ?>adminv3/scribd_published_english" target="_blank"><h5> published: <?php echo $scribd['scr_eng_cnt']; ?></h5></a>
            </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="card col-2 mr-auto ml-5 bg-success">
            <div class="icon-svg">
                <a href="<?php echo base_url(); ?>adminv3/scribd_unpublished_tamil" target="_blank"> <h5> un-published: <?php echo $scribd['scr_tml_unpub_cnt']; ?></h5> </a>
            </div>
        </div>
        <div class="card col-2 mr-auto bg-warning">
            <div class="icon-svg">
            <a href="<?php echo base_url(); ?>adminv3/scribd_unpublished_kannada" target="_blank"> <h5> un-published: <?php echo $scribd['scr_kan_unpub_cnt']; ?></h5> </a>
            </div>
        </div>
        <div class="card col-2 mr-auto bg-warning">
            <div class="icon-svg">
            <a href="<?php echo base_url(); ?>adminv3/scribd_unpublished_telugu" target="_blank"> <h5> un-published: <?php echo $scribd['scr_tel_unpub_cnt']; ?></h5> </a>
            </div>
        </div>
        <div class="card col-2 mr-auto bg-warning">
            <div class="icon-svg">
            <a href="<?php echo base_url(); ?>adminv3/scribd_unpublished_malayalam" target="_blank"> <h5> un-published: <?php echo $scribd['scr_mlylm_unpub_cnt']; ?></h5> </a>
            </div>
        </div>
        <div class="card col-2 mr-5 bg-danger">
            <div class="icon-svg">
            <a href="<?php echo base_url(); ?>adminv3/scribd_unpublished_english" target="_blank"> <h5> un-published: <?php echo $scribd['scr_eng_unpub_cnt']; ?></h5> </a>
            </div>
        </div>
    </div> 
    <div class="row mt-5">
    <div class="card col-7 mr-auto ml-5">
        <div class="form-group mb-4">
            <form action="<?php echo base_url(); ?>scribd/scribd_excel/" method="post">
                <label for="exampleFormControlTextarea1">Book IDs seperated by comma:</label>
                <textarea class="form-control" id="book_ids" name="book_ids" rows="3"></textarea>
                <input type="submit" class="ml-3 mt-3 mb-5 btn btn-outline-secondary btn-lg" value="Download Excel">
            </form>
        </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>
