<div class="threadWrapper">
  <div class="childWrapper">
    <div class="threadTitle">
      <span>【タイトル】</span>
      <h1>今日のおすすめ材料など</h1>
    </div>
    <section>
      <?php foreach ($result as $record) : ?>
        <article>
          <div class="wrapper">
            <div class="nameAria">
              <span>[名前]</span>
              <p class="username"><?= htmlspecialchars($record['username']) ?></p>
              <time>:<?= $record['post_date'] ?></time>
            </div>
            <p class="comment"><?= htmlspecialchars($record['body']) ?></p>
          </div>
        </article>
      <?php endforeach; ?>

    </section>
    <form class="formWrapper" method="POST">
      <div class="inputArea">
        <input type="submit" value="書き込む" name="submitButton">
        <label>名前：
        </label>
        <input type="text" name="username">
      </div>
      <div>
        <textarea class="commentTextArea" name="body"></textarea>
      </div>
    </form>
  </div>
</div>