										
					LICENSE
MediaWiki is free software licensed under version 2 of the GNU General Public License. Because MediaWiki is licensed free of charge, there is no warranty, to the extent permitted by applicable law. Read the full text of the GNU GPL version 2 for details.(https://www.gnu.org/licenses/old-licenses/gpl-2.0.html)



					SYSTEM REQUIREMENTS
MediaWiki requires PHP 7.0.13+ and either MySQL 5.5.8+, MariaDB, or one of the other three possible stores. For more information, please read the pages on system requirements(https://www.mediawiki.org/wiki/Special:MyLanguage/Manual:Installation_requirements) and compatibility(https://www.mediawiki.org/wiki/Special:MyLanguage/compatibility).

					INSTALLATİON REQUIREMENTS
In addition to the software itself, a standard MediaWiki installation has the following requirements:

	-A web server is required to serve the requested pages to the client browser.
	-PHP is required to run the software.
	-A database server is required to store the pages and site data.
In addition, there are various optional dependencies which are required if you want to use certain advanced features (see below).

If your website is hosted (i.e. you don't have direct control over it) then contact your server administrator or hosting company to ensure these software packages are installed and available.

				~Web server~
In order to serve wiki pages to browsers, MediaWiki requires some web server software. Often you will not have a choice of which software to use – it will be the one provided by your hosting provider.

Most installations use the Apache web server, available at the official download page. However, MediaWiki has also been tested under IIS 7.0, Cherokee, Hiawatha, LiteSpeed, nginx (configuration example), lighttpd, and Caddy.

				~PHP~
PHP is the programming language in which MediaWiki is written, and is required in order to run the software.

Note that although MediaWiki ships with an installation script which provides web-based configuration of the most important elements, some knowledge of PHP is required for more detailed customizations.

For the latest stable version of MediaWiki, at least PHP version 7.0.13 is required. See the page on Compatibility for further information.
The following extensions are required:
Perl Compatible Regular Expressions (PCRE) (MediaWiki 1.23 requires PCRE 7.2+)
session
spl
openssl
json (since 1.22)
mbstring (required since 1.27, recommended for earlier versions)
fileinfo (required since 1.30)
Note that all of these are enabled in PHP by default.
MediaWiki's installer will warn if you don't have the optional PHP intl extension "to handle Unicode normalization".
In most Debian/Ubuntu-based distros this is the php-intl package.
PHP OpenSSL extension is also recommended. See Manual:$wgSessionInsecureSecrets.
On most Debian/Ubuntu-based distros the php-mysql package is required if you want MediaWiki to use MySQL.
Some features of MediaWiki may require PHP functions that execute external processes, like image thumbnailing, that some cheap hosts usually disable. This has surfaced specially in MediaWiki 1.23 on file uploads (task T68467). Please take this into consideration if you plan to install MediaWiki on a shared host.
MediaWiki extensions may require additional PHP features, e.g. VisualEditor requires libcurl support (php-curl on Debian/Ubuntu-based distros).
If you need to compile PHP from source, then see PHP configuration for compilation options that affect MediaWiki.

			~Database server~

MediaWiki stores all the text and data (content pages, user details, system messages, etc.) in a database, which it is capable of sharing with other web-based applications (phpBB, etc.). You will need one of the following database servers to run the latest version of MediaWiki:

  -MySQL 5.5.8+* or MariaDB 5.1+
  -PostgreSQL 9.2+ (supported since MediaWiki 1.8) See Manual:Installing MediaWiki#PostgreSQL for more detail.
  -SQLite 3
  -Microsoft SQL Server 2008 R2 or later is supported for LTS releases and is not guaranteed to work for non-LTS releases (requires Microsoft Windows as Operating System because it uses the SQLSRV driver).
Make sure the Full-Text module is installed.

Supported in the past, currently unsupported:

  -Oracle (unsupported on the latest MediaWiki versions due to open blocking bugs)
Some users find it helpful to install an additional software package such as phpMyAdmin (MySQL/MariaDB) or phpPgAdmin (Postgres) to help administer the database server.

			~Hardware requirements~
The recommended minimum requirements are 256MB of RAM for a single-computer website and 85MB of storage, although this will not suffice for a busy public site or a site with uploading enabled. Some users have reported running MediaWiki on computers with as little as 48MB of RAM.

The install size can be reduced to around 50MB for a developer install and to around 26MB for a non-developer, end-user install.



					SUMMARY
	For experienced users, here is the quick version of the installation instructions. Most users will want to go through all the passages.

1-Check that your system meets the minimum requirements shown nearby; Installation requirements has more details.
2-Download MediaWiki (direct link to download the stable release version) and extract the archive to a web-accessible folder on your server.
3-Point your browser to the directory where MediaWiki was extracted and follow the link to the setup screen. It should be in the form http://domain/directory/mw-config/index.php. Replace directory with the path to your extracted MediaWiki folder. If installing on a local machine, replace domain with localhost. If you install locally and later want to access your wiki from domain, then you will need to change LocalSettings.php from localhost to domain. If installed on a remote server, replace domain with your server's domain name (eg: www.myserver.com).
4-Follow the on-screen instructions to complete the process.
These instructions are deliberately brief. There is a lot that could go wrong, so if in doubt, you are advised to read the full instructions!
					
					
					INSTALLING MEDIAWIKI
				


			~Download MediaWiki software~
You can download a release version of MediaWiki from the official download page: generally, if you're using a production environment, you want to be running the stable release.

To download MediaWiki 1.33.0, which is the latest stable release version, to a *nix machine you can use the following command:

wget https://releases.wikimedia.org/mediawiki/1.33/mediawiki-1.33.0.tar.gz
Alternatively, using cURL:

curl -O https://releases.wikimedia.org/mediawiki/1.33/mediawiki-1.33.0.tar.gz
The downloaded files are in .tar.gz format, so they will need to be uncompressed before use. This can be done locally (and then uploaded via FTP) or directly on your server. This is usually done with software such as 7-Zip (free), WinZip, WinRAR or IZArc (free) on Windows. On Linux and Mac OS X, you can untar the file using this command:

tar xvzf mediawiki-*.tar.gz

			


			~Upload files to your server~
If you have not already uploaded the files to your web server, do so now.

Upload the files to your web server's web directory either by:

directly copying the unzipped folder or
by using an FTP client such as FileZilla (Open Source Software, Windows, OSX and Linux) or Cyberduck (OSX).
If your upload tool has a "change file names to lowercase" option, then you must disable this.

If you installed Apache, the correct directory is specified in your httpd.conf file (it's the DocumentRoot directive, typically /var/www/ or <apache-folder>/htdocs). Note: This changed in Ubuntu 14.04 with Apache 2.4.7 where the primary configuration file for Apache server settings and directories is /etc/apache2/apache2.conf.

If you are using a Linux or Unix server you can instead copy the files to any directory on your server and then make a symbolic link to that folder from your web server's web directory.

Rename the uploaded folder to whatever you would like to have in the URL. If your web server is running as http://localhost for example, renaming to /w/ directory would mean you would access your wiki at http://localhost/w/index.php. Do not use /wiki/ if you want to use it as a Short URL. (And don't set up short URLs until you have run the installation script.)




			~Create a database~
If you already have a database server and know the root password for it, the MediaWiki installation script can create a new database for you. If this is the case, you can skip to the Run the installation script section below. If you don't know the root password, for example if you are on a hosted server, you will have to create a new database now. Currently, you must use SQLite, MariaDB/MySQL or PostgreSQL to store the actual contents of your wiki.

    -SQLite
SQLite is a stand-alone database library that stores the database contents in a single file. If PHP has the pdo-sqlite module, no further setup is required.

On the installation page, you will need to choose a database name (which can be anything) and the SQLite database directory. For the database directory, the installer will attempt to use a subdirectory outside of the document root and create it if needed. If this directory is not safe (for example, web-readable), change it manually to avoid making it accessible to everyone on the web.

    -MariaDB/MySQL
MediaWiki will ask you for database and user name and will attempt to create them if they don't already exist. If doing so from MediaWiki is impossible, you can do this using various control panels such as PhpMyAdmin, which are often available from shared hosts, or you may be able to use ssh to login to your host and type the commands into a MySQL prompt. See the corresponding documentation. Alternatively, contact your host provider to have them create an account for you.

CREATE DATABASE wikidb;
CREATE USER 'wikiuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON wikidb.* TO 'wikiuser'@'localhost' WITH GRANT OPTION;
If your database is not running on the same server as your web server, you need to give the appropriate web server hostname — mediawiki.example.com in the example below — as follows:

GRANT ALL PRIVILEGES ON wikidb.* TO 'wikiuser'@'mediawiki.example.com' IDENTIFIED BY 'password';

Warning Warning:	MySQL/MariaDB on UNIX/Linux logs all queries sent to it to a file, which will include the password you used for the user account. If this concerns you, delete your .mysql_history file after running these queries. This file may be found in your home directory (~/.mysql_history).


     -PostgreSQL
If you are using PostgreSQL, you will need to either have a database and user created for you, or simply supply the name of a PostgreSQL user with "superuser" privileges to the configuration form. Often, this is the database user named postgres.

Here's one way to do most of the setup. This is for a Unix-like system. In this example, we'll create a database named wikidb, owned by a user named wikiuser. From the command-line, as the postgres user, perform the following steps.

 createuser -S -D -R -P -E wikiuser (then enter the password)
 createdb -O wikiuser wikidb
or as superuser (default postgres) execute the following commands at the database prompt:

CREATE USER wikiuser WITH NOCREATEDB NOCREATEROLE NOSUPERUSER ENCRYPTED PASSWORD 'password';
CREATE DATABASE wikidb WITH OWNER wikiuser;



			~Run the installation script~
Once all of the above steps are complete, you can complete the installation through a web browser by going to the index.php URL in your browser — check the instructions mentioned in Manual:Config script.

The installation tool will prompt you to download the LocalSettings.php file, and to save this as <MediaWiki-folder>/LocalSettings.php.

Alternatively, you can run the command-line installer or CLI: php maintenance/install.php adding the appropriate configuration parameters.


					EXTENSION INSTALLATION
	1-Bootstrap
The Bootstrap extension requires Composer for installation. 
1-If not already done, install Composer.(https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
2-Add mediawiki/bootstrap: ~4.0 as a requirement to your "composer.local.json" file in the MediaWiki installation directory
3-Run composer update --no-dev "mediawiki/bootstrap"
4-Load the extension by adding the following line to LocalSettings.php: wfLoadExtension( 'Bootstrap' );
5-Yes Done – Navigate to "Special:Version" on your wiki to verify that the extension is successfully installed.

	2-CategoryTree
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/CategoryTree) and place the file(s) in a directory called CategoryTree in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'CategoryTree' );
3-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	3-Cite
1-If using Vagrant, install with vagrant roles enable cite --provision
  
   Manual installation
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/Cite) and place the file(s) in a directory called Cite in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'Cite' );
3-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	4-CiteThþsPage
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/CiteThisPage) and place the file(s) in a directory called CiteThisPage in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'CiteThisPage' );
3-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	5-CodeEditor
1-If using Vagrant, install with vagrant roles enable codeeditor --provision

   Manual installation
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/CodeEditor) and place the file(s) in a directory called CodeEditor in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'CodeEditor' );
$wgDefaultUserOptions['usebetatoolbar'] = 1; // user option provided by WikiEditor extension
3-Configure as required.
4-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	6-Comments
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/Comments) and place the file(s) in a directory called Comments in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'Comments' );
3-Run the update script which will automatically create the necessary database tables that this extension needs.
4-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	7-ConfirmEdit
1-If using Vagrant, install with vagrant roles enable confirmedit --provision

  Manual installation
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/ConfirmEdit) and place the file(s) in a directory called ConfirmEdit in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'ConfirmEdit' );
3-Enable the CAPTCHA type which should be used
4-Configure as needed
5-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	8-ContactPage
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/ContactPage) and place the file(s) in a directory called ContactPage in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:

