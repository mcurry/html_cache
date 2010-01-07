<?php
/*
 * HtmlCache Plugin - Hooked for Croogo CMS (http://croogo.org/)
 * Copyright (c) 2009 Matt Curry
 * http://pseudocoder.com
 * http://github.com/mcurry/html_cache
 *
 * @author      mattc <matt@pseudocoder.com>
 * @license     MIT
 *
 */

App::import('Helper', 'HtmlCache.HtmlCacheBase');
class HtmlCacheHookHelper extends HtmlCacheBaseHelper {
  function __isCachable() {
    if($this->params['controller'] != 'nodes' || !empty($this->params['admin'])) {
      return false;
    }
    
    return parent::__isCachable();
  }
}
?>