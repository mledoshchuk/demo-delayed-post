<?php if ($data) : ?>
    <div class="contnainer">
        <div class="type">Type: <?= $data['type'] ?? '' ?></div>
        <div class="position">Position name: <?= $data['position'] ?? '' ?></div>
        <div class="company_name">Company name: <?= $data['company_name'] ?? '' ?></div>
        <div class="position_description">Position description: <?= $data['position_description'] ?? '' ?></div>
        <div class="salary">Salary: <?= $data['salary'] ?? '' ?></div>
        <div class="starts_at">Starts at: <?= $data['starts_at'] ?? '' ?></div>
        <div class="ends_at">Ends at: <?= $data['ends_at'] ?? '' ?></div>
        <div class="post_at">Post at: <?= $data['post_at'] ?? '' ?></div>
    </div>
<?php endif; ?>