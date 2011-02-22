Description
===========

SVNInclude is an extension that allows you to render text files into your wiki from any svn repo.

Usage
=====

SVNInclude adds a tag to mediawiki parser: ``svninclude``. This tag may have the following attributes:

+----------+----------+---------------------------------------------+
| Name     | Required |                Description                  |
+==========+==========+=============================================+
| src      |    yes   | The file path you want to render            |
+----------+----------+---------------------------------------------+
| username |     no   | A username with read access to the svn repo |
+----------+----------+---------------------------------------------+
| pass     |     no   | The password associated with the user       |
+----------+----------+---------------------------------------------+
| svnroot  |     no   | The SVN root folder                         |
+----------+----------+---------------------------------------------+
| linenums |     no   | Print line numbers                          |
+----------+----------+---------------------------------------------+

As an example consider::

  <svninclude src="foo.txt" user="foo" pass="bar" svnroot="/home/foo/svn/" />

Here we are rendering file foo.txt, which is located in /home/foo/svn. The user accessing it is foo with password bar.

Username, pass and svnroot are not required as attributes in tag svninclude. It is possible to define default values for these attributes, by defining three variables in your LocalSettings.php::

  $svnPluginReaderUsername -> Default username
  $svnPluginReaderPassword -> Password for default user
  $svnPathRoot -> Default root for svn repository

When nothing is said, these values will be used. So if the above were set to::

  $svnPluginReaderUsername = 'foo';
  $svnPluginReaderPassword = 'bar';
  $svnPathRoot = '/home/foo';

We could write only::

  <svninclude src="foo.txt" />

Notice, that although the password and username may not exist at all (Since they're not required by every protocol used in svn) the same is not true for svnroot. Either it is specified or it must have a default value, otherwise the plugin will not know which svn repo you are trying to access.

Features
========

If the file being rendered contains mediawiki markup it will also be parsed and the result will be the same as if you were editting text in your wiki.

In the remote case that your file contains mediawiki markup that you don't want to parse, consider wrapping it around <nowiki> tags. 

Known Limitations
=================

The file path most begin with a '/' if the svnroot doesn't end with one and vice versa. However, it is not possible to have both.

Current implementation must have the protocol specified in svnroot if a remote repo is to be used. Since we can't use '/' in html attributes, we need to specify this in the $svnPathRoot. I still don't know if it is possible to encode the
