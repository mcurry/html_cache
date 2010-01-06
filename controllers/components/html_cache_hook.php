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

class HtmlCacheHookComponent extends Object {
	var $clearActions = array('add', 'edit', 'admin_add', 'admin_edit');
	
	function startup(&$controller) {
		if($controller->data && in_array($controller->action, $this->clearActions)) {
			App::import('core', 'Folder');
			$Folder = new Folder();
			$Folder->delete(WWW_ROOT . 'cache');
		}
	}
}
?>