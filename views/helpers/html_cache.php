<?php
/*
 * HTML Cache CakePHP Plugin
 * Copyright (c) 2008 Matt Curry
 * www.PseudoCoder.com
 * http://github.com/mcurry/html_cache
 *
 * @author      mattc <matt@pseudocoder.com>
 * @license     MIT
 *
 */

class HtmlCacheHelper extends Helper {
  var $options = array('test_mode' => false, 'www_root' => WWW_ROOT);
  var $path = null;
  
  function __construct($options) {
    $this->options = am ($this->options, $options);
  }
  
  function afterLayout() {
    if (!$this->options['test_mode'] && Configure::read('debug') > 0) {
      return;
    }

    $view =& ClassRegistry::getObject('view');

    //handle 404s
    if ($view->name == 'CakeError') {
      $path = $this->params['url']['url'];
    } else {
      $path = $this->here;
    }

    $path = implode(DS, array_filter(explode('/', $path)));
    if($path !== '') {
      $path = DS . ltrim($path, DS);
    }
    $this->path = $this->options['www_root'] . 'cache' . $path . DS . 'index.html';
    $file = new File($this->path, true);
    $file->write($view->output);
  }
}
?>