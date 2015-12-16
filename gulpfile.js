var gulp = require('gulp');

// SASS/CSS deps
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minifyCss = require('gulp-minify-css');

// JS deps
var browserify = require('browserify');
var watchify = require('watchify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var vueify = require('vueify');
var uglify = require('gulp-uglify');

// General gulp deps
var sourcemaps = require('gulp-sourcemaps');
var gutil = require('gulp-util');

// All paths used in gulpfile.
var paths = {
    css: {
        in: 'resources/assets/sass/*.scss',
        out: 'public/dist'
    },
    js: {
        in: 'resources/assets/js/global.js',
        out: 'public/dist',
        watch: 'resources/assets/js/*.js'
    }
};

// CSS development Task, Adds source maps and does not minify.
gulp.task('css-dev', function () {
    return cssTask(true);
});

// CSS Task, Compile sass, prefix and minify.
gulp.task('css', function () {
    return cssTask(false);
});

gulp.task('js-dev', function () {
    return jsTask(true, false);
});

gulp.task('js', function () {
    return jsTask(false, false);
});

gulp.task('default', ['css-dev', 'js-dev']);
gulp.task('watch', ['css-dev', 'js-dev'], function() {
    gulp.watch(paths.css.in, ['css-dev']);
    jsTask(true, true);
});

function version() {

};


function cssTask(isDevelopment) {
    var task = gulp.src(paths.css.in);
    if (isDevelopment) task = task.pipe(sourcemaps.init());
    task = task.pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer('last 2 version', 'ie 8', 'ios 5', 'android 3'));
    if (isDevelopment) task = task.pipe(sourcemaps.write());
    if (!isDevelopment) task = task.pipe(minifyCss());
    return task.pipe(gulp.dest(paths.css.out));
}

function jsTask(isDevelopment, isWatching) {
    var b = browserify({
        entries: paths.js.in,
        debug: true,
        transform: [vueify]
    });

    if (isWatching) b = watchify(b);

    function bundleUp() {
        var task = b.bundle().pipe(source('app.js')).pipe(buffer());
        if (isDevelopment) {
            task = task.pipe(sourcemaps.init())
                .pipe(uglify())
                .pipe(sourcemaps.write());
        }
        gutil.log('Bundling done, Writing out');
        return task.pipe(gulp.dest(paths.js.out));
    }

    b.on('update', function() {
        bundleUp();
        gutil.log('Bundling...')
    });

    return bundleUp();
}


//elixir(function(mix) {
//    mix.sass('styles.scss')
//        .sass('print-styles.scss')
//        .browserify(['jquery-extensions.js', 'global.js'], 'public/js/common.js')
//        .version(['css/styles.css', 'css/print-styles.css', 'js/common.js']);
//});
