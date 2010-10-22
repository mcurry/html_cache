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

App::import('Helper', 'HtmlCache.HtmlCacheBase');
class HtmlCacheHelper extends HtmlCacheBaseHelper {
  function __construct($options) {
    $this->options = array_merge($this->options, $options);
  }
}
?>