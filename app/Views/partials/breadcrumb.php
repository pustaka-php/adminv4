<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0"><?= $title ?></h6>
    <ul class="d-flex align-items-center gap-2">
        <!-- <li class="fw-medium">
            <a href="<?= route_to('index') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <?php if (isset($subTitle) && $subTitle): ?>
    <li class="fw-medium"><?= esc($subTitle) ?></li>
<?php endif; ?>
    </ul>
</div>