<?php

namespace App\Services\Sms;

use App\Models\User;
use Cryptommer\Smsir\Classes\Smsir;
use Cryptommer\Smsir\Objects\Parameters;

class Sms
{
    public static function send(User $user, int $templateID, int $opt)
    {
        $sms = new Smsir('30007732904890', 'o1CBXJmlwHZQv5cZth9noWyu63j6hdUdGHDGUhy5NcgRQTBeEjlfebnzAUQu1jre');

        $send = $sms->Send();

        $parameter = new Parameters('Code', $opt);
        $parameters = array($parameter);

        $response = $send->Verify($user->mobile, $templateID, $parameters);

        return $response->getStatus() === '1';
    }
}