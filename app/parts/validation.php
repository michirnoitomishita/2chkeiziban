<?php if (isset($error_massage)) : ?>
  <ul class="errorMessage">
    <?php foreach ($error_massage as $error) : ?>
      <li><?php echo $error ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>