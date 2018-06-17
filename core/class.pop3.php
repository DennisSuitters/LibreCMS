<?php
/**
 * PHPMailer POP-Before-SMTP Authentication Class.
 * PHP Version 5
 * @package PHPMailer
 * @link https://github.com/PHPMailer/PHPMailer/
 * @author Marcus Bointon (Synchro/coolbru) <phpmailer@synchromedia.co.uk>
 * @author Jim Jagielski (jimjag) <jimjag@gmail.com>
 * @author Andy Prevost (codeworxtech) <codeworxtech@users.sourceforge.net>
 * @author Brent R. Matzelle (original founder)
 * @copyright 2012 - 2014 Marcus Bointon
 * @copyright 2010 - 2012 Jim Jagielski
 * @copyright 2004 - 2009 Andy Prevost
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * PHPMailer POP-Before-SMTP Authentication Class.
 * Specifically for PHPMailer to use for RFC1939 POP-before-SMTP authentication.
 * Does not support APOP.
 * @package PHPMailer
 * @author Richard Davey (original author) <rich@corephp.co.uk>
 * @author Marcus Bointon (Synchro/coolbru) <phpmailer@synchromedia.co.uk>
 * @author Jim Jagielski (jimjag) <jimjag@gmail.com>
 * @author Andy Prevost (codeworxtech) <codeworxtech@users.sourceforge.net>
 */
class POP3 {
  public $Version = '5.2.26';
  public $POP3_PORT = 110;
  public $POP3_TIMEOUT = 30;
  public $CRLF = "\r\n";
  public $do_debug = 0;
  public $host;
  public $port;
  public $tval;
  public $username;
  public $password;
  protected $pop_conn;
  protected $connected = false;
  protected $errors = array();
  const CRLF = "\r\n";
  public static function popBeforeSmtp($host, $port = false, $timeout = false, $username = '', $password = '', $debug_level = 0) {
    $pop = new POP3;
    return $pop -> authorise($host, $port, $timeout, $username, $password, $debug_level);
  }
  public function authorise($host, $port = false, $timeout = false, $username = '', $password = '', $debug_level = 0) {
    $this -> host = $host;
    if (false === $port)
      $this -> port = $this -> POP3_PORT;
    else
      $this -> port = (integer)$port;
    if (false === $timeout)
      $this -> tval = $this -> POP3_TIMEOUT;
    else
      $this -> tval = (integer)$timeout;
    $this -> do_debug = $debug_level;
    $this -> username = $username;
    $this -> password = $password;
    $this -> errors = array();
    $result = $this -> connect($this -> host, $this -> port, $this -> tval);
    if ($result) {
      $login_result = $this -> login($this -> username, $this -> password);
      if ($login_result) {
        $this -> disconnect();
        return true;
      }
    }
    $this -> disconnect();
    return false;
  }
  public function connect($host, $port = false, $tval = 30) {
    if ($this -> connected)
      return true;
    set_error_handler(array($this, 'catchWarning'));
    if (false === $port)
      $port = $this -> POP3_PORT;
    $this -> pop_conn = fsockopen($host, $port, $errno, $errstr, $tval);
    restore_error_handler();
    if (false === $this -> pop_conn) {
      $this -> setError(array( 'error' => "Failed to connect to server $host on port $port", 'errno' => $errno, 'errstr' => $errstr));
      return false;
    }
    stream_set_timeout($this -> pop_conn, $tval, 0);
    $pop3_response = $this -> getResponse();
    if ($this -> checkResponse($pop3_response)) {
      $this -> connected = true;
      return true;
    }
    return false;
  }
  public function login($username = '', $password = '') {
    if (!$this -> connected)
      $this -> setError('Not connected to POP3 server');
    if (empty($username))
      $username = $this -> username;
    if (empty($password))
      $password = $this -> password;
    $this -> sendString("USER $username" . self::CRLF);
    $pop3_response = $this -> getResponse();
    if ($this -> checkResponse($pop3_response)) {
      $this -> sendString("PASS $password" . self::CRLF);
      $pop3_response = $this -> getResponse();
      if ($this -> checkResponse($pop3_response))
        return true;
    }
    return false;
  }
  public function disconnect() {
    $this -> sendString('QUIT');
    try {
      @fclose($this -> pop_conn);
    } catch (Exception $e) {};
  }
  protected function getResponse($size = 128) {
    $response = fgets($this -> pop_conn, $size);
    if ($this -> do_debug >= 1)
      echo "Server -> Client: $response";
    return $response;
  }
  protected function sendString($string) {
    if ($this -> pop_conn) {
      if ($this -> do_debug >= 2)
        echo "Client -> Server: $string";
      return fwrite($this -> pop_conn, $string, strlen($string));
    }
    return 0;
  }
  protected function checkResponse($string) {
    if (substr($string, 0, 3) !== '+OK') {
      $this -> setError(
        array(
          'error' => "Server reported an error: $string",
          'errno' => 0,
          'errstr' => ''
        )
      );
      return false;
    } else
      return true;
  }
  protected function setError($error) {
    $this -> errors[] = $error;
    if ($this -> do_debug >= 1) {
      echo '<pre>';
      foreach ($this -> errors as $error) {
        print_r($error);
      }
      echo '</pre>';
    }
  }
  public function getErrors() {
    return $this -> errors;
  }
  protected function catchWarning($errno, $errstr, $errfile, $errline) {
    $this -> setError(
      array(
        'error' => "Connecting to the POP3 server raised a PHP warning: ",
        'errno' => $errno,
        'errstr' => $errstr,
        'errfile' => $errfile,
        'errline' => $errline
      )
    );
  }
}