wfLoadExtension( 'ContactPage' );
$wgContactConfig['default'] = array(
	'RecipientUser' => 'WikiUser', // Must be the name of a valid account which also has a verified e-mail-address added to it.
	'SenderName' => 'Contact Form on ' . $wgSitename, // "Contact Form on" needs to be translated
	'SenderEmail' => null, // Defaults to $wgPasswordSender, may be changed as required
	'RequireDetails' => true, // Either "true" or "false" as required
	'IncludeIP' => true, // Either "true" or "false" as required
	'MustBeLoggedIn' => true, // Check if the user is logged in before rendering the form
	'AdditionalFields' => array(
		'Text' => array(
			'label-message' => 'emailmessage',
			'type' => 'textarea',
			'rows' => 20,
			'required' => true,  // Either "true" or "false" as required
		),
	),
        // Added in MW 1.26
	'DisplayFormat' => 'table',  // See HTMLForm documentation for available values.
	'RLModules' => array(),  // Resource loader modules to add to the form display page.
	'RLStyleModules' => array(),  // Resource loader CSS modules to add to the form display page.
);

3-See the README(https://phabricator.wikimedia.org//r/p/mediawiki/extensions/ContactPage;browse/master/README%3Fview%3Draw) file for further options to customize and adapt as it convenes. Note, however, that since March 2014, it is no longer possible to prefill text from MediaWiki:Contactpage-text-[form-name].
4-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	9-EmbedVideo
1-Download(https://gitlab.com/hydrawiki/extensions/EmbedVideo/-/archive/v2.8.0/EmbedVideo-v2.8.0.zip) and place the file(s) in a directory called EmbedVideo in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'EmbedVideo' );
3-Configure as required(https://www.mediawiki.org/wiki/Extension:EmbedVideo#Configuration)
4-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	10-Gadgets
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/Gadgets) and place the file(s) in a directory called Gadgets in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'Gadgets' );
3-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	11-HtmlSpecialFunctions

	12-ImageMap
1-Make sure that uploads and ImageMagick are installed:

$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert"; 
2-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/ImageMap) and place the file(s) in a directory called ImageMap in your extensions/ folder.
3-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'ImageMap' );
4-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	13-InputBox
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/InputBox) and place the file(s) in a directory called InputBox in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'InputBox' );
3-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	14-InterWiki
1-Get the latest revision of the code from InterWiki.php(https://code.organicdesign.nz/extensions/tree/master/MediaWiki-Legacy/InterWiki/), save as a file in your extensions directory and include from your LocalSettings.php file as usual.

	15-LocalisationUpdate
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/LocalisationUpdate) and place the file(s) in a directory called LocalisationUpdate in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'LocalisationUpdate' );
$wgLocalisationUpdateDirectory = "$IP/cache";
3-Create a cache folder in the installation directory, and be sure the server has permissions to write on it.
4-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	16-MsUpload
1-Install the WikiEditor extension(https://www.mediawiki.org/wiki/Extension:WikiEditor). By default its editing toolbar is enabled for all users.
2-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/MsUpload) and place the file(s) in a directory called MsUpload in your extensions/ folder.
3-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'MsUpload' );
Configure as required.
4-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	17-MultimediaViewer
 Option A: use Vagrant. See the MediaWiki-Vagrant page for instructions to get a MediaWiki installation going with a Vagrant virtual machine system.

