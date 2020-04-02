/*
 * IRIS Interactive
 *
 * NOTICE OF LICENSE
 *
 * This source file is no subject to a specific license
 * but it belongs to the company IRIS Interactive.
 * You can contact IRIS Interactive at the following
 * address: contact@iris-interactive.fr
 *
 * @author      Bernard REDARES
 * @date        6/16/19 5:06 PM
 * @copyright   Copyright (c) 2002-2019 IRIS Interactive, Inc. (http://www.iris-interactive.fr)
 */

'use strict';

const TEMPLATE = `$icon-family: '__FAMILY__';

// Fonts file
@font-face {
    font-family: $icon-family;
    font-weight: normal;
    font-style: normal;
    src: url("__RELATIVE_FONT_PATH__/__FAMILY__.eot"),
    url("__RELATIVE_FONT_PATH__/__FAMILY__.woff") format("woff"),
    url("__RELATIVE_FONT_PATH__/__FAMILY__.ttf") format("truetype"),
    url("__RELATIVE_FONT_PATH__/__FAMILY__.eot?#iefix") format("embedded-opentype"),
    url("__RELATIVE_FONT_PATH__/__FAMILY__.svg#__FAMILY__") format("svg");

}

// Array fonts to mixin
$icons: __ICONS__;

// Fonts class
.fi:before {
    font-family: $icon-family;
    font-style: initial;
}

@each $name, $icon in $icons {
    .fi-#{$name}:before {
        content: $icon;
    }
}`;

function toSCSS(glyphs) {
    return JSON.stringify(glyphs, null, '\t')
               .replace(/\{/g, '(')
               .replace(/\}/g, ')')
               .replace(/\\\\/g, '\\');
}

module.exports = function(args) {
    const family = args.family;
    const pathToFonts = '~pluginfont/svgfont';
    const glyphs = args.unicodes.reduce(function(glyphs, glyph) {
        glyphs[glyph.name] = '\\' + glyph.unicode.charCodeAt(0).toString(16).toLowerCase();
        return glyphs;
    }, {});
    const data = [];
    let icons_str = '';
    data.push( glyphs );
    icons_str = toSCSS(data).replace(/\[/g, '').replace(/\]/g, '')
    
    const replacements = {
        __FAMILY__: family,
        __RELATIVE_FONT_PATH__: pathToFonts,
        __ICONS__: icons_str
    };
    
    const str = TEMPLATE.replace(/__FAMILY__|__RELATIVE_FONT_PATH__|__ICONS__/gi, function(matched){
        return replacements[matched];
    });
    
    return [
        str
    ].join('\n\n');
};
