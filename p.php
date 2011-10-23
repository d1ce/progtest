<?php
error_reporting(E_ALL);

//$programPath = 'C:\Documents and Settings\jakub\Plocha\fit\pa1\test\bin\Debug\test.exe';
$programPath = 'C:\fit\testx\bin\Debug\testx.exe';

$inOutPath = 'C:\fit\testx\bin\Debug\CZE';//'C:\Documents and Settings\jakub\Dokumenty\Stažené soubory\CZE';

$files = array();
foreach(new IteratorIterator(new DirectoryIterator($inOutPath)) as $file)
{
  if((!isset($_GET['f']) || false !== strpos($file->getBasename(), $_GET['f']))
    && $file->isFile())
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

foreach($filesInOut as $f)
{
  test($programPath, $f['in'], $f['out']);
}

function test($programPath, $inPath, $outPath){
$descriptorspec = //array();
 array(
   0 => array("pipe", "w"),  // stdin is a pipe that the child will read from
   1 => array("pipe", "r"),  // stdout is a pipe that the child will write to
   2 => array("pipe", "r") // stderr is a file to write to
);

$cwd = dirname($programPath);
file_put_contents($cwd.'/out.txt', '');
//file_put_contents($cwd.'/in.txt', "888\r\n");
$cmd = "$programPath > $cwd\\out.txt < $inPath";
//echo $cmd.' ';
$e = popen($cmd, 'r');//, $descriptorspec, $pipes, $cwd);//,'C:/',array(),array('bypass_shell'=>true));
fclose($e);

if (true) {
    // $pipes now looks like this:
    // 0 => writeable handle connected to child stdin
    // 1 => readable handle connected to child stdout
    // Any error output will be appended to /tmp/error-output.txt

    $outAct = str_replace("\r\n", "\n", file_get_contents($cwd.'/out.txt'));
    file_put_contents($cwd.'/out/'.basename($outPath).'.act.txt', $outAct);
    $outRef = file_get_contents($outPath);
    $inRef = file_get_contents($inPath);
    
    echo '<h3 style="color:'.(($outAct === $outRef)?'green':'red').'">'
    .basename($inPath).'<h3>';
    if($outAct !== $outRef)
    {
      echo '<b>OUT</b><pre>'.$outAct.'</pre>';
      echo '<b>OUT ref</b><pre>'.$outRef.'</pre>';
      echo '<b>IN ref</b><pre>'.$inRef.'</pre>';
      //echo '<b>err OUT</b><pre>'.stream_get_contents($pipes[2]).'</pre>';
    }
    
    // It is important that you close any pipes before calling
    // proc_close in order to avoid a deadlock
    

    //echo "command returned $return_value\n";
}
}