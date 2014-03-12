/* jshint node: true */

module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        // Configuration location
        pkg: grunt.file.readJSON('package.json'),

        // Javascript quality tool
        jshint: {
            options: {
                jshintrc: '.jshintrc'
            },
            gruntfile: {
                src: 'Gruntfile.js'
            },
            src: {
                src: ['public/js/app.views.js']
            }
        },

        // Minify and uglify javascript files
        uglify: {
            options: {
                banner: '<%= banner %>',
                report: 'min'
            },
            webapp: {
                src: [
                    'public/js/jquery.js',
                    'public/js/vendor/bootstrap/bootstrap.js',
                    'public/js/vendor/twitter/typeahead.js',
                    'public/js/underscore.js',
                    'public/js/backbone.js',
                    'public/js/app.js',
                    'public/js/app.models.js',
                    'public/js/app.views.js',
                    'public/js/app.collections.js',
                    'public/js/app.router.js'
                ],
                dest: 'public/js/app.min.js'
            }
        },
    });

    // Load plugins
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');

    // Default task(s).
    //grunt.registerTask('default', ['jshint','uglify']);
    grunt.registerTask('default', ['uglify']);

};