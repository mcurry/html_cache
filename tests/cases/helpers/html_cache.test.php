<?php
App::import('Helper', array('HtmlCache.HtmlCache'));
App::import('Core', array('View'));

class HtmlCacheTestCase extends CakeTestCase {
  var $View = null;
  var $www_root = null;
  
  function startCase() {
    $this->www_root = ROOT . DS . 'app' . DS . 'plugins' . DS . 'html_cache' . DS . 'tests' . DS . 'test_app' . DS . 'webroot' . DS;
    $this->View = new View($controller);
    $this->View->loaded['HtmlCache'] = new HtmlCacheHelper(array('test_mode' => true, 'www_root' => $this->www_root));
    
  }
  
  function endCase() {
    $Folder = new Folder();
    $Folder->delete($this->www_root . 'cache');
  }
  
  function testInstances() {
    $this->assertTrue(is_a($this->View, 'View'));
    $this->assertTrue(is_a(ClassRegistry::getObject('view'), 'View'));
  }
  
  function testWriteCache() {
    $expected = <<<END
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

    $this->View->output = $expected;
    $this->View->_triggerHelpers('afterLayout');
    
    $this->assertTrue(file_exists($this->View->loaded['HtmlCache']->path));
    $cached = file_get_contents($this->View->loaded['HtmlCache']->path);
    $this->assertEqual($expected, $cached);
  }
}