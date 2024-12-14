import globals from "globals";
import pluginJs from "@eslint/js";

/** @type {import('eslint').Linter.FlatConfig[]} */
export default [
  {
    languageOptions: {
      globals: globals.browser,
      ecmaVersion: 12,
      sourceType: 'module',
    },
  },
  pluginJs.configs.recommended,
  {
    rules: {
      'func-names': 'off',
      'indent': ['error', 4, { 'ignoreComments': true }],
      'max-len': 'off',
      'no-console': ['error'],
      'no-plusplus': ['error', { 'allowForLoopAfterthoughts': true }],
      'no-prototype-builtins': 'off',
      'object-curly-spacing': ['error', 'never'],
      'object-shorthand': 'off',
      'prefer-arrow-callback': 'off',
      'quote-props': ['error', 'consistent'],
    },
  },
];
