<?php
// ini_set(error_reporting,E_ALL);
// ini_set("display_errors",1);
print "Hello Demo Heoku!!!";

// print $request_body = file_get_contents('php://input');
// $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
// $txt = "John Doe\n";
// fwrite($myfile, $request_body);
// fclose($myfile);


function get_function_body($sourceFile, $functionName) {
    $fd = fopen($sourceFile, "r");
    while (!feof($fd)) {
        $content = fgets($fd);
        if ($content == "") { 
            continue;
        }
        if (isset($ret['args'])) {
            if ($content == "//EOF")
            break;
            if (preg_match('/^\s*function\s+/', $content)) {
                // EOFunction?
                break;
            }
            $ret['body'] .= $content;
            continue;
        }
        if (preg_match('/^\s*function\s+(.*)\s*\((.*)\)\s*\{\s*$/', $content, $resx)) {
            if ($resx[1] == $functionName) {
                $ret['args'] = $resx[2];
                $ret['body'] = "";
            }
        }
    }
    fclose($fd);
    return $ret;
}

// $arr = get_defined_functions();
// print "<pre>";
// print_r($arr);

$func = new ReflectionFunction('get_function_body');
$filename = $func->getFileName();
$start_line = $func->getStartLine() - 1; // it's actually - 1, otherwise you wont get the function() block
$end_line = $func->getEndLine();
$length = $end_line - $start_line;

$source = file($filename);
$body = implode("", array_slice($source, $start_line, $length));
//print "<pre>";
var_dump($body);
var_dump($string);


$fragments = preg_split('/([\{\}])/', (string)$body,0,PREG_SPLIT_DELIM_CAPTURE);
//print_r($fragments);
$functions = array();
$currentfunctionbody = '';
$currentnesting = 0;
$functionname = '';

for($i = 0; $i<count($fragments); $i++) {

    $str = $fragments[$i];

    /* New function ? */
    preg_match("!function (.*?)\\(!", $str, $matches);
    if(count($matches) > 0) {
        $functionname = $matches[1]; }
    /* Append to function body and deal with nesting */
    else {
        if(substr($str, 0,1) == '{') { 
            $currentnesting++; }
        else if(substr($str, -1,1) == '}') { 
            $currentnesting--; }
        $currentfunctionbody.=$str;
    }

    /* Close function */
    if($currentfunctionbody != '' && $currentnesting == 0)
    {
        $functions[$functionname] = trim($currentfunctionbody,"{}");
        $currentfunctionbody = '';
        $functionname = ''; 
    }


}
print "<pre>";
print_r($functions);