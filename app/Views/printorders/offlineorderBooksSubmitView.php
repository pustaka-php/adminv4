<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
  <div class="layout-px-spacing">

    <div class="page-header">
      <div class="page-title">
        
      
    <html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  </head>
    <style>
      body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      }
        h1 {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 120px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
      }
    </style>
    <body>
      <div class="card">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
      </div>
        <h1>Success</h1> 
        <p>Order Successfully submitted !!!</p>
        <br><br>
        <div class="d-sm-flex justify-content-between">
            <div class="field-wrapper mt-6">
                <button class="btn btn-outline-success mb-4 "><a href="<?php echo base_url()."pustaka_paperback/offline_order_books_dashboard"?>">Order Again</a></button>
                <button class="btn btn-outline-success mb-4 "><a href="<?php echo base_url()."pustaka_paperback/dashboard"?>">Cancel</a></button>
            </div>
        </div>

      </div>
    </body>
    </html>

               
    </div>
  </div>
</div>
<?= $this->endSection(); ?>
