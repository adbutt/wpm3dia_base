module.exports = function( grunt ) {

	// Project configuration
	grunt.initConfig( {
		pkg:    grunt.file.readJSON( 'package.json' ),
		concat: {
			options: {
				stripBanners: true,
				banner: '/*! <%= pkg.title %> - v<%= pkg.version %>\n' +
					' * <%= pkg.homepage %>\n' +
					' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
					' * Licensed GPLv2+' +
					' */\n'
			},
			main: {
				src: [
          'assets/js/vendor/modernizr.js',
          'assets/js/vendor/jquery.slicknav.js',
          'assets/js/vendor/jquery.waypoints.min.js',
          'assets/js/vendor/modaal.min.js',
          'assets/js/vendor/slick.min.js',
          'assets/js/vendor/jquery.validate.min.js',
					'assets/js/src/project.js'
				],
				dest: 'assets/js/project.js'
			}
		},
		jshint: {
			all: [
				'Gruntfile.js',
				'assets/js/src/**/*.js',
				'assets/js/test/**/*.js'
			]
		},
		uglify: {
			all: {
				files: {
					'assets/js/project.min.js': ['assets/js/project.js']
				},
				options: {
					banner: '/*! <%= pkg.title %> - v<%= pkg.version %>\n' +
						' * <%= pkg.homepage %>\n' +
						' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
						' * Licensed GPLv2+' +
						' */\n',
					mangle: {
						except: ['jQuery']
					}
				}
			}
		},

		sass:   {
			all: {
				options: {
					includePaths: require('node-neat').includePaths,
						sourceMap: true
				},
				files: {
					'assets/css/project.css': 'assets/css/scss/project.scss',
          'assets/css/project-editor.css': 'assets/css/scss/editor.scss',
          'assets/css/admin-style.css': 'assets/css/scss/admin.scss',
          'assets/css/ie.css': 'assets/css/scss/ie.scss',
				}
			}
		},

		postcss: {
			options: {
          map: true,
          processors: [
            require('autoprefixer')({browsers: 'last 2 versions'}),
          ]
      },
      dist: {
				src: 'assets/css/project.css'
			}
		},

    combine_mq: {
      new_filename: {
        options: {
          log:false
        },
      src:'assets/css/project.css',
      dest: 'assets/css/project.css'
      }
    },

		cssmin: {
			options: {
				banner: '/*! <%= pkg.title %> - v<%= pkg.version %>\n' +
					' * <%=pkg.homepage %>\n' +
					' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
					' * Licensed GPLv2+' +
					' */\n'
			},
			minify: {
				expand: true,

				cwd: 'assets/css/',
				src: ['project.css','project-editor.css','admin-style.css','ie.css'],

				dest: 'assets/css/',
				ext: '.min.css'
			}
		},
		watch:  {
			livereload: {
				files: ['assets/css/*.css'],
				options: {
					livereload: true
				}
			},
			styles: {
				files: ['assets/css/scss/**/*.scss'],
				tasks: ['sass', 'postcss', 'cssmin'],
				options: {
					debounceDelay: 500
				}
			},
			scripts: {
				files: ['assets/js/src/**/*.js', 'assets/js/vendor/**/*.js'],
				tasks: ['jshint', 'concat', 'uglify'],
				options: {
					debounceDelay: 500
				}
			}
		},
		clean: {
			main: ['release/<%= pkg.version %>']
		},
		copy: {
			// Copy the theme to a versioned release directory
			main: {
				expand: true,
				src:  [
					'**',
					'!**/.*',
					'!**/readme.md',
					'!node_modules/**',
					'!vendor/**',
					'!tests/**',
					'!release/**',
					'!assets/css/scss/**',
					'!assets/css/src/**',
					'!assets/js/src/**',
					'!images/src/**',
					'!bootstrap.php',
					'!bower.json',
					'!composer.json',
					'!composer.lock',
					'!Gruntfile.js',
					'!package.json',
					'!phpunit.xml',
					'!phpunit.xml.dist'
				],
				dest: 'release/<%= pkg.version %>/'
			}
		},
		compress: {
			main: {
				options: {
					mode: 'zip',
					archive: './release/slin_.<%= pkg.version %>.zip'
				},
				expand: true,
				cwd: 'release/<%= pkg.version %>/',
				src: ['**/*'],
				dest: 'slin_/'
			}
		},
		phpunit: {
			classes: {
				dir: 'tests/phpunit/'
			},
			options: {
				bin: 'vendor/bin/phpunit',
				bootstrap: 'bootstrap.php.dist',
				colors: true,
				testSuffix: 'Tests.php'
			}
		},
		qunit: {
			all: ['tests/qunit/**/*.html']
		}
	} );

	// Load tasks
	require('load-grunt-tasks')(grunt);

	// Register tasks

	grunt.registerTask( 'css', ['sass', 'postcss','combine_mq', 'cssmin'] );

	grunt.registerTask( 'js', ['jshint', 'concat', 'uglify'] );

	grunt.registerTask( 'default', ['css', 'js'] );

	grunt.registerTask( 'build', ['default', 'clean', 'copy', 'compress'] );

	grunt.registerTask( 'test', ['phpunit', 'qunit'] );

	grunt.util.linefeed = '\n';
};