Then do vagrant enable-role multimediaviewer and then vagrant provision.

 Option B: install manually.

First, consider installing Extension:BetaFeatures. It may be helpful to hide the media viewer feature behind a preference. If you don't install this, it will be enabled everywhere. MultimediaViewer uses the GetBetaFeaturePreferences hook, which is created and run from BetaFeatures, to register this preference.

You'll also likely want to download Extension:CommonsMetadata - it's not a hard requirement, but without it you won't get very much information in your lightboxes.


Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/MultimediaViewer) and place the file(s) in a directory called MultimediaViewer in your extensions/ folder.
Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'MultimediaViewer' );
Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	18-OATHAuth
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/OATHAuth) and place the file(s) in a directory called OATHAuth in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'OATHAuth' );
3-Run the update script which will automatically create the necessary database tables that this extension needs.
4-Configure as required.
5-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	19-PageForms
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/PageForms) and place the file(s) in a directory called PageForms in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'PageForms' );
3-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	20-ParserFunctions
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/ParserFunctions) and place the file(s) in a directory called ParserFunctions in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'ParserFunctions' );
3-Configure as required, e.g. if you want to use the integrated string function functionality, add just after that line:
$wgPFEnableStringFunctions = true;
4-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	21-PdfHandler
1-Make sure that the required software(https://www.mediawiki.org/wiki/Extension:PdfHandler#Pre-requisites) is installed before you continue!
2-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/PdfHandler) and place the file(s) in a directory called PdfHandler in your extensions/ folder.
3-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'PdfHandler' );
4-Configure as required. (see also the examples provided)
5-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	22-PipeEscape
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/PipeEscape) and place the file(s) in a directory called PipeEscape in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
require_once "$IP/extensions/PipeEscape/PipeEscape.php";
3-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	23-Poem
1-If using Vagrant, install with vagrant roles enable poem --provision

  Manual installation
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/Poem) and place the file(s) in a directory called Poem in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'Poem' );
3-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	24-Renameuser
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/Renameuser) and place the file(s) in a directory called Renameuser in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'Renameuser' );
3-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	25-ReplaceText
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/ReplaceText) and place the file(s) in a directory called ReplaceText in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'ReplaceText' );
3-By default, only members of the 'sysop' user group have access to the Replace Text functionality. You can add to or modify the set of allowed users by modifying the $wgGroupPermissions array in LocalSettings.php. To add the permission for 'bureaucrat' or 'bot' users, for instance, you would add the following:
$wgGroupPermissions['bureaucrat']['replacetext'] = true;
4-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	26-SemanticImageInput
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/SemanticImageInput) and place the file(s) in a directory called SemanticImageInput in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
require_once "$IP/extensions/SemanticImageInput/SemanticImageInput.php";
$wgUseInstantCommons = true; // Required for embedding of images
3-Configure as required.
4-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	27-SemanticMediaWiki
The respective instructions are located on the help page about installing Semantic MediaWiki.(https://www.semantic-mediawiki.org/wiki/Help:Installation)

	28-SemanticResultFormats
Check out the Semantic Result Formats documentation on the SMW wiki.(https://www.semantic-mediawiki.org/wiki/Semantic_Result_Formats)

	29-SpamBlackList
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/SpamBlacklist) and place the file(s) in a directory called SpamBlacklist in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'SpamBlacklist' );
3-Configure the blacklist at your convenience
4-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	30-SyntaxHighlight_GeSHi
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/SyntaxHighlight_GeSHi) and place the file(s) in a directory called SyntaxHighlight_GeSHi in your extensions/ folder.
2-Only when installing from git run Composer to install PHP dependencies, by issuing composer install --no-dev in the extension directory. (See T173141 for potential complications.)
3-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'SyntaxHighlight_GeSHi' );
 *In Linux, set execute permissions for the pygmentize binary. You can use an FTP client or the following shell command to do so:
