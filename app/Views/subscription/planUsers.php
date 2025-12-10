<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>User Id</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Subscribed On</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($users)): ?>
                <?php $i = 1; foreach ($users as $u): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $u['user_id']; ?></td>
                        <td><?= $u['username']; ?></td>
                        <td><?= $u['email']; ?></td>
                        <td><?= date('d-m-Y', strtotime($u['subscribed_on'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No Users Found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
