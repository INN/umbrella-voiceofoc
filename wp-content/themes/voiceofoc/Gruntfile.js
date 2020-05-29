module.exports = function(grunt) {
    'use strict';

    // Load all tasks
    require('load-grunt-tasks')(grunt);
    // Show elapsed time
    require('time-grunt')(grunt);

    // Force use of Unix newlines
    grunt.util.linefeed = '\n';

    // Find what the current theme's directory is, relative to the WordPress root
    var path = process.cwd().replace(/^[\s\S]+\/wp-content/, "\/wp-content");

    var CSS_LESS_FILES = {
        'css/style.css': 'less/style.less',
    };

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        less: {
            compile: {
                options: {
                    paths: ['less', '../largo/less/inc'], // This includes all of largo's less/inc.
                    outputSourceFiles: true,
                    sourceMapBasepath: path,
                    compress: false
                },
                files: CSS_LESS_FILES
            },
        },

        watch: {
            less: {
                files: [
                    'less/**/*.less',
                ],
                tasks: [
                    'less:compile',
                ]
            }
        },

    });

    // Build assets, docs and language files
    grunt.registerTask('default', 'Build less files', [
      'less',
    ]);
}
