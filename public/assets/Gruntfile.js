module.exports = function (grunt) {
    
    "use strict";
    //Garregar todas as dependencias
    require("matchdep").filterDev("grunt-*").forEach(grunt.loadNpmTasks);
    require('time-grunt')(grunt);
    
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        
        watch: {
            options:{
                livereload: false
            },
            
            js:{
                files:['src/js/**/*.js'],
                tasks:['jshint', 'concat']
            },

            css:{
                files:['src/sass/*.scss'],
                tasks:['compass', 'cssmin:combine']
            },

            img:{
                files:['src/img/*'],
                tasks:['imagemin']
            }
        },

        concat: {
            options:{
                separator:'\n\n'
            },

            js:{
                src:[
                    'components/jquery/dist/jquery.min.js',
                    'components/bootstrap/dist/js/bootstrap.min.js',
                    'src/js/modules/base.js',
                    'src/js/main.js'
                ],
                dest: 'dist/js/app.js'
            }
        },

        jshint:{
            options:{
                curly: true,
                eqeqeq: true,
                eqnull: true,
                browser: true,
                evil:true,
                '-W100':true,
                ignores: ['components/**/*.js'],
                globals: {
                    $:true,
                    jQuery: true,
                    console:true
                }
            },
            files:['src/js/modules/**/*.js']
        },

        uglify:{
            task: {
                options:{
                    report:false,
                    compress:true,
                    mangle:false
                },

                files:{
                    'dist/js/app.min.js':['dist/js/app.js']
                }
            }
        },

        compass:{
            dist:{
                options:{
                    config:'config.rb'
                }
            }
        },

        cssmin:{
            opitions:{
                report:'min',
                keepSpecialComments:0
            },
            combine:{
                files:{
                    'dist/css/style.css':[
                        'components/bootstrap/dist/css/bootstrap.min.css',
                        'components/fontawesome/css/font-awesome.min.css',
                        'src/css/main.css'
                    ]
                }
            },

            minify:{
                src:['dist/css/style.css'],
                dest:['dist/css/style.min.css']
            }
        },

        imagemin: {
            png: {
                options: {
                    optimizationLevel: 7
                },
                files: [
                    {
                        expand: true,
                        cwd: 'src/img/',
                        src: ['**/*.png'],
                        dest: 'dist/img/',
                        ext: '.png'
                    }
                ]
            },
            jpg: {
                options: {
                    progressive: true
                },
                files: [
                    {
                        expand: true,
                        cwd: 'src/img/',
                        src: ['**/*.jpg'],
                        dest: 'dist/img/',
                        ext: '.jpg'
                    }
                ]
            }
        },

        complexity: {
            generic: {
                src: ['src/js/modules/*.js'],
                options: {
                    breakOnErrors: true,
                    jsLintXML: 'report.xml',         // create XML JSLint-like report
                    checkstyleXML: 'checkstyle.xml', // create checkstyle report
                    errorsOnly: false,               // show only maintainability errors
                    cyclomatic: [3, 7, 12],          // or optionally a single value, like 3
                    halstead: [8, 13, 20],           // or optionally a single value, like 8
                    maintainability: 100,
                    hideComplexFunctions: false,     // only display maintainability
                    broadcast: false                 // broadcast data over event-bus
                }
            }
        }

    });

    grunt.registerTask('default', ['watch']);
    grunt.registerTask('minify', ['uglify, cssmin:minify']);
    grunt.registerTask('complexity-js', ['complexity']);
};
