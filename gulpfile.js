const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const gulp = require('gulp');
const mergeMediaQueries = require('gulp-merge-media-queries');
const minify = require('gulp-minify');
const normalize = require('node-normalize-scss').includePaths;
const notify = require('gulp-notify');
const rename = require('gulp-rename');
const sass = require('gulp-sass');
const shell = require('gulp-shell');


// Define the source paths for each file type.
const src = {
	js: ['assets/src/js/**/*','!*.min.js'],
	php: ['**/*.php','!vendor/**','!node_modules/**'],
	sass: ['assets/src/sass/**/*','!assets/src/sass/components']
};

// Define the destination paths for each file type.
const dest = {
	js: 'assets/build/js',
	sass: 'assets/build/css'
};

// Take care of JS.
gulp.task('js', function(done) {
	return gulp.src(src.js)
		.pipe(minify({
			mangle: false,
			noSource: true,
			ext:{
				min:'.min.js'
			}
		}))
		.pipe(gulp.dest(dest.js))
		.pipe(notify('WPC Parent JS compiled'))
		.on('end',done);
});

// Take care of SASS.
gulp.task('sass', function(done) {
	return gulp.src(src.sass)
		.pipe(sass({
			includePaths: sassIncludes,
			outputStyle: 'expanded' //nested, expanded, compact, compressed
		}).on('error', sass.logError))
		.pipe(mergeMediaQueries())
		.pipe(autoprefixer({
			browsers: ['last 2 versions'],
			cascade: false
		}))
		.pipe(cleanCSS({
			compatibility: 'ie8'
		}))
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest(dest.sass))
		.pipe(notify('WPC Parent SASS compiled'))
        .on('end',done);
});

// "Sniff" our PHP.
gulp.task('php', function() {
	// TODO: Clean up. Want to run command and show notify for sniff errors.
	return gulp.src('index.php', {read: false})
		.pipe(shell(['composer sniff'], {
			ignoreErrors: true,
			verbose: false
		}))
		.pipe(notify('WPC Parent PHP sniffed'), {
			onLast: true,
			emitError: true
		});
});

// Test our files.
gulp.task('test',gulp.series('php'));

// Compile all the things.
gulp.task('compile',gulp.series('sass','js'));

// Let's get this party started.
gulp.task('default', gulp.series('compile','test'));

// I've got my eyes on you(r file changes).
gulp.task('watch', gulp.series('default',function(done) {
	gulp.watch(src.js, gulp.series('js'));
	gulp.watch(src.sass,gulp.series('sass'));
	gulp.watch(src.php,gulp.series('php'));
	return done();
}));
