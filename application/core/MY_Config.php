<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Nab Config Class
 *
 * @package        Nab
 * @subpackage    Core Library
 * @category    Config
 * @author        Misael Zapata
 * @link        http://misaelzapata.com
 */
class MY_Config extends CI_Config
{

    public $config_path   = ''; // Set in the constructor below
    public $database_path = ''; // Set in the constructor below
    public $index_path    = ''; // Set in the constructor below
    public $autoload_path = ''; // Set in the constructor below

    /**
     * Constructor
     *
     * @access    public
     * @return    void
     */
    public function __construct()
    {
        parent::__construct();

        $this->config_path   = APPPATH . 'config/config' . EXT;
        $this->database_path = APPPATH . 'config/database' . EXT;
        $this->autoload_path = APPPATH . 'config/autoload' . EXT;
        $tem_index           = getcwd();
        $this->index_path    = $tem_index . "/index.php";
    }

    // --------------------------------------------------------------------

    /**
     * Update the config file
     *
     * Reads the existing config file as a string and swaps out
     * any values passed to the function.  Will alternately remove values
     *
     *
     * @access    public
     * @param    array
     * @param    array
     * @return    bool
     */
    public function config_update($config_array = array())
    {
        if (!is_array($config_array) && calculate($config_array) == 0) {
            return false;
        }

        @chmod($this->config_path, FILE_WRITE_MODE);

        // Is the config file writable?
        if (!is_really_writable($this->config_path)) {
            show_error($this->config_path . ' does not appear to have the proper file permissions.  Please make the file writeable.');
        }

        // Read the config file as PHP
        require $this->config_path;

        // load the file helper
        $this->CI = &get_instance();
        $this->CI->load->helper('file');

        // Read the config data as a string
        $config_file = read_file($this->config_path);

        // Trim it
        $config_file = trim($config_file);

        // Do we need to add totally new items to the config file?
        if (is_array($config_array)) {
            foreach ($config_array as $key => $val) {
                $pattern = '/\$config\[\\\'' . $key . '\\\'\]\s+=\s+[^\;]+/';

                if (gettype($val) == 'string') {
                    $replace = "\$config['$key'] = '$val'";
                } elseif (gettype($val) == 'boolean') {
                    if ($val) {
                        $val = 'TRUE';
                    } else {
                        $val = 'FALSE';
                    }
                    $replace = "\$config['$key'] = $val";
                } else {
                    $replace = "\$config['$key'] = $val";
                }

                $config_file = preg_replace($pattern, $replace, $config_file);
            }
        }

        if (!$fp = fopen($this->config_path, FOPEN_WRITE_CREATE_DESTRUCTIVE)) {
            return false;
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $config_file, strlen($config_file));
        flock($fp, LOCK_UN);
        fclose($fp);

        @chmod($this->config_path, FILE_READ_MODE);

        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Update Database Config File
     *
     * Reads the existing DB config file as a string and swaps out
     * any values passed to the function.
     *
     * @access    public
     * @param    array
     * @param    array
     * @return    bool
     */
    public function db_config_update($dbconfig = array(), $remove_values = array())
    {
        @chmod($this->database_path, FILE_WRITE_MODE);

        // Is the database file writable?
        if (!is_really_writable($this->database_path)) {
            show_error($this->database_path . ' does not appear to have the proper file permissions.  Please make the file writeable.');
        }

        // load the file helper
        $this->CI = &get_instance();
        $this->CI->load->helper('file');

        // Read the config file as PHP
        require $this->database_path;

        // Now we read the file data as a string
        $config_file = read_file($this->database_path);

        if (calculate($dbconfig) > 0) {
            foreach ($dbconfig as $key => $val) {
                $val         = str_replace("'", "\'", $val);
                $pattern     = '/\$db\[\\\'' . $active_group . '\\\'\]\[\\\'' . $key . '\\\'\]\s+=\s+[^\;]+/';
                $replace     = "\$db['$active_group']['$key'] = '$val'";
                $config_file = preg_replace($pattern, $replace, $config_file);
            }
        }

        $config_file = trim($config_file);

        // Write the file
        if (!$fp = fopen($this->database_path, FOPEN_WRITE_CREATE_DESTRUCTIVE)) {
            return false;
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $config_file, strlen($config_file));
        flock($fp, LOCK_UN);
        fclose($fp);

        @chmod($this->database_path, FILE_READ_MODE);

        return true;
    }

    public function db_config_get()
    {
        @chmod($this->database_path, FILE_WRITE_MODE);

        // Is the database file writable?
        if (!is_really_writable($this->database_path)) {
            show_error($this->database_path . ' does not appear to have the proper file permissions.  Please make the file writeable.');
        }

        // load the file helper
        $this->CI = &get_instance();
        $this->CI->load->helper('file');

        // Read the config file as PHP
        require $this->database_path;

        $array = array();
        $file  = $this->database_path;
        $items = array(
            '[\'hostname\']',
            '[\"hostname\"]',
            '[\'username\']',
            '[\"username\"]',
            '[\'password\']',
            '[\"password\"]',
            '[\'database\']',
            '[\"database\"]',
        );

        $contents = file_get_contents($file);

        foreach ($items as $item) {
            $pattern = preg_quote($item, '/');
            $pattern = "/^.*$pattern.*\$/m";
            if (preg_match_all($pattern, $contents, $matche)) {
                foreach ($matche as $matcheAllDataKey => $matcheAllData) {
                    foreach ($matcheAllData as $matcheAllDataKey => $value) {
                        $matche       = trim($value);
                        $matchReplace = str_replace(array(';', ' '), array('', ''), $matche);
                        $expitem      = explode("=", $matchReplace);
                        if (calculate($expitem) >= 2) {
                            $expitemone = str_replace(array("'", '"', '[', ']'), array('', '', '', ''), $item);
                            if ($expitemone == 'password') {
                                $expitemtwo = str_replace("\'", "'", $expitem[1]);
                                $expitemtwo = substr($expitemtwo, 1, -1);
                            } else {
                                $expitemtwo = str_replace(array("'", '"'), array('', ''), $expitem[1]);
                            }
                            $array[$expitemone] = $expitemtwo;
                        }
                    }
                }
            }
        }
        $array['dbdriver'] = 'mysqli';
        $array['db_debug'] = false;
        return $array;
    }

    public function config_status()
    {

        $data['install_warnings'] = array();

        // is PHP version ok?
        if (!is_php('5.1.6')) {
            $data['install_warnings'][] = 'php version is too old';
        }

        // is config file writable?
        if (is_really_writable($this->config_path) && !@chmod($this->config_path, FILE_WRITE_MODE)) {
            $data['install_warnings'][] = 'config.php file is not writable';
        }

        // Is there a database.php file?
        if (@include ($this->database_path)) {
            if ($this->test_mysql_connection($db[$active_group])) {
                $this->session->set_userdata('user_database_file', true);
            } else {
                // Ensure the session isn't remembered from a previous test
                $this->session->set_userdata('user_database_file', false);

                @chmod($this->config->database_path, FILE_WRITE_MODE);

                if (is_really_writable($this->config->database_path) === false) {
                    $vars['install_warnings'][] = 'database file is not writable';
                }
            }
        } else {
            $data['install_warnings'][] = 'database config file was not found';
        }

        return $data;
    }

    public function config_install()
    {
        $newAR = array();
        $file  = fopen($this->config_path, "r");
        $i     = 0;
        $newAR = true;
        while (!feof($file)) {
            $string      = preg_replace('/\s+/', '', fgets($file));
            $mypattern[] = '$config[\'installed\']=FALSE;';
            $mypattern[] = '$config[\'installed\']=False;';
            $mypattern[] = '$config[\'installed\']=false;';
            $mypattern[] = '$config[\'installed\']=0;';

            foreach ($mypattern as $pattern) {
                if ($pattern == $string) {
                    $newAR = false;
                }
            }

        }
        fclose($file);
        return $newAR;
    }
}
