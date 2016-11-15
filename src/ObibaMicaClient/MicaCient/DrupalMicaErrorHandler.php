<?php

/**
 * Created by PhpStorm.
 * User: samir
 * Date: 16-11-13
 * Time: 18:34
 */
namespace ObibaMicaClient;

class ObibaMicaException extends \Exception{
  function __construct($message, $code) {
  }
}

class DrupalMicaError {

  public static function DrupalMicaErrorHandler($force = NULL, $message_parameters = NULL) {
    $current_path = current_path();
    if ($force) {
      header('Location: ' . HIDE_PHP_FATAL_ERROR_URL . '?destination=' . $current_path, FALSE);
      drupal_set_message(t($message_parameters['message'],
        $message_parameters['placeholders']),
        $message_parameters['severity']);
      exit;
    }
    if ((!is_null($error = error_get_last()) && $error['type'] === E_ERROR)) {
      header('Location: ' . HIDE_PHP_FATAL_ERROR_URL . '?destination=' . $current_path);
      // We need to reuse the code from _drupal_error_handler_real() to
      // force the maintenance page.
      require_once DRUPAL_ROOT . '/includes/errors.inc';

      $types = drupal_error_levels();
      list($severity_msg, $severity_level) = $types[$error['type']];

      if (!function_exists('filter_xss_admin')) {
        require_once DRUPAL_ROOT . '/includes/common.inc';
      }

      // We consider recoverable errors as fatal.
      $error = array(
        '%type' => isset($types[$error['type']]) ? $severity_msg : 'Unknown error',
        // The standard PHP error handler considers that the error messages
        // are HTML. We mimick this behavior here.
        '!message' => filter_xss_admin($error['message']),
        '%file' => $error['file'],
        '%line' => $error['line'],
        'severity_level' => $severity_level,
      );
      drupal_set_message(t('%type: !message (line %line of %file).',$error),
        'warning' );
      watchdog('php', '%type: !message (line %line of %file).', $error, $error['severity_level']);
      exit;
      throw new ObibaMicaException(t('%type: !message (line %line of %file).', $error),
        $error['severity_level']);
    }
  }

}