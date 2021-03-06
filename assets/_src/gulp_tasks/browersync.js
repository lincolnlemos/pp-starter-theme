const browsersync = require('browser-sync').create();
const config      = require('../gulp.config.js');
const gulp        = require('gulp');

gulp.task('browsersync', function () {
  return browsersync.init({
      proxy: config.browsersync.siteurl,
      notify: false
  });
});

gulp.task('browser-reload', function () {
  return browsersync.reload();
});
