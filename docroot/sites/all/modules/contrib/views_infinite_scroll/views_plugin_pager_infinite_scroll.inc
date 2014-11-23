<?php

/**
 * The plugin to handle full pager.
 *
 * @ingroup views_pager_plugins
 */
class views_plugin_pager_infinite_scroll extends views_plugin_pager_full {
  function init(&$view, &$display, $options = array()) {
    parent::init($view, $display, $options);
  }

  function option_definition() {
    $options = parent::option_definition();
    $options['manual_load'] = array('default' => 0);
    $options['text'] = array('default' => 'Show More', 'translatable' => TRUE);
    return $options;
  }

  /**
   * Provide the default form for setting options.
   */
  function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);
    $form['manual_load'] = array(
      '#type' => 'checkbox',
      '#title' => t('Load subsequent pages manually instead of automatically'),
      '#description' => t('When checked, use a link to trigger loading of subsequent pages instead of window scroll.'),
      '#default_value' => $this->options['manual_load'],
      '#weight' => -10,
    );

    $form['text'] = array(
      '#type' => 'textfield',
      '#title' => t('Manual load label'),
      '#required' => FALSE,
      '#description' => t('Label to use on the manual link.'),
      '#default_value' => $this->options['text'],
      '#process' => array('ctools_dependent_process'),
      '#dependency' => array(
        'edit-pager-options-manual-load' => array(1),
      ),
      '#weight' => -10,
    );
  }

  function summary_title() {
    return "Infinite Scroll";
    if (!empty($this->options['offset'])) {
      return format_plural($this->options['items_per_page'], 'Infinite scroll pager, @count item, skip @skip', 'Infinite scroll pager, @count items, skip @skip', array(
        '@count' => $this->options['items_per_page'],
        '@skip' => $this->options['offset']
      ));
    }
    return format_plural($this->options['items_per_page'], 'Infinite scroll pager, @count item', 'Infinite scroll pager, @count items', array('@count' => $this->options['items_per_page']));
  }

  function render($input) {
    global $base_url;
    $content_selector = '';
    $style_options = $this->view->style_options;
    $items_selector = '';
    $img_path = $base_url . '/' . drupal_get_path('module', 'views_infinite_scroll') . '/images/ajax-loader.gif';
    switch ($this->view->plugin_name) {
      case 'default':
        $content_selector = 'div.view-content';
        $items_selector = '.views-row';
        break;
      case 'grid':
        $content_selector = 'div.view-content > table > tbody';
        $items_selector = 'tr';
        break;
      case 'list':
        if (array_key_exists('wrapper_class', $style_options) && !empty($style_options['wrapper_class'])) {
          $wrapper_class = '.' . $style_options['wrapper_class'];
        }
        else {
          $wrapper_class = '.item-list';
        }
        $content_selector = 'div.view-content>' . $wrapper_class . ' > *';
        $items_selector = '.views-row';
        break;
      case 'table':
        $content_selector = 'div.view-content > table > tbody';
        $items_selector = 'tr';
        break;
    }
    $pager_theme = views_theme_functions('views_infinite_scroll_pager', $this->view, $this->display);
    return theme($pager_theme, array(
        'tags' => $input,
        'quantity' => $this->options['items_per_page'],
        'view_name' => $this->view->name,
        'current_display' => $this->view->current_display,
        'content_selector' => $content_selector,
        'items_selector' => $items_selector,
        'img_path' => $img_path,
        'element' => $this->options['id'],
        'manual_load' => $this->options['manual_load'],
        'text' => $this->options['text'],
      )
    );
  }
}
