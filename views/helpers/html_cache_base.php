<?php
/*
 * HtmlCache Plugin
 * Copyright (c) 2009 Matt Curry
 * http://pseudocoder.com
 * http://github.com/mcurry/html_cache
 *
 * @author      mattc <matt@pseudocoder.com>
 * @license     MIT
 *
 */

class HtmlCacheBaseHelper extends Helper {
  var $options = array('test_mode' => false, 'www_root' => WWW_ROOT);
  
  function afterLayout() {
    if(!$this->__isCachable()) {
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
    
    $path = $this->options['www_root'] . 'cache' . $path . DS . 'index.html';
    $file = new File($path, true);
    $file->write($view->output);
  }
  
  function __isCachable() {
    if (!$this->options['test_mode'] && Configure::read('debug') > 0) {
      return false;
    }
    
    return true;
  }
}
?>