'use strict';

// ОСНОВНЫЕ ПЛАГИНЫ
var gulp = require('gulp'),
	merge = require('merge-stream'),
	gutil = require('gulp-util'),
	//size = require('gulp-filesize'),
	size = require('gulp-size'),//Вывод размеров файла
	//bytediff = require('gulp-bytediff'),
	clean = require('gulp-clean'),//Очистка файлов, директорий
	concat = require('gulp-concat'),//соединение файлов
	rename = require("gulp-rename"),//переименование файлов
	gzip = require('gulp-gzip'),//Сжатие
	notify = require("gulp-notify"),//Вывод сообщений
	duration = require('gulp-duration'),//Время выполнения
	rev_append = require('gulp-rev-append');//Обновление версии в link href, src и т.д.
// CSS ПЛАГИНЫ
var autoprefixer = require('gulp-autoprefixer'),//Добавление префиксов
	csscomb = require('gulp-csscomb'),//Форматирование
	shorthand = require('gulp-shorthand'),//Укороченные формы стилей
	cleanCSS = require('gulp-clean-css');//Минимизация css
// HTML ПЛАГИНЫ
var htmlmin = require('gulp-htmlmin'),//Минимизация HTML
	htmlcomb = require('gulp-htmlcomb');//Упорядочевание HTML
// JS ПЛАГИНЫ
var esformatter = require('gulp-esformatter'),//Форматирование
	uglify = require('gulp-uglify'),//Минимизация
	jscrush = require('gulp-jscrush');//Минимизация минимизированнных файлов
// IMG ПЛАГИНЫ
var imagemin = require('gulp-imagemin'),//Минимизация изображений
	pngquant = require('imagemin-pngquant');//Дополнение для минимизации png
// PHP ПЛАГИНЫ



/*=================================================================
 Работа с ccs файлами
 - сборка
 - автопрефикс
 ======> Сохранение в concatStyle.css
 - минимизация
 - переименование
 ======> Сохранение в style.min.css
 - архивация
 ======> Сохранение в style.min.css.gz
 */
gulp.task('css', ['rev_append'], function() {
	var one_var = gulp.src(['www/views/face/themes/default/css/fulls/style.css', 'www/views/face/themes/default/css/fulls/media1.css'])
    .pipe(concat('style.css'))
    .pipe(autoprefixer({
			browsers: ['last 2 versions', '> 1%', 'ie 9']
		}))
    .pipe(shorthand())
    .pipe(csscomb('yandex.json'))
    .pipe(size({showFiles : true}))
    .pipe(gulp.dest('www/views/face/themes/default/css/'))
    .pipe(cleanCSS({debug: true}, function(details) {
            // console.log('Original - ' + details.name + ': ' + Math.ceil((details.stats.originalSize / 1024) * 10) / 10 + ' kB');
            // console.log('Minified - ' + details.name + ': ' + Math.ceil((details.stats.minifiedSize / 1024) * 10) / 10 + ' kB');
        }))
    .pipe(rename("style.min.css"))
    .pipe(size({showFiles : true}))
    .pipe(gulp.dest('www/views/face/themes/default/css/'))
    .pipe(gzip())
    .pipe(size({showFiles : true}))
    .pipe(notify('CSS <%= file.relative %> - Готово!'))
    .pipe(gulp.dest('www/views/face/themes/default/css/'))
    .on('error', gutil.log);

    var two_var = gulp.src(['www/views/face/themes/default/css/fulls/jquery.formstyler.css'])
    .pipe(autoprefixer({
			browsers: ['last 2 versions', '> 1%', 'ie 9']
		}))
    .pipe(shorthand())
    .pipe(csscomb('yandex.json'))
    .pipe(size({showFiles : true}))
    .pipe(gulp.dest('www/views/face/themes/default/css/'))
    .pipe(cleanCSS({debug: true}))
    .pipe(rename({suffix: ".min"}))
    .pipe(size({showFiles : true}))
    .pipe(gulp.dest('www/views/face/themes/default/css/'))
    .pipe(gzip())
    .pipe(size({showFiles : true}))
    .pipe(notify('CSS <%= file.relative %> - Готово!'))
    .pipe(gulp.dest('www/views/face/themes/default/css/'))
    .on('error', gutil.log);

    return merge(one_var, two_var);
});

/*=================================================================
 Работа с html (php с html разметкой) файлами
 - минимизация
 ======> Сохранение в min/**\/*.php
 */
