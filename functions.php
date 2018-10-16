<?php

// Setup Framework Base Functions
require_once ('inc/activation.php'); // Functions to run after install theme
require_once ('inc/setup.php');

// Filters, Hooks and functions about wp-admin
require_once ('inc/wp-admin.php');

// Wordpress Bootrap Navwalker
require_once ('inc/vendor/wp_bootstrap_navwalker.php');

// Custom functions for theming
require_once ('inc/custom-actions.php');
require_once ('inc/custom-shortcakes.php');
require_once ('inc/custom-functions.php');
require_once ('inc/custom-acf.php');
require_once ('inc/custom-wpcf7.php');
