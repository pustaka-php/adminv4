<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="layout-px-spacing">
  <div class="page-header">
    <div class="page-title">
      <h6><?= esc($fill_data_info['book_title']); ?> (ID: <?= esc($fill_data_info['book_id']); ?>)</h6>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-lg-8">
      <div class="card p-4 shadow-sm rounded">
        
        <!-- Description -->
        <div class="form-group">
          <label class="font-weight-bold">Description</label>
          <textarea class="form-control" id="description" rows="5"><?= esc($fill_data_info['desc_text']); ?></textarea>
        </div>
        <br>

        <!-- Pages -->
        <div class="form-group">
          <label class="font-weight-bold">Number Of Pages</label>
          <input type="number" oninput="populate_cost()" 
                 value="<?= esc($fill_data_info['num_pages'] ?? '') ?>" 
                 id="num_pages" class="form-control">
        </div>
        <br>

        <!-- Costs -->
        <h6 class="mt-4"> Book Cost</h6>
        <div class="row g-2">
          <div class="col-6">
            <label>Final Cost (INR)</label>
            <div class="input-group">
              <span class="input-group-text">₹</span>
              <input type="text" id="final_cost_inr" class="form-control" placeholder="INR">
            </div>
          </div>
          <div class="col-6">
            <label>Final Cost (USD)</label>
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="text" id="final_cost_usd" class="form-control" placeholder="USD">
            </div>
          </div>
        </div>
        <br>

        <!-- Proof Flags -->
        <h6 class="mt-4">Verification Checks</h6>
        <?php 
          $checks = [
            'proof_flag' => ['label' => '100% Proof Reading Done?', 'color' => 'success'],
            'para_check' => ['label' => 'Paragraph Check', 'color' => 'primary'],
            'quote_check' => ['label' => 'Quotation Mark Check', 'color' => 'warning'],
            'spell_check' => ['label' => 'Spelling Mistake Check', 'color' => 'danger']
          ];
          foreach ($checks as $key => $item): 
            $value = $fill_data_info[$key] ?? '0';
        ?>
          <div class="form-group mt-3">
            <label class="d-block fw-medium mb-2"><?= $item['label'] ?></label>
            <div class="d-flex align-items-center flex-wrap gap-3">
              <div class="form-check checked-<?= $item['color'] ?> d-flex align-items-center gap-2">
                <input class="form-check-input" type="radio" name="<?= $key ?>" 
                       id="<?= $key ?>_yes" value="1" <?= $value == '1' ? 'checked' : '' ?>>
                <label class="form-check-label line-height-1" for="<?= $key ?>_yes">Yes</label>
              </div>
              <div class="form-check checked-<?= $item['color'] ?> d-flex align-items-center gap-2">
                <input class="form-check-input" type="radio" name="<?= $key ?>" 
                       id="<?= $key ?>_no" value="0" <?= $value == '0' ? 'checked' : '' ?>>
                <label class="form-check-label line-height-1" for="<?= $key ?>_no">No</label>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        <br>

        <!-- Extra Notes -->
        <div class="form-group mt-3">
          <label class="font-weight-bold">Remarks / Notes</label>
          <textarea class="form-control" id="extra_notes" rows="4"><?= esc($fill_data_info['extra_notes'] ?? '') ?></textarea>
        </div>
        <br>

        <!-- Button -->
        <div class="mt-4 text-end">
          <button onclick="fill_data()" class="btn rounded-pill btn-primary-100 text-primary-600 radius-8 px-20 py-11">
            <i class="fas fa-save"></i> Save Data
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>


<?= $this->section('script'); ?>
<script type="text/javascript">
  base_url = window.location.origin;
  populate_cost();

  function fill_data() {
    let data = {
      "description": $('#description').val(),
      "num_pages": $('#num_pages').val(),
      "final_cost_inr": $('#final_cost_inr').val(),
      "final_cost_usd": $('#final_cost_usd').val(),
      "proof_flag": $('input[name="proof_flag"]:checked').val(),
      "para_check": $('input[name="para_check"]:checked').val(),
      "quote_check": $('input[name="quote_check"]:checked').val(),
      "spell_check": $('input[name="spell_check"]:checked').val(),
      "extra_notes": $('#extra_notes').val(),
      "id": <?= $book_id ?>
    };

    $.post(base_url + '/book/filldata', data, function(res) {
      if (res.status == 1) {
        alert("✅ Filled Data Successfully!");
      } else {
        alert("⚠️ Update failed. Try again!");
      }
    }, 'json');
  }

  function populate_cost() {
    let num_pages = $('#num_pages').val();
    let inr = 0, usd = 0;

    if (num_pages < 20) { inr = 10; usd = 0.99; }
    else if (num_pages < 74) { inr = 49; usd = 1.99; }
    else if (num_pages < 149) { inr = 99; usd = 3.49; }
    else if (num_pages < 249) { inr = 174; usd = 4.99; }
    else if (num_pages < 399) { inr = 249; usd = 6.24; }
    else if (num_pages < 499) { inr = 324; usd = 7.49; }
    else if (num_pages < 599) { inr = 399; usd = 8.74; }
    else if (num_pages < 699) { inr = 474; usd = 9.99; }
    else if (num_pages < 799) { inr = 549; usd = 11.24; }
    else if (num_pages < 899) { inr = 624; usd = 12.49; }
    else if (num_pages < 999) { inr = 699; usd = 13.74; }
    else { inr = 774; usd = 14.99; }

    $('#final_cost_inr').val(inr);
    $('#final_cost_usd').val(usd);
  }
</script>
<?= $this->endSection(); ?>