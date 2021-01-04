#!/usr/local/bin/php
<?php

require_once __DIR__.'/../vendor/autoload.php'; // Autoload files using Composer autoload

$parser = new \Xmtk\Parser;

function test($xml) {
    global $parser;
    $array = $parser->xmlParseIntoArray($xml);
    print_r($array);
} // function test


test('<tag>1</tag>');

test('<item>
<title>example</title>
</item>');

test('
<root>
  <info>
    <deeper>
      <note>interesting</note>
        <note2>interesting too</note2>
    </deeper>
    <sibling>
      <child>value</child>
    </sibling>
  </info>
</root>');

//it's all right here, parser parses only the 1st root <tag>
test('<tag>1</tag><node>2</node>');

test('
<collection>
    <item>salad</item>
    <item>napkins</item>
    <item>insecticide</item>
</collection>');

test('<users>
  <user>
    <name>Ivan</name>
  </user>
  <user>
    <name>Nikolay</name>
  </user>
</users>');

test('<root>
  <users>
    <user>
      <name>ivan</name>
      <level>1</level>
    </user>
    <user>
      <name>vasya</name>
      <level>2</level>
    </user>
    <admin>
      <name>root</name>
      <level>3</level>
    </admin>
    <user>
      <name>peter</name>
      <level>4</level>
    </user>
  </users>
  <info>
    <note>interesting</note>
  </info>
</root>');

?>
