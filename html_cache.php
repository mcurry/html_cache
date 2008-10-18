<?php
/*
 * HTML Cache CakePHP Helper
 * Copyright (c) 2008 Matt Curry
 * www.PseudoCoder.com
 * http://www.pseudocoder.com/archives/2008/09/03/cakephp-html-cache-helpercakephp-html-cache-helper/
 *
 * @author      mattc <matt@pseudocoder.com>
 * @version     1.0
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