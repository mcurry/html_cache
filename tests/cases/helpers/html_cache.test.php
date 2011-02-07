<?php
App::import('Helper', array('HtmlCache.HtmlCache'));
App::import('Core', array('View'));

class HtmlCacheTestCase extends CakeTestCase {
	public $View = null;

	public $www_root = null;

	public $html = <<<END
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="en">
<head>
	<title>HtmlCache Test Title</title>
</head>
<body>
	HtmlCache Test Body
</body>
</html>
END;

	public $rss = <<<END
<rss version="2.0">
	   <channel>
			   ...
	   </channel>
</rss>         
END;

	public function startCase() {
		$this->www_root = ROOT . DS . 'app' . DS . 'plugins' . DS . 'html_cache' . DS . 'tests' . DS . 'test_app' . DS . 'webroot' . DS;
		$controller = null;
		$this->View = new View($controller);
		$this->View->loaded['HtmlCache'] = new HtmlCacheHelper(array('test_mode' => true, 'www_root' => $this->www_root));
		$this->View->loaded['HtmlCache']->here = '/posts';
	}

	public function endCase() {
		$Folder = new Folder();
		$Folder->delete($this->www_root . 'cache');
	}

	public function testInstances() {
		$this->assertTrue(is_a($this->View, 'View'));
		$this->assertTrue(is_a(ClassRegistry::getObject('view'), 'View'));
	}

	public function testWriteCache() {
		$this->View->output = $this->html;
		$this->View->_triggerHelpers('afterLayout');

		$path = $this->www_root . 'cache' . DS . 'posts' . DS . 'index.html';
		$this->assertTrue(file_exists($path));
		$cached = file_get_contents($path);
		$this->assertEqual($this->html, $cached);
	}

	public function testWriteHtmlInUrlCache() {
		$this->View->loaded['HtmlCache']->here = '/astatic.html';

		$this->View->_triggerHelpers('afterLayout');
		$rightpath = $this->www_root . 'cache' . DS . 'astatic.html';
		$this->assertTrue(file_exists($rightpath));

		$wrongpath = $this->www_root . 'cache' . DS . 'astatic.html' . DS . 'index.html';
		$this->assertFalse(file_exists($wrongpath));

		$cached = file_get_contents($rightpath);
		$this->assertEqual($this->html, $cached);
	}

	public function testWriteNotHtmlCache() {
		$this->View->output = $this->rss;
		$this->View->loaded['HtmlCache']->here = '/posts.rss';
		$this->View->params['url']['ext'] = 'rss';

		$this->View->_triggerHelpers('afterLayout');

		$path = $this->www_root . 'cache' . DS . 'posts.rss';
		$this->assertTrue(file_exists($path));
		$cached = file_get_contents($path);
		$this->assertEqual($this->rss, $cached);

		$this->View->output = $this->html;
	}
}