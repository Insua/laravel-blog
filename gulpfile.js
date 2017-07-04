var gulp = require('gulp');
var rename = require('gulp-rename');
var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

/**
 * 拷贝所需文件
 */
gulp.task("copyfiles",function()
{
    gulp.src("bower_components/jquery/dist/jquery.js")
        .pipe(gulp.dest("resources/assets/js/"));

    gulp.src("bower_components/bootstrap/less/**")
        .pipe(gulp.dest("resources/assets/less/bootstrap"));

    gulp.src("bower_components/bootstrap/dist/js/bootstrap.js")
        .pipe(gulp.dest("resources/assets/js/"));

    gulp.src("bower_components/bootstrap/dist/fonts/**")
        .pipe(gulp.dest("resources/assets/fonts"));

});

gulp.task("copyFontAwesomeAndDataTables",function()
{
    gulp.src("bower_components/font-awesome/less/**")
        .pipe(gulp.dest("resources/assets/less/fontawesome"));


    gulp.src("bower_components/font-awesome/fonts/**")
        .pipe(gulp.dest("resources/assets/fonts"));

    var dtDir = 'bower_components/datatables-plugins/integration/';

    gulp.src("bower_components/datatables/media/js/jquery.dataTables.js")
        .pipe(gulp.dest('resources/assets/js/'));

    gulp.src(dtDir + 'bootstrap/3/dataTables.bootstrap.css')
        .pipe(rename('dataTables.bootstrap.less'))
        .pipe(gulp.dest('resources/assets/less/others/'));

    gulp.src(dtDir + 'bootstrap/3/dataTables.bootstrap.js')
        .pipe(gulp.dest('resources/assets/js/'));

});

gulp.task('copyFontsToPublic',function()
{
    gulp.src("resources/assets/fonts/**")
        .pipe(gulp.dest("public/assets/fonts"));
});

gulp.task("copySelectizeAndPickadate",function()
{
    gulp.src("bower_components/selectize/dist/css/**")
        .pipe(gulp.dest("public/assets/selectize/css"));
    gulp.src("bower_components/selectize/dist/js/standalone/selectize.min.js")
        .pipe(gulp.dest("public/assets/selectize/"));
    gulp.src("bower_components/pickadate/lib/compressed/themes/**")
        .pipe(gulp.dest("public/assets/pickadate/themes/"));
    gulp.src("bower_components/pickadate/lib/compressed/picker.js")
        .pipe(gulp.dest("public/assets/pickadate/"));
    gulp.src("bower_components/pickadate/lib/compressed/picker.date.js")
        .pipe(gulp.dest("public/assets/pickadate/"));
    gulp.src("bower_components/pickadate/lib/compressed/picker.time.js")
        .pipe(gulp.dest("public/assets/pickadate/"));
});

elixir(function(mix) {

    //合并js
    mix.scripts([
            'js/jquery.js',
            'js/bootstrap.js',
            'js/jquery.dataTables.js',
            'js/dataTables.bootstrap.js'
        ],
        'public/assets/js/admin.js',
        'resources/assets'
    );

    //编译less
    mix.less('admin.less','public/assets/css/admin.css');

    mix.browserSync({
        proxy: 'blog.learn.app'
    });
});