chmod a+x /path/to/extensions/SyntaxHighlight_GeSHi/pygments/pygmentize
4-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	31-TitleBlackList
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/TitleBlacklist) and place the file(s) in a directory called TitleBlacklist in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'TitleBlacklist' );
3-Configure blacklist sources (see below)
4-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	32-Variables
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/Variables) and place the file(s) in a directory called Variables in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'Variables' );
3-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	33-VEForAll
1-Download(https://www.mediawiki.org/wiki/Special:ExtensionDistributor/VEForAll) and place the file(s) in a directory called VEForAll in your extensions/ folder.
2-Add the following code at the bottom of your LocalSettings.php:
wfLoadExtension( 'VEForAll' );
3-Yes Done – Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

	34-VisualEditor
For the General User: If you're using the latest stable version of MediaWiki you will need to download the VisualEditor-MediaWiki extension from the ExtensionDistributor page.

For the Advanced User:

The following download instructions are for use with the latest nightly build of MediaWiki only.

cd extensions
git clone https://gerrit.wikimedia.org/r/mediawiki/extensions/VisualEditor.git
cd VisualEditor
git submodule update --init

	35-WYSIWYG
WYSIWYG of #6 bundle (see Download- section), MW >= 1.23
Download WYSIWYG in your <wiki installation directory>/extensions/WYSIWYG-src directory and publish its sub-directories as wiki extensions, still keeping the original WikiEditor extension (if any). For example:
cd wiki/extensions/
git clone https://github.com/Mediawiki-wysiwyg/WYSIWYG-CKeditor.git WYSIWYG-src
ln -s WYSIWYG-src/WYSIWYG  WYSIWYG
ln -s WYSIWYG-src/SemanticForms SemanticForms
mv WikiEditor WikiEditor-org
ln -s WYSIWYG-src/WikiEditor WikiEditor
Activate WYSIWYG by adding following lines valid to your system at the bottom of your LocalSettings.php:
#Default user options:
$wgDefaultUserOptions['riched_disable']               = false;
$wgDefaultUserOptions['riched_start_disabled']        = false;
$wgDefaultUserOptions['riched_use_toggle']            = true; 
$wgDefaultUserOptions['riched_use_popup']             = false;
$wgDefaultUserOptions['riched_toggle_remember_state'] = true;
$wgDefaultUserOptions['riched_link_paste_text']       = true;

//MW<=1.24 or versions of WYSIWYG <= "1.5.6_0 [B551++01.07.2016]"
require_once "$IP/extensions/WYSIWYG/WYSIWYG.php"; 

//MW>=1.25 and versions of WYSIWYG >= "1.5.6_0 [B551+02.07.2016]"
wfLoadExtension( 'WYSIWYG' );

//MW>=1.25 and versions of WYSIWYG >= "1.5.6_0 [B551+02.07.2016]" has dependency
//to module of WikiEditor so it must be enabled too (or otherwise file
//extension.json has to be edited manually to remove dependency)
wfLoadExtension( 'WikiEditor' );
Wikitext mode: toggle- link and WikiEditor
WikiEditor which comes with bundle #6 works with MW>=1.25. If you have other versions of MW and WikiEditor add following lines into these two files:

In file LocalSettings.php:
 #Use this only with MW<=1.24: tells WYSIWYG that text based editor is WikiEditor
 $wgCKEditorWikiEditorActive = true;
In file extensions/WikiEditor/modules/ext.wikiEditor.toolbar.js (add the following lines at the end of the file just before the "} );" characters.:
  if ( mw.config.get('useWikiEditor') ) {
    if ( mw.config.get('showFCKEditor') & mw.config.get('RTE_VISIBLE') ) 
      { $('#wikiEditor-ui-toolbar').hide(); }
    else  
      { $('#wikiEditor-ui-toolbar').show(); }
  }
For more information about additional settings of LocalSettings.php etc. with MW>=1.22 and #6 bundle, see README.md (on GitHub -page).
