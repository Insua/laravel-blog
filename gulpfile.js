var gulp = require('gulp');
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

elixir(function(mix) {

    //合并js
    mix.scripts(['js/jquery.js','js/bootstrap.js'],
        'public/assets/js/admin.js',
        'resources/assets'
    );

    //编译less
    mix.less('admin.less','public/assets/css/admin.css');
});
