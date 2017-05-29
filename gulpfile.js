'use strict';

let publicDir = 'public_html';

let gulp = require('gulp');
let sass = require('gulp-sass');
let concat = require('gulp-concat');
let uglify = require('gulp-uglify');
let cleanCss = require('gulp-clean-css');
let order = require('gulp-order');

gulp.task('sass', function () {
    return gulp.src([
        'resources/sass/**/*.scss',
        'resources/bower_components/bootstrap/dist/css/bootstrap.min.css',
        'resources/bower_components/bootstrap/dist/css/bootstrap-theme.min.css'])
        .pipe(sass())
        .pipe(concat('bundle.css'))
        .pipe(cleanCss({compatibility: 'ie8'}))
        .pipe(gulp.dest(publicDir + '/css'));
});

gulp.task('fonts', function () {
    gulp.src('resources/bower_components/bootstrap/fonts/*') // path to your files
        .pipe(gulp.dest(publicDir + '/fonts/'));
});

gulp.task('js', function() {
    return gulp.src([
        'resources/bower_components/jquery/dist/jquery.js',
        'resources/bower_components/bootstrap/dist/js/bootstrap.js',
        'resources/js/**/*.js'])
        .pipe(order(['jquery.js', 'bootstrap.js', '*.js']))
        .pipe(concat('bundle.js'))
        .pipe(uglify())
        .pipe(gulp.dest(publicDir + '/js'));
});