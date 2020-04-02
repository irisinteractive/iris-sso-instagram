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
 * @date        6/15/19 8:21 PM
 * @copyright   Copyright (c) 2002-2019 IRIS Interactive, Inc. (http://www.iris-interactive.fr)
 */

const path                    = require( 'path' );
const cssOutputShared         = 'css/app_shared.min.css';
const cssOutputAdmin          = 'css/app_admin.min.css';
const webpack                 = require( 'webpack' );
const ExtractTextPlugin       = require( 'extract-text-webpack-plugin' );
const CssUrlRelativePlugin    = require( 'css-url-relative-plugin' );
const CopyWebpackPlugin       = require( 'copy-webpack-plugin' );
const ImageminPlugin          = require( 'imagemin-webpack-plugin' ).default;
const IconfontPlugin          = require( 'iconfont-plugin-webpack' );
const TerserPlugin            = require( 'terser-webpack-plugin' );
const OptimizeCssAssetsPlugin = require( 'optimize-css-assets-webpack-plugin' );
const CompressionPlugin       = require( "compression-webpack-plugin" );
const DashboardPlugin         = require( "webpack-dashboard/plugin" );
const basePath                = path.resolve( __dirname ) + '/';

const shared   = new ExtractTextPlugin( cssOutputShared );
const admin   = new ExtractTextPlugin( cssOutputAdmin );

let config = {
    entry: {
        app_shared: basePath + 'assets/src/js/app_shared.js',
        app_admin: basePath + 'assets/src/js/app_admin.js',
    },
    output: {
        filename: 'js/[name].min.js',
        path: basePath + 'assets/dist/',
    },
    plugins: [],
    module: {
        rules: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
            },
            {
                test: /\.(svg|ttf|eot|woff|woff2|png|jpe?g|gif|svg)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: 'fonts/[folder]/[name].[ext]',
                            useRelativePath: false
                        }
                    }
                ]
            },
            {
                test: /app_shared.(scss)$/,
                use: shared.extract( {
                                       use: [
                                           'css-loader',
                                           'sass-loader'
                                       ],
                                       fallback: 'style-loader'
                                   } )
            },
            {
                test: /app_admin.(scss)$/,
                use: admin.extract( {
                                       use: [
                                           'css-loader',
                                           'sass-loader'
                                       ],
                                       fallback: 'style-loader'
                                   } )
            },
            {
                loader: "webpack-modernizr-loader",
                test: /\.modernizrrc\.js$/
            }
        ]
    },
    resolve: {
        alias: {
            modernizr$: path.resolve( __dirname ) + "/.modernizrrc.js",
            pluginstyle: path.resolve( __dirname, "assets/src/scss/" ),
            pluginscript: path.resolve( __dirname, "assets/src/js/" ),
            plugincpnt: path.resolve( __dirname, "assets/src/js/components/" ),
            pluginfont: path.resolve( __dirname, "assets/src/fonts/" ),
        },
        extensions: [
            '.js',
            '.scss',
        ],
        modules: [ "node_modules" ]
    },
    performance: {
        hints: false
    },
    watch: true
};

module.exports = ( env, argv ) => {
    
    if ( argv.mode === 'development' ) {
        config.plugins = [
            new DashboardPlugin(),
            new IconfontPlugin( {
                                    src: basePath + 'assets/src/images/svgicons',
                                    family: 'plugin-font',
                                    dest: {
                                        font: basePath + 'assets/src/fonts/svgfont/[family].[type]',
                                        css: basePath + 'assets/src/scss/lib/_iconfont.scss'
                                    },
                                    watch: {
                                        pattern: basePath + 'assets/src/images/svgicons/**/*.svg',
                                        cwd: undefined
                                    },
                                    cssTemplate: require( basePath + 'assets/src/scss/templates/_iconfont' )
                                } ),
            new CssUrlRelativePlugin(),
            shared,
            admin,
            new CopyWebpackPlugin( [
                                       {
                                           from: basePath + 'assets/src/images',
                                           to: 'images',
                                           ignore: [ 'svgicons/*' ]
                                       }
                                   ] ),
            new webpack.ProvidePlugin( {
                                           $: 'jquery',
                                           jQuery: 'jquery',
                                           "window.jQuery": "jquery"
                                       } ),
        ];
        config.devtool = 'cheap-module-source-map';
    }
    
    if ( argv.mode === 'production' ) {
        config.optimization = {
            minimizer: [
                new TerserPlugin( {
                                      cache: true,
                                      parallel: true,
                                      sourceMap: false,
                                      terserOptions: {
                                          ecma: 6,
                                          warnings: false,
                                          parse: {},
                                          compress: {},
                                          mangle: true,
                                          module: false,
                                          output: {
                                              comments: false,
                                          },
                                          toplevel: false,
                                          nameCache: null,
                                          ie8: false,
                                          keep_classnames: undefined,
                                          keep_fnames: false,
                                          safari10: false,
                                      },
                                  } )
            ]
        },
            config.plugins = [
                new DashboardPlugin(),
                new IconfontPlugin( {
                                        src: basePath + 'assets/src/images/svgicons',
                                        family: 'theme-font',
                                        dest: {
                                            font: basePath + 'assets/src/fonts/svgfont/[family].[type]',
                                            css: basePath + 'assets/src/scss/lib/_iconfont.scss'
                                        },
                                        watch: {
                                            pattern: basePath + 'assets/src/images/svgicons/**/*.svg',
                                            cwd: undefined
                                        },
                                        cssTemplate: require( basePath + 'assets/src/scss/templates/_iconfont' )
                                    } ),
                new CssUrlRelativePlugin(),
                shared,
                admin,
                new OptimizeCssAssetsPlugin( {
                                                 cssProcessor: require( 'cssnano' ),
                                                 cssProcessorPluginOptions: {
                                                     preset: [
                                                         'default',
                                                         { discardComments: { removeAll: true } }
                                                     ],
                                                 },
                                                 canPrint: false
                                             } ),
                new CompressionPlugin(),
                new CopyWebpackPlugin( [
                                           {
                                               from: basePath + 'assets/src/images',
                                               to: 'images',
                                               ignore: [ 'svgicons/**/*' ]
                                           }
                                       ] ),
                new ImageminPlugin( { test: /\.(jpe?g|png|gif|svg)$/i } ),
                new webpack.ProvidePlugin( {
                                               $: 'jquery',
                                               jQuery: 'jquery',
                                               "window.jQuery": "jquery"
                                           } ),
            ];
    }
    
    return config;
};
