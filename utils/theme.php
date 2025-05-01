<?php
function getTheme() {
  return isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'dark'; // default ke dark
}

function getThemeButtonIcon() {
  return getTheme() === 'dark' ? 'bx bxs-sun' : 'bx bxs-moon';
}

function getThemeButtonText() {
  return getTheme() === 'dark' ? 'Light Mode' : 'Dark Mode';
}

function getColorClass($light, $dark) {
  return getTheme() === 'dark' ? $dark : $light;
}
