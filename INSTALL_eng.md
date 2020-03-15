# Open Hardware Observatory - How to self-host

In short, you will need:

* web server
* database server
* MediaWiki
* a MediaWiki skin
* some MediaWiki extensions

More in the following sections.

## Requirements

### 1. MediaWiki

Tested with versions:

* `1.31.0` (Should work fine with and `1.31.x` version)


Los
Se debe agregar las modificaciones en:
https://oho.wiki/wiki/MediaWiki:Chameleon.css
https://oho.wiki/wiki/MediaWiki:Common.css
https://oho.wiki/wiki/MediaWiki:Common.js

Editar:

`skins/chameleon/layouts/custom.xml`

`LocalSettings.php`
(ojo con no mostrar data interna de este archivo)

Crear categoria `Project`

[Crear los formularios](https://oho.wiki/wiki/Spezial:Formulare).

[Crear los templates](https://oho.wiki/wiki/Spezial:Vorlagen) necesarios.


Las instalaciones serian:

Mediawiki 1.31.0

Skin:

Chameleon

Extensions:

Semantic MediaWiki
Semantic Result Formats
ContactPage
Page Forms
VisualEditor
AJAX Poll
CategoryTree
Comments
EmbedVideo
HtmlSpecialFunctions (es una extension propia creada por mi con funciones claves para el sitio)
MsUpload
ParserFunctions
Pipe Escape
Variables

Bootstrap
ParserHooks
VEForAll
WYSIWYG editor

Todas las extensiones con sus modificaciones y configuraciones
pueden ser instaladas solo copiandolas del folder extensions
y configurando el archivo `LocalSettings.php`,
excepto por la extencion `VisualEditor`,
cuya instalacion se hace con linea de comandos y usando Parsoid.

Si se quiere hacer una instalacion mas automatizada
habria que preparar una instalacion especial.

