
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
		'bower_components/bootstrap/dist/js/bootstrap.min.js',
	],
	styles: [
		'bower_components/bootstrap/dist/css/bootstrap.min.css'
	],
	compiled: 'build'
};

gulp.task('scripts', function () {

	// Compile javascript

	return gulp.src(paths.scripts)
		.pipe(concat('scripts.js'))
		.pipe(uglify())
		.pipe(gulp.dest(paths.compiled));
});

gulp.task('styles', function () {

	// Compile styles

	return gulp.src(paths.styles)
		.pipe(concat('style.css'))
		.pipe(autoprefixer('last 3 versions'))
		.pipe(gulp.dest(paths.compiled));
});

gulp.task('build', ['styles', 'scripts']);
gulp.task('default', ['build']);
