<?php
defined('BASEPATH') or exit('No direct script access allowed');

@ini_set('memory_limit', '128M');
@ini_set('max_execution_time', 240);

class Auto_update extends Admin_Controller
{
    private $tmp_update_dir;
    private $tmp_dir;
    private $purchase_code;
    private $envato_username;
    private $latest_version;

    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
    }


    public function index()
    {
        $this->purchase_code = $this->input->post('purchase_key', false);
        $this->envato_username = $this->input->post('buyer', false);
        $this->latest_version = $this->input->post('latest_version', false);

        $tmp_dir = @ini_get('upload_tmp_dir');
        if (!$tmp_dir) {
            $tmp_dir = @sys_get_temp_dir();
            if (!$tmp_dir) {
                $tmp_dir = FCPATH . 'temp';
            }
        }
        $tmp_dir = rtrim($tmp_dir, '/') . '/';
        if (!is_writable($tmp_dir)) {
            header('HTTP/1.0 400');
            echo "Temporary directory not writable - <b>$tmp_dir</b><br />Please contact your hosting provider make this directory writable. The directory needs to be writable for the update files.";
            exit();
        }

        $this->tmp_dir = $tmp_dir;
        $tmp_dir = $tmp_dir . 'v' . $this->latest_version . '/';
        $this->tmp_update_dir = $tmp_dir;

        if (!is_dir($tmp_dir)) {
            mkdir($tmp_dir);
            fopen($tmp_dir . 'index.html', 'w');
        }
        $zipFile = $tmp_dir . $this->latest_version . '.zip'; // Local Zip File Path
        $zipResource = fopen($zipFile, "w+");
        $this->load->library('user_agent');
        // Get The Zip File From Server
        $url = UPDATE_URL . 'api/update_version';
        $curl_handle = curl_init();

        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, get_instance()->agent->agent_string());
        curl_setopt($curl_handle, CURLOPT_FAILONERROR, true);
        curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl_handle, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl_handle, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, 300);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_handle, CURLOPT_FILE, $zipResource);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
            'envato_username' => $this->envato_username,
            'purchase_code' => $this->purchase_code,
            'item_id' => '16292398',
            'ip_address' => isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : $_SERVER["HTTP_HOST"],
            'url' => base_url(), // please do not change the URL this is mandatory to setup the software
        ));
        $success = curl_exec($curl_handle);
        if (!$success) {
            $this->clean_tmp_files();
            header('HTTP/1.0 400 Bad error');
            $error = $this->getErrorByStatusCode(curl_getinfo($curl_handle, CURLINFO_HTTP_CODE));
            if ($error == '') {
                // Uknown error
                $error = curl_error($curl_handle);
            }
            echo $error;
            die;
        }
        curl_close($curl_handle);
        $zip = new ZipArchive;
        if ($zip->open($zipFile) === true) {
            if (!$zip->extractTo('./')) {
                header('HTTP/1.0 400 Bad error');
                $upgradeCopyLocation = $this->copyUpgrade($zipFile);
                $message = 'Failed to extract downloaded zip file';
                if ($upgradeCopyLocation) {
                    $message .= '<hr /><p>The update files are copied to <b>' . $upgradeCopyLocation . '</b> so you can try to <b>extract them manually</b> e.q. via cPanel or command line, use the best method that is suitable for you. <br /><br /><b>Don\'t forget that you must extract the contents of the ' . basename($upgradeCopyLocation) . ' file in ' . FCPATH . '</b> <br/> <br/> after that please remove after extract the files from ' . $upgradeCopyLocation . '</p>';
                }
                echo $message;
                $zip->close();
                die;
            }
            $zip->close();
        } else {
            header('HTTP/1.0 400 Bad error');
            echo 'Failed to open downloaded zip file';
            exit();
        }
        $this->clean_tmp_files();
    }

    protected function copyUpgrade($zipFile)
    {
        if (!file_exists($zipFile)) {
            return false;
        }

        $copyFileLocation = FCPATH . 'temp/' . time() . '-upgrade-version-' . basename($zipFile);
        $upgradeCopied = false;

        if (@copy($zipFile, $copyFileLocation)) {

            // Delete old upgrade stored data
            $oldUpgradeData = $this->get_last_upgrade_copy_data();

            if ($oldUpgradeData) {
                @unlink($oldUpgradeData->path);
            }

            $optionData = ['path' => $copyFileLocation, 'version' => $this->latest_version, 'time' => time()];
            $data = array('value' => json_encode($optionData));
            $this->db->where('config_key', 'last_update_data')->update('tbl_config', $data);
            $exists = $this->db->where('config_key', 'last_update_data')->get('tbl_config');
            if ($exists->num_rows() == 0) {
                $this->db->insert('tbl_config', array("config_key" => 'last_update_data', "value" => json_encode($optionData)));
            }
            $upgradeCopied = true;
        }

        return $upgradeCopied ? $copyFileLocation : false;
    }

    function get_last_upgrade_copy_data()
    {
        $lastUpgradeCopyData = config_item('last_update_data');
        if ($lastUpgradeCopyData !== '') {
            $lastUpgradeCopyData = json_decode($lastUpgradeCopyData);

            return is_object($lastUpgradeCopyData) ? $lastUpgradeCopyData : false;
        }

        return false;
    }


    public
    function database()
    {
        $db_update = $this->admin_model->upgrade_database_silent();
        if ($db_update['success'] == false) {
            header('HTTP/1.0 400 Bad error');
            echo json_encode(array(
                $db_update['message']
            ));
            exit();
        }
        echo '<div class="bold">
            <h4 class="bold">Hi! Thanks for updating Ultimate Project Manager CRM PRO - You are using version ' . config_item('version') . '</h4>
            <p>
                This window will reload automatically in 5 seconds and will try to clear your browser cache, however its recommended to clear your browser cache manually.
            </p>
        </div>';
        set_message('success', lang('using_latest_version'));
        exit();
    }

    private
    function clean_tmp_files()
    {
        if (is_dir($this->tmp_update_dir)) {
            @delete_files($this->tmp_update_dir);
            if (@!delete_dir($this->tmp_update_dir)) {
                @rename($this->tmp_update_dir, $this->tmp_dir . 'delete_this_' . uniqid());
            }
        }
    }

    protected function getErrorByStatusCode($statusCode)
    {
        $error = '';
        if ($statusCode == 499) {
            $mailBody = 'Hello. I tried to upgrade to the latest version but for some reason the upgrade failed. Please remove the key from the upgrade log so i can try again. My installation URL is: ' . base_url() . '. Regards.';

            $mailSubject = 'Purchase code Removal Request - [' . $this->purchase_code . ']';
            $error = 'The Purchase code already used to download upgrade files for version ' . wordwrap($this->latest_version, 1, '.', true) . '. Performing multiple auto updates to the latest version with one/regular version purchase code is not allowed. If you have multiple installations you must buy another license.<br /><br /> If you have staging/testing installation and auto upgrade is performed there, <b>you should perform manually upgrade</b> in your production area<br /><br /> <h4 class="bold">Upgrade failed?</h4> The error can be shown also if the update failed for some reason, but because the purchase code is already used to download the files, you won’t be able to re-download the files again.<br /><br />Click <a href="mailto:uniquecoder007@gmail.com?subject=' . $mailSubject . '&body=' . $mailBody . '"><b>here</b></a> to send an mail and get your purchase code removed from the upgrade log.';
        } elseif ($statusCode == 498) {
            $error = 'Your purchase code is Invalid.Please enter the valid Purchase code.';
        } elseif ($statusCode == 497) {
            $error = 'Your Download Item ID and the software ID does not match.Please download it from your . <a href="https://help.market.envato.com/hc/en-us/articles/202501014-How-To-Download-Your-Items"> download </a> drop-down menu';;
        } elseif ($statusCode == 496) {
            $error = 'Your Purchase code is Empty.';
        } elseif ($statusCode == 495) {
            $error = 'Your envato username does not match the buyer username';
        }
        return $error;
    }

    public function __destruct()
    {
        $this->clean_tmp_files();
    }
}
