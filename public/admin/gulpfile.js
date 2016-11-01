
var path = require('path'),
	gulp = require('gulp'),
	concat = require('gulp-concat'),
	autoprefixer = require('gulp-autoprefixer'),
	uglify = require('gulp-uglify'),
	stylus = require('gulp-stylus'),
	ks = require('kouto-swiss'),
	minify = require('gulp-minify-css');

var paths = {
	scripts: [
		'bower_components/jquery/dist/jquery.min.js',
		'bower_components/bootstrap/dist/js/bootstrap.min.js',
		'bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js',
		'bower_components/metisMenu/dist/metisMenu.min.js',
		'dist/js/sb-admin-2.js',
		'plugin/ckeditor/ckeditor.js',
	],
	styles: [
		'bower_components/bootstrap/dist/css/bootstrap.min.css',
		'bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
		'bower_components/metisMenu/dist/metisMenu.min.css',
		'dist/css/sb-admin-2.css',
		'bower_components/font-awesome/css/font-awesome.min.css',
		'bower_components/datatables-responsive/css/dataTables.responsive.css',
		'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css',
	],
	compiled: 'build'
};

gulp.task('scripts', function () {

	// Compile javascript

	return gulp.src(paths.scripts)
		.pipe(concat('scripts.js'))
		//.pipe(uglify())
		.pipe(gulp.dest(paths.compiled));
});

gulp.task('styles', function () {

	// Compile styles

	return gulp.src(paths.styles)
		.pipe(concat('styles.css'))
		.pipe(autoprefixer('last 3 versions'))
		.pipe(gulp.dest(paths.compiled));
});

gulp.task('build', ['styles', 'scripts']);
gulp.task('default', ['build']);
