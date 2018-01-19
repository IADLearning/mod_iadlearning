<?php
// This file is part of iadlearning Moodle Plugin - http://www.iadlearning.com/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Http requests handling library
 *
 * @package     mod_iadlearning
 * @copyright   www.itoptraining.com
 * @author      jose.omedes@itoptraining.com
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @date        2017-01-26
 */

defined('MOODLE_INTERNAL') || die();

class iad_http {

    public function __construct($protocol, $url, $port) {

        $this->protocol = $protocol;
        $this->url = $url;
        $this->port = $port;

    }


    public function iad_http_get($apicall, $querystring = null) {

        $finalurl = $this->protocol . $this->url . ":" . $this->port . $apicall;
        if ($querystring) {
            $finalurl = $finalurl . '?' . $querystring;
        }
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $finalurl );
            curl_setopt($ch, CURLOPT_VERBOSE, 1 );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if (!$response = curl_exec($ch)) {
                trigger_error(curl_error($ch));
            }
            $responsecode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            curl_close($ch);
            return array($responsecode, $response);
        } catch (Exception $e) {
            $errorexecption = $e->getMessage();
            $errormsg = get_string('error_in_service', 'iad'). " " . $errorexecption;
            print_error($errormsg);
        }

    }



    public function iad_http_post($apicall, $fields = null, $querystring = null) {

        $finalurl = $this->protocol . $this->url . ":" . $this->port . $apicall;
        if ($querystring) {
            $finalurl = $finalurl . '?' . $querystring;
        }
        $data = json_encode($fields);

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $finalurl );
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_VERBOSE, 1 );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            if (!$response = curl_exec($ch)) {
                trigger_error(curl_error($ch));
            }
            $responsecode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            curl_close($ch);
            return array($responsecode, $response);
        } catch (Exception $e) {
            $errorexecption = $e->getMessage();
            $errormsg = get_string('error_in_service', 'iad'). " " . $errorexecption;
            print_error($errormsg);
        }

    }



}

