module.exports = {
  'extends': ['eslint:recommended', 'google'],
  'env': {
    // For more environments, see here: http://eslint.org/docs/user-guide/configuring.html#specifying-environments
    'browser': true,
    'es6': true
  },
  'rules': {
    // Insert custom rules here
    // For more rules, see here: http://eslint.org/docs/rules/
    'no-var': 'warn',
    'no-undef': 'warn',
    'no-unused-vars': 'warn',
    'no-invalid-this': 'warn',
    'require-jsdoc': 'off',
    'no-console': 'off',
    'max-len': 'off'
  },
  'parserOptions': {
    'sourceType': 'module'
  }
}
