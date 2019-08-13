#!/bin/bash
# Install and setup MediaWiki and its prerequisites
# on a DEB based system (like Debain and Ubuntu).

# immediately exit on any failed command
set -e


# Setings
mw_version_major="1.33"
mw_version_minor="0"
install_root="$HOME"
local_web_root="/var/www/html"
mw_dir="w"
mw_root="$local_web_root/$mw_dir"
mw_extensions="SemanticMediaWiki,SemanticResultFormats,ContactPage,PageForms,VisualEditor,AJAXPoll,CategoryTree,Comments,EmbedVideo,MsUpload,ParserFunctions,PipeEscape,Variables,Bootstrap,VEForAll,HtmlSpecialFunctions"


cd "$install_root"


################################################################################
# Install requirements
sudo apt-get install \
	php php-apcu php-intl php-mbstring php-xml php-mysql composer \
	mariadb-server \
	apache2


################################################################################
# Download and extract MediaWiki
mw_version_full="${mw_version_major}.${mw_version_major}"
mw_dir="mediawiki-${mw_version_full}"
mw_archive="${mw_dir}.tar.gz"
wget "https://releases.wikimedia.org/mediawiki/${mw_version_major}/${mw_archive}"
tar xf "${mw_archive}"
sudo ln -s "$(pwd)/${mw_dir}" "$mw_root"


################################################################################
# Setup a DB
sql_cmds="create_wiki_db.sql"
cat >> "$sql_cmds" << EOF
CREATE DATABASE wikidb;
CREATE USER 'wikiuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON wikidb.* TO 'wikiuser'@'localhost' WITH GRANT OPTION;
EOF
mariadb < "$sql_cmds"
rm "$sql_cmds"


################################################################################
# Setup MediaWiki

# These extensions already come pre-bundled with MediaWiki
# * CategoryTree
# * ParserFunctions

# These extensions we install with `composer` (PHP package/dependency manager)
# * Semantic MediaWiki
# * Semantic Result Formats
# * Page Forms
# * ParserHooks (a special extension, which does not need ot be "installed" later on)
# * Bootstrap
# * Cameleon (Skin)
mw_compose_extensions="mediawiki/semantic-media-wiki mediawiki/semantic-result-formats mediawiki/page-forms mediawiki/parser-hooks mediawiki/bootstrap mediawiki/chameleon-skin"
composer require $mw_compose_extensions

# These extensions we install with instructions from https://www.mediawiki.org/wiki/Special:ExtensionDistributor
# * VisualEditor
# * AJAXPoll
# * ContactPage
# * MsUpload
# * Pipe Escape
# * Variables
# * VEForAll
# * Comments
wget https://extdist.wmflabs.org/dist/extensions/VisualEditor-REL1_33-8c9c37e.tar.gz
wget https://extdist.wmflabs.org/dist/extensions/AJAXPoll-REL1_33-e77bcb7.tar.gz
wget https://extdist.wmflabs.org/dist/extensions/ContactPage-REL1_33-abdcab9.tar.gz
wget https://extdist.wmflabs.org/dist/extensions/MsUpload-REL1_33-2c533f8.tar.gz
wget https://extdist.wmflabs.org/dist/extensions/PipeEscape-REL1_33-f15eefa.tar.gz
wget https://extdist.wmflabs.org/dist/extensions/Variables-REL1_33-8c027d1.tar.gz
wget https://extdist.wmflabs.org/dist/extensions/VEForAll-REL1_33-0797e29.tar.gz
wget https://extdist.wmflabs.org/dist/extensions/Comments-REL1_33-752d201.tar.gz
for ext_arch in *-REL1_33-*.tar.gz
do
	tar -xzf "$ext_arch" -C "$mw_root/extensions"
done

# These extensions we install with custom/per extension instructions
# * EmbedVideo
wget "https://gitlab.com/hydrawiki/extensions/EmbedVideo/-/archive/v2.8.0/EmbedVideo-v2.8.0.zip"
unzip "EmbedVideo-v2.8.0.zip" -d "$mw_root/extensions/"
(cd "$mw_root/extensions" && ln -s "EmbedVideo-v2.8.0" "EmbedVideo")

# These extensions we install from git
# * HtmlSpecialFunctions
git clone git@github.com:ohowiki/oho.git
cp -r "oho/HtmlSpecialFunctions" "$mw_root/extensions/"

# NOTE Missing!
#[WYSIWYG editor](https://www.mediawiki.org/wiki/Extension:WYSIWYG) is probably outdated; deprecated by VisualEditor.

cd "$mw_root"
composer install
php maintenance/install.php \
	--confpath "$mw_root" \
	--scriptpath "/$mw_dir" \
	--server "http://localhost" \
	--dbname "wikidb" \
	--dbtype "mysql" \
	--dbuser "wikiuser" \
	--dbpass "password" \
	--skins "chameleon" \
	--extensions "$mw_extensions" \
	--pass "adminpw" \
	"OpenHardwareObservatory" \
	"$USER"

# Enable & setup SemanticMediaWiki
# see https://www.semantic-mediawiki.org/wiki/Help:Installation/Quick_guide
echo -e "enableSemantics( 'example.org' );\n" >> "LocalSettings.php"
sudo composer update --no-dev
sudo php maintenance/update.php
sudo php extensions/SemanticMediaWiki/maintenance/setupStore.php

# Open the installation details page in the default browser
xdg-open "http://localhost/w/index.php/Special:Version"

