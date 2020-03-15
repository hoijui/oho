# OHO

## Installation Requirements

In addition to the OHO extension itself,
a standard MediaWiki installation has the following requirements:

- A [web server](#web-server) to serve the requested pages to the client browser
- [PHP](#php)
- A [database server](#database-server) to store the pages and site data

In addition to those, there are various optional dependencies
which are required if you want to use certain advanced features (see below).

If your website is hosted (i.e. you don't have direct control over it),
then contact your server administrator or hosting company
to ensure these software packages are installed and available.

### Web server

In order to serve wiki pages to browsers,
MediaWiki requires some web server software.
Often you will not have a choice of which software to use –
it will be the one provided by your hosting provider.

Most installations use the Apache web server,
available at the official download page.
However, MediaWiki has also been tested under
IIS 7.0, Cherokee, Hiawatha, LiteSpeed, nginx (configuration example), lighttpd, and Caddy.

### PHP

PHP is the programming language in which MediaWiki is written,
and is required in order to run the software.

Note that although MediaWiki ships with an installation script
which provides web-based configuration of the most important elements,
some knowledge of PHP is required for more detailed customizations.

For the latest stable version of MediaWiki,
at least PHP version 7.0.13 is required.
See the page on [Compatibility](TODO) for further information.

The following extensions are required:

- Perl Compatible Regular Expressions (PCRE) (MediaWiki 1.23 requires PCRE 7.2+)
- session
- spl
- openssl
- json (since 1.22)
- mbstring (required since 1.27, recommended for earlier versions)
- fileinfo (required since 1.30)

Note that all of these are enabled in PHP by default.

MediaWiki's installer will warn if you don't have the optional _PHP intl_ extension "to handle Unicode normalization".
In most Debian/Ubuntu-based distros, this is the `php-intl` package.

_PHP OpenSSL_ extension is also recommended.
See Manual: $wgSessionInsecureSecrets.
On most Debian/Ubuntu-based distros the `php-mysql` package is required if you want MediaWiki to use MySQL.

Some features of MediaWiki may require PHP functions that execute external processes,
like image thumbnailing,
that some cheap hosts usually disable.
This has surfaced specially in MediaWiki 1.23 on file uploads (task T68467).
Please take this into consideration if you plan to install MediaWiki on a shared host.

MediaWiki extensions may require additional PHP features,
e.g. _VisualEditor_ requires `libcurl` support (`php-curl` on Debian/Ubuntu-based distros).

If you need to compile PHP from source,
then see _PHP configuration_ for compilation options that affect MediaWiki.

### Database server

MediaWiki stores all the text and data
(content pages, user details, system messages, etc.)
in a database,
which it is capable of sharing with other web-based applications (phpBB, etc.).
You will need one of the following database servers to run the latest version of MediaWiki:

- MySQL 5.5.8+* or MariaDB 5.1+
- PostgreSQL 9.2+ (supported since MediaWiki 1.8) See Manual:Installing MediaWiki#PostgreSQL for more detail.
- SQLite 3
- Microsoft SQL Server 2008 R2 or later is supported for LTS releases and is not guaranteed to work for non-LTS releases (requires Microsoft Windows as Operating System because it uses the SQLSRV driver).
  Make sure the Full-Text module is installed.

Supported in the past, currently unsupported:

- Oracle (unsupported on the latest MediaWiki versions due to open blocking bugs)
Some users find it helpful to install an additional software package such as phpMyAdmin (MySQL/MariaDB) or phpPgAdmin (Postgres) to help administer the database server.

## Hardware requirements

The recommended minimum requirements are 256MB of RAM for a single-computer website
and 85MB of storage,
although this will not suffice for a busy public site or a site with uploading enabled.
Some users have reported running MediaWiki on computers with as little as 48MB of RAM.

The install size can be reduced to around 50MB for a developer install
and to around 26MB for a non-developer, end-user install.

## SUMMARY

For experienced users, here is the quick version of the installation instructions.
Most users will want to go through all the passages.

1-Check that your system meets the minimum requirements shown nearby; Installation requirements has more details.
2-Download MediaWiki (direct link to download the stable release version) and extract the archive to a web-accessible folder on your server.
3-Point your browser to the directory where MediaWiki was extracted and follow the link to the setup screen. It should be in the form http://domain/directory/mw-config/index.php. Replace directory with the path to your extracted MediaWiki folder. If installing on a local machine, replace domain with localhost. If you install locally and later want to access your wiki from domain, then you will need to change LocalSettings.php from localhost to domain. If installed on a remote server, replace domain with your server's domain name (eg: www.myserver.com).
4-Follow the on-screen instructions to complete the process.
These instructions are deliberately brief. There is a lot that could go wrong, so if in doubt, you are advised to read the full instructions!
