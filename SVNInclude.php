<?php
 
$wgExtensionFunctions[] = "wf_include";
$wgExtensionCredits['other'][] = array
(
    'name' => 'SVNInclude',
    'author' => 'Frederico Gonçalves',
    'url' => '',
    'description' => 'This extensions lets you include svn files from any svn repo.'
);
 
function wf_include()
{
    global $wgParser;
    $wgParser->setHook( "svninclude", "ef_SVNInclude_Render" );
}
 
function ef_SVNInclude_Render ( $input , $argv, $parser )
{
    global $svnPluginReaderUsername, $svnPluginReaderPassword, $svnPathRoot;
 
    if ( ! isset($argv['src']))
        return '<p style="color: red;">Missing "src" attribute in svninclude tag.</p>';
 
    $cmd = 'svn';

    if(isset($argv['username']))
	$cmd .= ' --username ' . escapeshellarg($argv['username']);
    else{
	if(isset($svnPluginReaderUsername))
	    $cmd .= ' --username ' . $svnPluginReaderUsername;
    }
    if(isset($argv['pass']))
	$cmd .= ' --password ' . escapeshellarg($argv['pass']);
    else{
	if(isset($svnPluginReaderPassword))
            $cmd .= ' --password ' . $svnPluginReaderPassword;
    }

    if(isset($argv['svnroot']))
        $cmd .= " cat " . escapeshellarg($argv['svnroot']) . escapeshellarg($argv['src']);
    else
	if(isset($svnPathRoot))
	   $cmd .= " cat " . $svnPathRoot . escapeshellarg($argv['src']);
	else
       	    return '<p style="color: red;">Could not find svn root</p>';
    
    exec ($cmd, $output, $return_var);
    
    if ($return_var != 0)
       return "<p style=\"color: red;\">Could not read the given src URL using 'svn cat'.</p><p>\nreturn code: $return_var\noutput: " . join("\n", $output) . "</p>";
    
    $output = join("\n", $output);
    $output = $parser->recursiveTagParse($output);       
    
    if (isset($argv['linenums']))
    {
        $output_a = split("\n",$output);
	for ($i = 0; $i < count($output_a); $i++)
            $output_a[$i] = (1 + $i) . ": " . $output_a[$i];
        $output = join("\n", $output_a);
    }
 
    return $output;	
}
?>
