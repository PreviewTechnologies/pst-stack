<?php

class App
{

    private static $_instance;

    public static function getInstance()
    {
        if (!is_null(self::$_instance)) {
            return self::$_instance;
        }
        self::$_instance = new self;
        return self::$_instance;
    }

    public static function returnJson($json = array())
    {
        $app = \Slim\Slim::getInstance();
        $http = $app->response();
        $http['Content-Type'] = 'application/json';
        echo $http->write(json_encode($json));
        exit;
    }

    public static function getModule()
    {
        $app = \Slim\Slim::getInstance();
        $path = $app->request()->getPath();
        $pieces = explode('/', $path);
        if (count($pieces) > 0) {
            $last = end($pieces);
            return $last;
        }
        return '';
    }

    public static function getUser()
    {
        if (isset($_SESSION['user']) &&
            $_SESSION['user'] != '' &&
            ($user = UserQuery::create()->findOneByUUID($_SESSION['user']))
        ) {
            return $user;
        }
        return null;
    }

    public static function getProfile()
    {
        if (isset($_SESSION['user']) &&
            $_SESSION['user'] != '' &&
            ($profile = ProfileQuery::create()->findOneByUserID(App::getUserId()))
        ) {
            return $profile;
        }
        return null;
    }

    /**
     * returns the database ID of the User
     * @return int
     */
    public static function getUserId()
    {
        $user = self::getUser();
        return $user ? $user->getId() : null;
    }

    /**
     * returns true if the user is logged in
     * @return bool
     */
    public static function userLoggedIn()
    {
        return self::getUserId() > 0;
    }

    /**
     * returns the remote ip (client ip) of the user
     * @return string
     */
    public static function getRemoteAddress()
    {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return array_pop($ip_list);
        }

        if (isset($_SERVER['REMOTE_IP'])) {
            $ip_list = explode(',', $_SERVER['REMOTE_IP']);
            return array_pop($ip_list);
        }

        if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip_list = explode(',', $_SERVER['REMOTE_ADDR']);
            return array_pop($ip_list);
        }

        return '';
    }

    /* TODO: Implement when timezones are in */
//    public static function getClientDateTime($dateTime='now')
//    {
//        $office = self::getOffice();
//        /* @var $office Office */
//        $serverTimezone = 'UTC';
//        $clientTimezone = '';
//        if ($office) {
//            $clientTimezone = $office->getTimeZone() ? $office->getTimeZone()->getName() : 'America/Phoenix';
//        }
//        if ($clientTimezone == '') $clientTimezone = $serverTimezone;
//        $dte = new DateTime($dateTime, new DateTimeZone($serverTimezone) );
//        $dte->setTimeZone(new DateTimeZone($clientTimezone));
//        return $dte;
//    }

    /**
     * @param String $format
     * @return DateTime|string
     */
    public static function getUserDateTime($format = null)
    {
        return self::getUtcDateTime($format);
    }

    /**
     * returns true if the user is admin
     * @return bool
     */
    public static function getAdmin()
    {
        if (self::userLoggedIn()) {
            $admin = self::getUser();

            return 1 ? $admin->getUserRole() : null;
        }
        return null;
    }

    /**
     * @param String $format
     * @return DateTime|string
     */
    public static function getUtcDateTime($format = null)
    {
        $serverTimezone = 'UTC';
        $dte = new DateTime('now', new DateTimeZone($serverTimezone));
        return null === $format ? $dte : $dte->format($format);
    }

    /**
     * @param null $dir
     * @param null $fileName
     * @param null $data
     * @param bool $keep
     * @return resource
     */
    public static function savePdf($dir = null, $fileName = null, $data = null, $keep = true)
    {
        $tempPdf = fopen($dir . '/' . $fileName, "w");
        fputs($tempPdf, $data);
        fclose($tempPdf);
        if ($keep === false) {
            unlink($tempPdf);
        }
        return $tempPdf;
    }

    /**
     * @return bool true if database user table fully complete for payment
     */

    public static function isFillUpUser()
    {
        ;
        $user = self::getUser();
        if (($user->getEmailAddress() != '') & ($user->getFirstName() != '') & ($user->getLastName() != '')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Description: Checking profiles basic information are completed
     * @return bool
     *
     */
    public static function isFillUpProfile()
    {
        $profile = App::getProfile();
        if (
            ($profile->getCardNumber() != '') &
            ($profile->getCardExpiredDate() != '') &
            ($profile->getBillingZipCode() != '') &
            ($profile->getBillingAddress() != '') &
            ($profile->getBillingState() != '') &
            ($profile->getBillingCountry() != '') &
            ($profile->getZipCode() != '') &
            ($profile->getAddress() != '') &
            ($profile->getCity() != '') &
            ($profile->getState() != '') &
            ($profile->getCountry() != '') &
            ($profile->getGender() != '') &
            ($profile->getPhoneNumber() != '') &
            ($profile->getMobileNumber() != '') &
            ($profile->getFirstSecurityQuestion() != '') &
            ($profile->getFirstSecurityQuestionAnswer() != '') &
            ($profile->getSecondSecurityQuestion() != '') &
            ($profile->getSecondSecurityQuestionAnswer() != '') &
            ($profile->getCustomSecurityQuestion() != '') &
            ($profile->getCustomSecurityAnswer() != '')
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Description: Checking user's payment status
     * @return bool true for having payment information else false
     */
    public static function isPaymentComplete()
    {
        if (self::userLoggedIn()) {
            $userPaymentStatus = PurchasePackageQuery::create()
                ->findOneByUserID(self::getUserId())
                ->getPaymentStatus();

            return ($userPaymentStatus == 0 | $userPaymentStatus == 2) ? true : false;
        }

    }


    /**
     * Description: Is a robot used or not if used return total task and finished task number
     * @param $robotID Int
     * @param $userId Int
     * @return array status 1 is for used and 0 for not used.
     */
    public static function isRobotUsed($robotID, $userId)
    {
        $robotStatus = TasksQuery::create()
            ->filterByRobotID($robotID)
            ->findOneByUserID($userId);

        if($robotStatus != null ) {
            $totalTask =TasksQuery::create()
                ->filterByUserID($userId)
                ->filterByRobotID($robotID)
                ->find()
                ->count();

            $finishedTask =TasksQuery::create()
                ->filterByUserID($userId)
                ->filterByRobotID($robotID)
                ->filterByStatus(1)
                ->find()
                ->count();

            $result = array(
                'totalTask'=>$totalTask,
                'finishedTask'=> $finishedTask,
                'useStatus' => 1
            );

        } else{
            $result = array(
                'totalTask'=> 0,
                'finishedTask'=> 0,
                'useStatus' => 0
            );
        }
        return $result;



    }

}