gulp.task('html', function() {

	return gulp.src(['./www/views/face/themes/default/**/*.php', '!./www/views/face/themes/default/**/min/*.php'])
	.pipe(htmlcomb(/*options*/))
	.pipe(gulp.dest('./www/views/face/themes/default'))
    .pipe(htmlmin({
    	collapseWhitespace: true,
    	minifyCSS: true,
    	minifyJS: true,
    	removeComments: true,
    	removeScriptTypeAttributes: true,
    	removeStyleLinkTypeAttributes: true,
    	useShortDoctype: true
    }))
    .pipe(size({showFiles : true}))
    .pipe(notify('HTML - Готово!'))
    .pipe(gulp.dest(function(file){
    	
    	var mypath = file.path;//Оригинальный путь файла
    	file.path = mypath.replace(/([A-Za-z0-9_]+)\.php/,'min\\$1.php');//Добавляем перед именем файла папку min
    	return './www/views/face/themes/default';//На выход отправляем статический путь, после чего gulp плюсует динамический путь из file.path

    }))
    .on('error', gutil.log);
});

/*=================================================================
 Работа с изображениями
 */
gulp.task('img', () => {
	return gulp.src(['./www/img/Product_img/*', '!./www/img/Product_img/test_img'])
		.pipe(imagemin({
			progressive: true,
			svgoPlugins: [{removeViewBox: false}],
			use: [pngquant()]
		}))
		.pipe(notify('IMG - Готово!'))
		.pipe(gulp.dest('./www/img/Product_img/test_img'));
});

/*=================================================================
 Обновление версии подключаемых файлов (css, js)
 */
gulp.task('rev_append', function() {

	var static1F = gulp.src('./www/views/face/themes/default/blocks/Head_block.php')
	.pipe(rev_append())
	.pipe(notify('rev_append Head_block - Готово!'))
	.pipe(gulp.dest('./www/views/face/themes/default/blocks'));

	var static2F = gulp.src('./www/views/face/themes/default/blocks/Footer_block.php')
	.pipe(rev_append())
	.pipe(notify('rev_append Footer_block - Готово!'))
	.pipe(gulp.dest('./www/views/face/themes/default/blocks'));

	var dinamic1F = gulp.src('./www/controllers/face/Head_controller.php')
	.pipe(rev_append())
	.pipe(notify('rev_append Head_controller - Готово!'))
	.pipe(gulp.dest('./www/controllers/face'));

	var dinamic2F = gulp.src('./www/controllers/face/Footer_controller.php')
	.pipe(rev_append())
	.pipe(notify('rev_append Footer_controller - Готово!'))
	.pipe(gulp.dest('./www/controllers/face'));

    return merge(dinamic1F, dinamic2F, static1F, static2F);
});

/*=================================================================
 Работа с js файлами
 - минимизация
 ======> Сохранение в min/
 - архивация
 ======> Сохранение в min/
 */
gulp.task('js', ['rev_append'], function () {
	var one_var = gulp.src(['./www/js/face/*.js', '!./www/js/face/**/*{min.js,pack.js}'])
		.pipe(esformatter({indent: {value: '	'},}))
		.pipe(gulp.dest('./www/js/face'))
		.pipe(uglify())
		.pipe(rename({suffix: ".min"}))
		.pipe(size({showFiles : true}))
		.pipe(gulp.dest('./www/js/face/min'))
		.pipe(gzip())
		.pipe(size({showFiles : true}))
		//.pipe(notify('JS - Готово!'))
		.pipe(gulp.dest('./www/js/face/min'))
		.on('error', gutil.log);

	var two_var = gulp.src(['./www/js/face/*min.js'])
		.pipe(uglify())
		.pipe(size({showFiles : true}))
		.pipe(gulp.dest('./www/js/face/min'))
		.pipe(gzip())
		.pipe(size({showFiles : true}))
		//.pipe(notify('JS - Готово!'))
		.pipe(gulp.dest('./www/js/face/min'))
		.on('error', gutil.log);

	return merge(one_var, two_var);
});

/*=================================================================
Тестовый task для проверки jscrush плагина
 */
gulp.task('my', function () {
	return gulp.src(['./www/js/face/*.js', '!./www/js/face/**/*{min.js,pack.js}'])
		.pipe(uglify())
		.pipe(rename({suffix: ".min"}))
		.pipe(size({showFiles : true}))
		.pipe(gulp.dest('./www/js/face/min/test'))
		.pipe(jscrush())
		.pipe(gulp.dest('./www/js/face/min/test'))
		.pipe(size({showFiles : true}))
		.on('error', gutil.log);
});

/*=================================================================
Очистка файлов, директорий
 */
gulp.task('clean', function () {
    return gulp.src('app/tmp', {read: false})
        .pipe(clean());
});

/*=================================================================
 Слежка за изменениями
 */
gulp.task('watch', function(){

	gulp.watch('www/views/face/themes/default/css/fulls/*.css', ['css']);
	gulp.watch(['./www/views/face/themes/default/**/*.php', '!./www/views/face/themes/default/**/min/*.php'], ['html']);
	gulp.watch(['./www/js/face/**/*.js'], ['js']);

});

gulp.task('default', ['watch']);