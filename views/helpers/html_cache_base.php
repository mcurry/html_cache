<?php
/*
 * HtmlCache Plugin
 * Copyright (c) 2009 Matt Curry
 * http://pseudocoder.com
 * http://github.com/mcurry/html_cache
 *
 * @author        mattc <matt@pseudocoder.com>
 * @license       MIT
 *
 */

class HtmlCacheBaseHelper extends Helper {

/**
 * options property
 *
 * @var array
 * @access public
 */
	public $options = array(
		'test_mode' => false,
		'www_root' => WWW_ROOT,
		'host' => ''
	);

/**
 * helpers property
 *
 * @var array
 * @access public
 */
	public $helpers = array('Session');

/**
 * path property
 *
 * @var string ''
 * @access public
 */
	public $path = '';

/**
 * isFlash property
 *
 * @var bool false
 * @access public
 */
	public $isFlash = false;

/**
 * beforeRender method
 *
 * @return void
 * @access public
 */
	public function beforeRender() {
		if($this->Session->read('Message')) {
			$this->isFlash = true;
		}
	}

/**
 * afterLayout method
 *
 * @return void
 * @access public
 */
	public function afterLayout() {
		if(!$this->_isCachable()) {
			return;
		}

		$view =& ClassRegistry::getObject('view');

		//handle 404s
		if ($view->name == 'CakeError') {
			$this->path = $this->params['url']['url'];
		} else {
			$this->path = $this->here;
		}

		$this->path = implode(DS, array_filter(explode('/', $this->path)));
		if($this->path !== '') {
			$this->path = DS . ltrim($this->path, DS);
		}

		$host = '';
		if (!empty($_SERVER['HTTP_HOST'])) {
			$host = $_SERVER['HTTP_HOST'] . '/';
		} elseif ($this->options['host']) {
			$host = $this->options['host'] . '/';
		}
		$this->path = $this->options['www_root'] . 'cache' . $host . $this->path . DS . 'index.html';
		$file = new File($this->path, true);
		$file->write($view->output);
	}

/**
 * isCachable method
 *
 * @return void
 * @access protected
 */
	protected function _isCachable() {
		return true;
		if (!$this->options['test_mode'] && Configure::read('debug') > 0) {
			return false;
		}

		if($this->isFlash) {
			return false;
		}

		if(!empty($this->data)) {
			return false;
		}

		return true;
	}
}