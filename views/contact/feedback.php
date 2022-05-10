<?php if ($data) : ?>
    <div class="contnainer">
        <div class="type">Type: <?= $data['type'] ?? '' ?></div>
        <div class="position">Position name: <?= $data['position'] ?? '' ?></div>
        <div class="company_name">Company name: <?= $data['company_name'] ?? '' ?></div>
        <div class="contact_email">Contact email: <?= $data['contact_email'] ?? '' ?></div>
        <div class="contact_name">Contact name: <?= $data['contact_name'] ?? '' ?></div>
        <div class="post_at">Post at: <?= $data['post_at'] ?? '' ?></div>
    </div>
<?php endif; ?>