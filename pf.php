<?php
error_reporting(E_ALL);

//$programPath = 'C:\Documents and Settings\jakub\Plocha\fit\pa1\test\bin\Debug\test.exe';
$programPath = 'C:\fit\testx\bin\Debug\testx.exe';

$inOutPath = 'C:\fit\testx\bin\Debug\CZE';//'C:\Documents and Settings\jakub\Dokumenty\Stažené soubory\CZE';

$files = array();
foreach(new IteratorIterator(new DirectoryIterator($inOutPath)) as $file)
{
  if($file->isFile())
  {
    $files[] = 
      $file->getRealPath();
  }
}

sort($files);

$filesInOut = array();

foreach($files as $i => $f)
{
  if($i % 2)
  {
    $filesInOut[(int) $i/2]['out'] = $f;
  }
  else
  {
    $filesInOut[(int) ($i+1)/2]['in'] = $f;
  }
}

//var_dump($filesInOut,$files);//mixed expression, [mixed expression], [ ...])

$last = '';
$c = -1;
foreach($filesInOut as $f)
{       ++$c;
$last = $f;

  //test($programPath, $f['in'], $f['out']);
}

$c1 = sprintf("%04d", $c);
$c2 = sprintf("%04d", 1+$c);

//echo $c1;exit;
file_put_contents(
  str_replace($c1, $c2, $f['in']),
  file_get_contents($f['in']));
  
file_put_contents(
  str_replace($c1, $c2, $f['out']),
  file_get_contents($f['out']));