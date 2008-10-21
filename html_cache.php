<?php
/*
 * HTML Cache CakePHP Helper
 * Copyright (c) 2008 Matt Curry
 * www.PseudoCoder.com
 * http://github.com/mcurry/cakephp/tree/master/helpers/html_cache
 *
 * @author      mattc <matt@pseudocoder.com>
 * @license     MIT
 *
 */

class HtmlCacheHelper extends Helper {
  function afterLayout() {
    $view =& ClassRegistry::getObject('view');
    $path = WWW_ROOT . implode(DS, array_filter(explode('/', $this->here)));
    
    $file = new File($path, true);
    $file->write($view->output);
  }
}
?>