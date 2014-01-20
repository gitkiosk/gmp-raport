<?php

session_start();

/**
 * Use PHP sessions to store values.
 */
class apiSessionStorage {

  /**
   * Sets a value in a PHP session.
   * @param string $value The value to set in the session.
   */
  public function set($value) {
    $_SESSION['access_token'] = $value;
  }

  /**
   * @return string The value stored in the session.
   */
  public function get() {
    return $_SESSION['access_token'];
  }

  /**
   * Deletes the value from the session.
   */
  public function delete() {
    unset($_SESSION['access_token']);
  }
}

/**
 * Use browser cookies to store values.
 */
class apiCookieStorage {

  /**
   * Sets a cookie called access_token to expire for 1 hour in the
   * future.
   * @param string The value to store in the cookie.
   */
  public function set($value) {
    setcookie('access_token', urlencode($value), time() + 3600);
  }

  /**
   * @return string The value stored in the cookie.
   */
  public function get() {
    return urldecode($_COOKIE['access_token']);
  }

  /**
   * Deletes the cookie. Browsers delete cookies when their expiration
   * is set in the past.
   */
  public function delete() {
    setcookie('access_token', '', time() - 100);
  }
}

