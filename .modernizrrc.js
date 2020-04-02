"use strict";

module.exports = {
    "classPrefix": "",
    "enableClasses": true,
    "enableJSClass": true,
    "usePrefixes": true,
    "minify": true,
    options: [
        "setClasses"
    ],
    "feature-detects": [
        "test/css/flexbox",
        "test/es6/promises",
        "test/serviceworker",
        "test/touchevents",
        "css/objectfit",
        "css/backgroundcliptext"
    ]
};