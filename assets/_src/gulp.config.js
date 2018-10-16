module.exports = {
  tasks: {
    browsersync: true,
    eslint:      true,
    imagemin:    true,
    sass:        true,
    watch:       true,
    webpack:     true,
  },

  assets: './assets',

  browsersync: {
    siteurl: 'framework.pp',
  },

  eslintLoader: {
    enforce: "pre",
    test:    /\.js$/,
    exclude: /node_modules/,
    loader:  "eslint-loader",
  },

  imagemin: {
    src:         '_src/_images',
    dest:        'images',
    progressive: true,
    svgoPlugins: [{removeViewBox: false}],
  },

  js: {
    src:   '_src/_js',
    dest:  'js',
    entry: [
      'main.js',
    ],
  },

  sass: {
    src:          '_src/_sass',
    dest:         'css',
    outputStyle:  'compressed',
    autoprefixer: {
      browsers: [
        '> 1%',
        'last 2 versions',
        'Firefox ESR',
      ],
    },
  },

  webpack: {
    mode:   'production',
    module: {
      rules: [],
    },
  },
}
