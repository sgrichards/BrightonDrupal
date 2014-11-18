<div<?php print $attributes; ?>>
  <header class="l-header" role="banner">
    <div class="l-constrained">
      <div class="header-1">
        <?php print render($page['header1']); ?>
      </div>
      <div class="header-2">
        <?php print render($page['header2']); ?>
      </div>
      <div class="header-3">
        <?php print render($page['header3']); ?>
      </div>

    </div>
    <div class="l-navigation">
      <div class="l-constrained">
        <?php print render($page['navigation']); ?>
      </div>
    </div>
  </header>

  <?php print render($page['hero']); ?>



  <div class="l-main-wrapper">
    <?php if (!empty($page['highlighted'])): ?>
    <div class="l-highlighted-wrapper">
      <?php print render($page['highlighted']); ?>
    </div>
  <?php endif; ?>
    <div class="l-main l-constrained">
      <a id="main-content"></a>
      <?php print $messages; ?>
      <?php print render($tabs); ?>
      <?php print render($page['help']); ?>

      <div class="l-content" role="main">
        <?php if (!$is_front): ?>
          <?php print render($page['preface']); ?>
          <?php print render($title_prefix); ?>
          <?php if ($title): ?>
            <h1><?php print $title; ?></h1>
          <?php endif; ?>
          <?php print render($title_suffix); ?>
        <?php endif; ?>
        <?php if ($action_links): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul>
        <?php endif; ?>
        <?php print render($page['content']); ?>
        <?php print $feed_icons; ?>
      </div>

      <?php print render($page['sidebar']); ?>
    </div>
  </div>

  <?php if (!empty($page['footer'])): ?>
    <footer class="l-footer-wrapper" role="contentinfo">
      <?php print render($page['footer']); ?>
    </footer>
  <?php endif; ?>
</div>
