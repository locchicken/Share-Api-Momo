<?php
set_time_limit(0);
date_default_timezone_set('Asia/Ho_Chi_Minh');
$Momo = new Momo;
//echo $Momo->generateImei();die;
$imei = '';
$Momo->phone = ''; 
$Momo->pass  = '';
//echo $Momo->regNewDevice($imei);die;
//nhớ code otp
$code = '7918';
//print_r($Momo -> verifyDevice($imei, $code)); die;
//lấy phash điền vào userLogin
$lg = json_decode($Momo->userLogin('paste phash vào đây'),true);
print_r($lg);

$json = $Momo->checkHistory(365);
print_r($json);



$thoigian = date("H:i:s d/m/Y");
class Momo
{

    public $phone       = '';
    public $pass        = '';
    // public $SECUREID    = generateRandomString(16); 
    public $AUTH_TOKEN  = null;
    public $apiAction   = [
        "QUERY_TRAN_HIS_MSG"   => "https://owa.momo.vn/api/sync",      // check lịch sử giao dịch
        "M2MU_CONFIRM"         => "https://owa.momo.vn/api/sync",           // chuyển tiền cho user momo
        "M2MU_INIT"            => "https://owa.momo.vn/api/sync",           // tạo phiên chuyển tiền user momo
        "USER_LOGIN_MSG"       => "https://owa.momo.vn/public/login",  // đăng nhập lấy token
        "CHECK_USER_BE_MSG"    => "https://owa.momo.vn/public",        // get dữ liệu user
        "SEND_OTP_MSG"         => "https://owa.momo.vn/public",        // gửi otp đăng nhập thiết bị mới
        "REG_DEVICE_MSG"       => "https://owa.momo.vn/public"         // xác thực otp thiết bị mới
    ];
    private $arr_Prefix = array(
        'CELL' => array(
            '016966' => '03966',
            '0169' => '039',
            '0168' => '038',
            '0167' => '037',
            '0166' => '036',
            '0165' => '035',
            '0164' => '034',
            '0163' => '033',
            '0162' => '032',
            '0120' => '070',
            '0121' => '079',
            '0122' => '077',
            '0126' => '076',
            '0128' => '078',
            '0123' => '083',
            '0124' => '084',
            '0125' => '085',
            '0127' => '081',
            '0129' => '082',
            '01992' => '059',
            '01993' => '059',
            '01998' => '059',
            '01999' => '059',
            '0186' => '056',
            '0188' => '058'
        ),
        'HOME' => array(
            '076' => '0296',
            '064' => '0254',
            '0281' => '0209',
            '0240' => '0204',
            '0781' => '0291',
            '0241' => '0222',
            '075' => '0275',
            '056' => '0256',
            '0650' => '0274',
            '0651' => '0271',
            '062' => '0252',
            '0780' => '0290',
            '0710' => '0292',
            '026' => '0206',
            '0511' => '0236',
            '0500' => '0262',
            '0501' => '0261',
            '0230' => '0215',
            '061' => '0251',
            '067' => '0277',
            '059' => '0269',
            '0351' => '0226',
            '04' => '024',
            '039' => '0239',
            '0320' => '0220',
            '031' => '0225',
            '0711' => '0293',
            '08' => '028',
            '0321' => '0221',
            '058' => '0258',
            '077' => '0297',
            '060' => '0260',
            '0231' => '0213',
            '063' => '0263',
            '025' => '0205',
            '020' => '0214',
            '072' => '0272',
           '0350' => '0228',
            '038' => '0238',
            '030' => '0229',
            '068' => '0259',
            '057' => '0257',
            '052' => '0232',
            '0510' => '0235',
            '055' => '0255',
            '033' => '0203',
            '053' => '0233',
            '079' => '0299',
            '022' => '0212',
            '066' => '0276',
            '036' => '0227',
            '0280' => '0208',
            '037' => '0237',
            '054' => '0234',
            '073' => '0273',
            '074' => '0294',
            '027' => '0207',
            '070' => '0270',
            '029' => '0216'
        )
    );
    private function sendMoneyInit($receiverNumber, $amount, $name, $comment)
    {
        if ($this->AUTH_TOKEN == NULL) {
            return json_encode([
                "error" => 1,
                "msg"   => "Đăng nhập thất bại"
            ]);
        }
        $action = 'M2MU_INIT';
        $time   = $this->getTimeNow();
        $arrDataPost = array(
            'user'       => $this->phone,
            'msgType'    => $action,
            'cmdId'      => $time . '000000',
            'lang'       => 'vi',
            'channel'    => 'APP',
            'time'       => $time,
            'appVer' => 30262,
            'appCode' => '3.0.26',
            'result'     => true,
            'errorCode'  => 0,
            'errorDesc'  => '',
            'extra'      =>
            array(
                'checkSum' => $this->generateCheckSum($action, $time),
            ),
            'momoMsg' =>
            array(
                '_class'   => 'mservice.backend.entity.msg.M2MUInitMsg',
                'ref'      => '',
                'tranList' =>
                array(
                    0 =>
                    array(
                        '_class'           => 'mservice.backend.entity.msg.TranHisMsg',
                        'tranType'         => 2018,
                        'partnerId'        => $receiverNumber,
                        'originalAmount'   => $amount,
                        'comment'          => $comment,
                        'moneySource'      => 1,
                        'partnerCode'      => 'momo',
                        'partnerName'      => $name,
                        'rowCardId'        => NULL,
                        'serviceMode'      => 'transfer_p2p',
                        'serviceId'        => 'transfer_p2p',
                        'extras'           => '{"vpc_CardType":"SML","vpc_TicketNo":"","receiverMembers":[{"receiverNumber":"' . $receiverNumber . '","receiverName":"' . $name . '","originalAmount":' . $amount . '}],"loanId":0,"contact":{}}',

                    ),
                ),
            ),
        );
        $requestKeyRaw = $this->randomString(32);
        $requestKey = $this->_encodeRSA($requestKeyRaw, $this->REQUEST_ENCRYPT_KEY);
        $rqCheckInit  = $this->curlPost($this->apiAction[$action], $this->_encode(json_encode($arrDataPost), $requestKeyRaw), $action, $requestKey, $this->phone, $this->AUTH_TOKEN);

        $decodeRq = json_decode($this->_decode($rqCheckInit, $requestKeyRaw));
        if (@$decodeRq->result) {
            return json_encode([
                "error"    => 0,
                "id" => $decodeRq->momoMsg->replyMsgs[0]->ID
            ]);
        } else {
            return json_encode([
                "error" => $decodeRq->errorCode,
                "msg"   => $decodeRq->errorDesc
            ]);
        }
    }
    public function sendMoney($receiverNumber, $amount, $name, $comment)
    {
        $de = json_decode($this->sendMoneyInit($receiverNumber, $amount, $name, $comment));
        if ($de->error != 0) {
            return json_encode([
                "error" => 1,
                "msg"   => $de->msg
            ]);
        } else {
            $id = $de->id;
        }
        $action = 'M2MU_CONFIRM';
        $time   = $this->getTimeNow();
        $arrDataPost = array(
            'user' => $this->phone,
            'msgType' => $action,
            'cmdId' => $time . '000000',
            'lang' => 'vi',
            'channel' => 'APP',
            'time' => $time,
            'appVer' => 30262,
            'appCode' => '3.0.26',
            'deviceOS' => 'Ios',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum($action, $time),
            ),
            'momoMsg' =>
            array(
                'ids' =>
                array(
                    0 => $id,
                ),
                'bankInId' => '',
                '_class' => 'mservice.backend.entity.msg.M2MUConfirmMsg',
                'otp' => '',
                'otpBanknet' => '',
                'extras' => '',
            ),
            'pass' => $this->pass,
        );
        $requestKeyRaw = $this->randomString(32);
        $requestKey = $this->_encodeRSA($requestKeyRaw, $this->REQUEST_ENCRYPT_KEY);
        $rqSendMoney  = $this->curlPost($this->apiAction[$action], $this->_encode(json_encode($arrDataPost), $requestKeyRaw), $action, $requestKey, $this->phone, $this->AUTH_TOKEN);
        $decodeRq = json_decode($this->_decode($rqSendMoney, $requestKeyRaw));
        //return json_encode($decodeRq); 
        if (@$decodeRq->result) {
            return json_encode([
                "error"    => 0,
                "msg" => $decodeRq->momoMsg->replyMsgs[0]->tranHisMsg->desc,
                "balance" => $decodeRq->extra->BALANCE,
                "tranid" => $decodeRq->momoMsg->replyMsgs[0]->transId
            ]);
        } else {
            return json_encode([
                "error" => @$decodeRq->errorCode,
                "msg"   => @$decodeRq->errorDesc
            ]);
        }
    }
    public function checkHistory($day)
    {
        if ($this->AUTH_TOKEN == NULL) {
            return json_encode([
                "error" => 1,
                "msg"   => "Đăng nhập thất bại"
            ]);
        }
	      $day = $day.' day ago';
        $action = 'QUERY_TRAN_HIS_MSG';
        $time   = $this->getTimeNow();
        $arrDataPost = array(
            'user'      => (string) $this->phone,
            'msgType'   => $action,
            'cmdId'     => $time.'000000',
            'lang'      => 'vi',
            'channel'   => 'APP',
            'time'      => $time,
            'appVer'    => 30262,
            'appCode'   => '3.0.26',
            'deviceOS'  => 'IOS',
            'result'    => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum($action, $time),
            ),
            'momoMsg' =>
            array(
                '_class'  => 'mservice.backend.entity.msg.QueryTranhisMsg',
                'begin'   => strtotime($day) * 1000,
                'end'     => $time,
            ),
        );

        $requestKeyRaw = $this->randomString(32);
        $requestKey = $this->_encodeRsa($requestKeyRaw, $this->REQUEST_ENCRYPT_KEY);
        $rqSendMoney  = $this->curlPost($this->apiAction[$action], $this->_encode(json_encode($arrDataPost), $requestKeyRaw), $action, $requestKey, $this->phone, $this->AUTH_TOKEN);
        $decodeRq = json_decode($this->_decode($rqSendMoney, $requestKeyRaw));

        if (@$decodeRq->result) {
            return json_encode([
                "error"    => 0,
                "tranList" => @$decodeRq->momoMsg->tranList,
                "finishTime" => @$decodeRq->momoMsg->end
            ]);
        } else {

            if (@$decodeRq->errorCode) {
                return json_encode([
                    "error" => $decodeRq->errorCode,
                    "msg"   => $decodeRq->errorDesc
                ]);
            } else {
                return json_encode([
                    "error" => 1,
                    "msg"   => "momo timeout"
                ]);
            }
        }
    }

    public function userLogin($pHash)
    {
        $action = 'USER_LOGIN_MSG';
        $time   = $this->getTimeNow();
        $arrDataPost = array(
            'user'      => $this->phone,
            'msgType'   => $action,
            'cmdId'     => $time . '000000',
            'lang'      => 'vi',
            'channel'   => 'APP',
            'time'      => $time,
            'appVer'    => 30262,
            'appCode'   => '3.0.26',
            'deviceOS'  => 'Ios',
            'result'    => true,
            'errorCode' => 0,
             "appId" => "vn.momo.platform",
            'errorDesc' => '',
            'extra'     =>
            array(
                'checkSum'  => $this->generateCheckSum($action, $time),
                'pHash'     => $pHash,
                'AAID'      => '',
                'IDFA'      => '',
                'TOKEN'     => '',
                'SIMULATOR' => 'false',
                'SECUREID'  => $this->SECUREID(),
                 "MODELID" => "",
            ),
            'pass'      => $this->pass,
            'momoMsg'   =>
            array(
                '_class'  => 'mservice.backend.entity.msg.LoginMsg',
                'isSetup' => "false",
            ),
        );
        $rqLogin  = $this->curlPost($this->apiAction[$action], json_encode($arrDataPost), $action);
        $decodeRq = json_decode($rqLogin);

        if (@$decodeRq->result) {
            $this->REQUEST_ENCRYPT_KEY = $decodeRq->extra->REQUEST_ENCRYPT_KEY;
            $this->AUTH_TOKEN = $decodeRq->extra->AUTH_TOKEN;
            return json_encode([
                "error"   => 0,
                "REQUEST_ENCRYPT_KEY" => $decodeRq->extra->REQUEST_ENCRYPT_KEY, 
                "balance" => $decodeRq->extra->BALANCE,
                "AUTH_TOKEN" => $decodeRq->extra->AUTH_TOKEN,
                "time"    => $decodeRq->time
            ]);
        } else {
            return json_encode([
                "error" => @$decodeRq->errorCode,
                "msg"   => @$decodeRq->errorDesc
            ]);
        }
    }
    public function regNewDevice($imei)
    {

        $action = 'SEND_OTP_MSG';
        $time   = $this->getTimeNow();
        $arrDataPost = array(
            'user' => $this->phone,
            'msgType' => $action,
            'cmdId' => $time . '000000',
            'lang' => 'vi',
            'channel' => 'APP',
            'time' => $time,
            'appVer' => 30262,
            'appCode' => '3.0.26',
            'appId' => 'vn.momo.platform',
            'deviceOS' => 'Ios',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'extra' =>
            array(
                'action' => 'SEND',
                'rkey' => '12345678901234567890',
                'isVoice' => false,
                'AAID' => '',
                'IDFA' => '',
                'TOKEN' => '',
                'SIMULATOR' => 'false',
                'SECUREID' => $this->SECUREID(),
                "MODELID" => "",
                "REQUIRE_HASH_STRING_OTP" =>"true",
                "checkSum" => ""
            ),
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.RegDeviceMsg',
                'number' => $this->phone,
                'imei' => $imei,
                'cname' => 'Vietnam',
                'ccode' => '084',
                'device' => 'dailysieurephuc',
                'firmware' => '19',
                'hardware' => 'vbox86',
                'manufacture' => 'samsung',
                'csp' => '',
                'icc' => '',
                'mcc' => '452',
                'device_os' => 'Ios',
                'secure_id' => $this->SECUREID(),
            ),
        );
        $rqReg  = $this->curlPost($this->apiAction[$action], json_encode($arrDataPost), $action, $this->AUTH_TOKEN);
        $decodeRq = json_decode($rqReg);
        if (@$decodeRq->result) {
            return json_encode([
                "error"    => 0,
                "msg"      => 'Thành công'
            ]);
        } else {

            return json_encode([
                "error" => $decodeRq->errorCode,
                "msg"   => $decodeRq->errorDesc
            ]);
        }
    }
    public function verifyDevice($imei, $code)
    {
        $oHash = hash('sha256', $this->phone . '12345678901234567890' . $code);
        $action = 'REG_DEVICE_MSG';
        $time   = $this->getTimeNow();
        $arrDataPost = array(
            'user' => $this->phone,
            'msgType' => $action,
            'cmdId' => $time . '000000',
            'lang' => 'vi',
            'channel' => 'APP',
            'time' => $time,
            'appVer' => 30262,
            'appCode' => '3.0.26',
            'deviceOS' => 'Ios',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            "appId" => "vn.momo.platform",
            'extra' =>
            array(
                'ohash' => $oHash,
                'AAID' => '',
                'IDFA' => '',
                'TOKEN' => '',
                'SIMULATOR' => 'false',
                'SECUREID' => $this->SECUREID(),
                "MODELID" =>"",
                "checkSum" => ""
            ),
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.RegDeviceMsg',
                'number' => $this->phone,
                'imei' => $imei,
                'cname' => 'Vietnam',
                'ccode' => '084',
                'device' => 'dailysieurephuc',
                'firmware' => '19',
                'hardware' => 'vbox86',
                'manufacture' => 'samsung',
                'csp' => '',
                'icc' => '',
                'mcc' => '452',
                'device_os' => 'Ios',
                'secure_id' => $this->SECUREID(),
            ),
        );
        $rqVer  = $this->curlPost($this->apiAction[$action], json_encode($arrDataPost), $action, $this->AUTH_TOKEN);
        $decodeRq = json_decode($rqVer);
        if (@$decodeRq->result) {
            $keySetup = $decodeRq->extra->setupKey;
            $key      = substr(@openssl_decrypt($keySetup, 'AES-256-CBC', substr($oHash, 0, 32), 0, ''), 0, 32);
            file_put_contents('key', $key);
            $pHash    = @openssl_encrypt($imei . '|' . $this->pass, 'AES-256-CBC', $key, 0, '');
            return json_encode([
                "error" => 0,
                "pHash" => $pHash
            ]);
        } else {
            
            return json_encode([
                "error" => $decodeRq->errorCode,
                "msg"   => $decodeRq->errorDesc
            ]);
        }
    }
    public function checkPhone()
    {
        $action = 'USER_LOGIN_MSG';
        $time   = $this->getTimeNow();
        $arrDataPost = array(
            'user' => $this->phone,
            'msgType' => 'CHECK_USER_BE_MSG',
            'cmdId' => $time . '000000',
            'lang' => 'vi',
            'channel' => 'APP',
            'time' => $time,
            'appVer' => 30262,
            'appCode' => '3.0.26',
            'deviceOS' => 'ANDROID',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'extra' =>
            array(
                'checkSum' => '',
            ),
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.RegDeviceMsg',
                'number' => $this->phone,
                'imei' => '',
                'cname' => 'Vietnam',
                'ccode' => '084',
                'device' => 'dailysieurephuc',
                'firmware' => '19',
                'hardware' => 'vbox86',
                'manufacture' => 'samsung',
                'csp' => '',
                'icc' => '',
                'mcc' => '',
                'device_os' => 'Ios',
                'secure_id' => $this->SECUREID(),
            ),
        );

        $rqCheck  = $this->curlPost($this->apiAction[$action], json_encode($arrDataPost), $action);
        $decodeRq = json_decode($rqCheck);
        if (@$decodeRq->result) {
            return  json_encode([
                "error"   => 0,
                "msg"    => $decodeRq->extra->NAME,
            ]);
        } else {
            return  json_encode([
                "error"   => 1,
                "msg"    => "Số điện thoại chưa đăng ký momo",
            ]);
        }
    }
    function convert($phonenumber)
    {
        if (!empty($phonenumber)) {
            //1. Xóa ký tự trắng
            $phonenumber = str_replace(' ', '', $phonenumber);
            //2. Xóa các dấu chấm phân cách
            $phonenumber = str_replace('.', '', $phonenumber);
            //3. Xóa các dấu gạch nối phân cách
            $phonenumber = str_replace('-', '', $phonenumber);
            //4. Xóa dấu mở ngoặc đơn
            $phonenumber = str_replace('(', '', $phonenumber);
            //5. Xóa dấu đóng ngoặc đơn
            $phonenumber = str_replace(')', '', $phonenumber);
            //6. Xóa dấu +
            $phonenumber = str_replace('+', '', $phonenumber);
            //7. Chuyển 84 đầu thành 0
            if (substr($phonenumber, 0, 2) == '84') {
                $phonenumber = '0' . substr($phonenumber, 2, strlen($phonenumber) - 2);
            }
            $dathaythe = false;
            foreach ($this->arr_Prefix['HOME'] as $key => $value) {
                //$prefixlen=strlen($key);
                if (strpos($phonenumber, $key) === 0) {
                    $prefix = $key;
                    $prefixlen = strlen($key);
                    $phone = substr($phonenumber, $prefixlen, strlen($phonenumber) - $prefixlen);
                    $prefix = str_replace($key, $value, $prefix);
                    $phonenumber = $prefix . $phone;
                    //$phonenumber=str_replace($key,$value,$phonenumber);
                    $dathaythe = true;
                    break;
                }
            }



            if ($dathaythe == false) {
                foreach ($this->arr_Prefix['CELL'] as $key => $value) {
                    //$prefixlen=strlen($key);
                    if (strpos($phonenumber, $key) === 0) {
                        $prefix = $key;
                        $prefixlen = strlen($key);
                        $phone = substr($phonenumber, $prefixlen, strlen($phonenumber) - $prefixlen);
                        $prefix = str_replace($key, $value, $prefix);
                        $phonenumber = $prefix . $phone;
                        //$phonenumber=str_replace($key,$value,$phonenumber);
                        $dathaythe = true;
                        break;
                    }
                }
            }

            return $phonenumber;
        } else {
            return false;
        }
    }
    // tạo chuỗi checksum
    public function generateCheckSum($msgType, $time)
    {
        $l = $time . '000000';
        $f = $this->phone . $l . $msgType . ($time / 1e12) . "E12";
        return @openssl_encrypt($f, 'AES-256-CBC',  substr(file_get_contents('key'), 0, 32), 0, '');
    }
    public function _encode($plaintext, $password)
    {
        $method = 'aes-256-cbc';
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $encrypted = base64_encode(openssl_encrypt($plaintext, $method, $password, OPENSSL_RAW_DATA, $iv));
        return $encrypted;
    }

    public function _decode($encrypted, $password)
    {
        $method = 'aes-256-cbc';
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $decrypted = openssl_decrypt(base64_decode($encrypted), $method, $password, OPENSSL_RAW_DATA, $iv);
        return $decrypted;
    }

    public function _encodeRSA($content, $key)
    {

        require_once('lib/RSA/Crypt/RSA.php');
        $rsa = new Crypt_RSA();
        $rsa->loadKey($key);
        $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
        return base64_encode($rsa->encrypt($content));
    }

    public function randomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // tạo chuỗi ngẫu nhiên
    private function generateRandomString($length = 20)
    {
        $characters = '0123456789abcde';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function SECUREID($length = 17)
    {
        $characters = '0123456789abcde';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    

    private function genagent(){
      return $this->randint().$this->randint().$this->randint().$this->randint().$this->randint().$this->randint().$this->randint().$this->randint();
    }
    
    private function randint(){
      return rand(0,9);
    }
    

    public function generateImei()
    {
        return $this->generateRandomString(8) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(12);
    }
    
    private function curlPost($api, $dataPost, $MsgType, $requestKey = null, $phone = null, $Auth = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        #curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataPost);
        curl_setopt($ch,CURLOPT_ENCODING        , "");
			curl_setopt($ch,CURLOPT_MAXREDIRS      ,10);
			curl_setopt($ch,CURLOPT_TIMEOUT        , 30);
			curl_setopt($ch,CURLOPT_HTTP_VERSION   ,CURL_HTTP_VERSION_1_1);

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = ($Auth == false) ? 'Authorization: Bearer' : 'Authorization: Bearer ' . $Auth;
        $headers[] = 'agent_id:'.$this->genagent();
        $headers[] = 'Msgtype: ' . $MsgType;
        $headers[] = 'app_version:30262';
        $headers[] = 'app_code:3.0.26';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Connection: Keep-Alive';
        $headers[] = 'User-agent:MoMoApp-Release/%s CFNetwork/978.0.7 Darwin/18.6.0",MoMoApp-Release/%s CFNetwork/978.0.7 Darwin/18.6.0';
        $headers[] = 'Host: owa.momo.vn';
        $headers[] = 'device_os:IOS';
        $headers[] = 'lang:vi';
        if ($requestKey != null) {
            $headers[] = 'requestkey: ' . $requestKey;
        }
        if ($phone != null) {
            $headers[] = 'userid: ' . $phone;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    public function curlGet($api)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    public function getTimeNow()
    {
   
        $pieces = explode(" ", microtime());
        return bcadd(($pieces[0] * 1000), bcmul($pieces[1], 1000));
    }
    
    public function get_link($receiverLinkType = 'default',$money = 0){
		$time   = $this->getTimeNow();
		$type           = 'CREATE_MONEY_RECEIVE_LINK';
		$data_body = [
			'user'      => $this->phone,
			'pass'      => $this->pass,
			'msgType'   => $type,
			'cmdId'     => $time. '000000',
			'lang'      => 'vi',
			'channel'   => 'APP',
			'time'      => $time,
			'appVer'    => 30262,
			'appCode'   => '3.0.26',
			'deviceOS'  => 'IOS',
			'result'    => true,
			'errorCode' => 0,
			'errorDesc' => '',
			'extra'     => [
				'checkSum'          => $this->generateCheckSum($type,$time),
			],
			'momoMsg'   => [
				'_class'            => 'mservice.backend.entity.msg.ForwardMsg',
				'receiverLinkType'  => $receiverLinkType, // default - andanh
				'amount'            => $money
			]
		];
		$requestKeyRaw = $this->randomString(32);

        $requestKey = $this->_encodeRSA($requestKeyRaw, $this->REQUEST_ENCRYPT_KEY);

        $rqSendMoney  = $this->curlPost("https://owa.momo.vn/api/CREATE_MONEY_RECEIVE_LINK", $this->_encode(json_encode($data_body), $requestKeyRaw), $type, $requestKey, $this->phone, $this->AUTH_TOKEN);
        $decodeRq = json_decode($this->_decode($rqSendMoney, $requestKeyRaw));
        return $decodeRq;
    }     
}
function generateRandomString($length = 20)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

