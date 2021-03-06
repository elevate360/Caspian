/* jshint node:true */
module.exports = function (grunt) {

	'use strict';

	// Project configuration.
	grunt.initConfig({

		pkg: grunt.file.readJSON( 'package.json' ),

		// Check textdomain errors.
		checktextdomain: {
			options:{
				text_domain: '<%= pkg.name %>',
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			files: {
				src:  [
					'**/*.php', // Include all files
					'!node_modules/**',
					'!dist/**',
					'!orig/**'
				],
				expand: true
			}
		},

		makepot: {
			options: {
				type: 'wp-theme',
				domainPath: 'languages',
				potHeaders: {
					'report-msgid-bugs-to': 'https://elevate360/contact',
					'language-team': 'LANGUAGE <EMAIL@ADDRESS>'
				}
			},
			frontend: {
				options: {
					potFilename: '<%= pkg.name %>.pot',
					exclude: [
						'node_modules/.*',
						'dist/.*',
						'orig/.*'
					]
				}
			}
		},

		// Compile all .scss files.
		sass: {
			dist: {
				options: {
					sourceMap: false
				},
				files: [{
					'style.css': 'sass/style.scss',
					'assets/css/editor-style.css': 'sass/editor-style.scss'
				}]
			}
		},

		cmq: {
			options: {
				compress: false,
				logFile: false
			},
			media: {
				files: {
					'style.css': ['style.css'],
					'assets/css/editor-style.css': ['assets/css/editor-style.css']
				}
			}
		},

		postcss: {
			options: {
				processors: [
					require( 'autoprefixer' )({
						browsers: [
							'> 1%',
							'last 2 versions',
							'Firefox ESR',
							'Opera 12.1',
							'ie 9'
						]
					})
				]
			},
			theme: {
				src: 'style.css',
				dest: 'style.css'
			},
			editor: {
				src: 'assets/css/editor-style.css',
				dest: 'assets/css/editor-style.css'
			}
		},

	    wpcss: {
	        style: {
	            options: {
	                commentSpacing: true
	            },
	            files: {
	            	'style.css': ['style.css'],
	            	'assets/css/editor-style.css': ['assets/css/editor-style.css']
	            }
	        }
	    },

		cssmin: {
			target: {
				files: [{
					expand: true,
					cwd: './',
					src: [
						'./*.css',
						'!./*.min.css',
						'assets/css/*.css',
						'!assets/css/*.min.css'],
					dest: './',
					ext: '.min.css'
				}]
			}
		},

		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'assets/js/*.js',
				'!assets/js/*.min.js'
			]
		},

		concat: {
			frontend: {
				src: ['assets/js/frontend/parallax.js', 'assets/js/frontend/skip-link-focus-fix.js', 'assets/js/frontend/navigation.js', 'assets/js/frontend/frontend.js'],
				dest: 'assets/js/frontend.js'
			}
		},

		uglify: {
			options: {
				preserveComments: 'some'
			},
			js: {
				files: [{
					expand: true,
					cwd: 'assets/js/',
					src: [
						'*.js',
						'!*.min.js'
					],
					dest: 'assets/js/',
					ext: '.min.js'
				}]
			}
		},

		watch: {
			css: {
				files: [
					'sass/*.scss',
					'sass/*/*.scss',
					'sass/*/*/*.scss',
					'sass/*/*/*/*.scss'
				],
				tasks: [
					'sass',
					'cssmin'
				]
			},
			frontend: {
				files: [
					'assets/js/frontend/*.js'
				],
				tasks: [
					'concat',
					'uglify'
				]
			},
			js: {
				files: [
					'assets/js/customizer.js',
					'assets/js/customizer-control.js',
				],
				tasks: [
					'uglify'
				]
			}
		},

		// Replace text
		replace: {
			themeVersion: {
				src: [
					'sass/style.scss'
				],
				overwrite: true,
				replacements: [ {
					from: /^.*Version:.*$/m,
					to: 'Version: <%= pkg.version %>'
				} ]
			}
		},

		// Clean up dist directory
		clean: {
			main: ['dist']
		},

		// Copy the theme into the dist directory
		copy: {
			main: {
				src:  [
					'**',
					'!csscomb.json',
					'!node_modules/**',
					'!.sass-cache/**',
					'!sass/**',
					'!dist/**',
					'!orig/**',
					'!.git/**',
					'!Gruntfile.js',
					'!package.json',
					'!package-lock.json',
					'!phpcs.xml.dist',
					'!.gitignore',
					'!.gitmodules',
					'!**/Gruntfile.js',
					'!**/package.json',
					'!**/*~'
				],
				dest: 'dist/<%= pkg.name %>/'
			}
		},

		// Compress build directory into <name>.<version>.zip
		compress: {
			main: {
				options: {
					mode: 'zip',
					archive: './dist/<%= pkg.name %>.<%= pkg.version %>.zip'
				},
				expand: true,
				cwd: 'dist/<%= pkg.name %>/',
				src: ['**/*'],
				dest: '<%= pkg.name %>/'
			}
		}

	});

	grunt.loadNpmTasks( 'grunt-postcss' );
    grunt.loadNpmTasks( 'grunt-checktextdomain' );
    grunt.loadNpmTasks( 'grunt-combine-media-queries' );
    grunt.loadNpmTasks( 'grunt-contrib-clean' );
    grunt.loadNpmTasks( 'grunt-contrib-compress' );
    grunt.loadNpmTasks( 'grunt-contrib-concat' );
    grunt.loadNpmTasks( 'grunt-contrib-copy' );
    grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
    grunt.loadNpmTasks( 'grunt-contrib-jshint' );
    grunt.loadNpmTasks( 'grunt-contrib-watch' );
    grunt.loadNpmTasks( 'grunt-sass' );
    grunt.loadNpmTasks( 'grunt-text-replace' );
    grunt.loadNpmTasks( 'grunt-contrib-uglify' );
    grunt.loadNpmTasks( 'grunt-wp-css' );
    grunt.loadNpmTasks( 'grunt-wp-i18n' );

	grunt.registerTask( 'css', [
		'sass',
		'cmq',
		'postcss',
		'wpcss',
		'cssmin'
	]);

	grunt.registerTask( 'dist', [
		'replace',
		'css',
		'makepot',
		'uglify',
		'clean',
		'copy',
		'compress'
	]);

};
