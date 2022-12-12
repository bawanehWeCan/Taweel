<?php

namespace App\Traits;

trait ResponseTrait
{
    public $success = 200;
    public $created = 201;
    public $accepted = 202;
    public $noContent = 204;
    public $notUpdated = 304;
    public $badRequest = 400;
    public $unauthorized = 401;
    public $invalid = 422;
    public $forBidden = 403;
    public $notFound = 404;
    public $exceptionCode = 500;
    public $serviceUnavailable = 503 ;

    public function getCurrentLang()
    {
        return app()->getLocale();
    }

    public function returnError($code, $msg)
    {
        return response()->json([
            'status' => false,
            'code' => $code,
            'msg' => $msg,
        ], $code);
    }

    public function returnSuccessMessage($code, $msg = '')
    {
        return response()->json([
            'status' => true,
            'code' => $code,
            'msg' => $msg,
        ], $code);
    }

    public function returnData($code, $key, $value, $msg = '')
    {
        return response()->json([
            'status' => true,
            'code' => $code,
            'msg' => $msg,
            $key => $value,
        ], $code);
    }

    //////////////////
    public function returnValidationError($validator, $code = null)
    {
        if ($code == null) {
            $code = $this->returnCodeAccordingToInput($validator);
        }

        return response()->json([
            'status' => false,
            'errNum' => $code,
            'msg' => __('Please check the following errors'),
            'errors' => $validator->errors()->messages(),
        ], $this->invalid);
    }

    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCodeValidation($inputs[0]);

        return $code;
    }

    public function getErrorCodeValidation($input)
    {
        if ($input == 'name') {
            return 001;
        } elseif ($input == 'password') {
            return 002;
        } elseif ($input == 'mobile') {
            return 003;
        } elseif ($input == 'id_number') {
            return 004;
        } elseif ($input == 'birth_date') {
            return 005;
        } elseif ($input == 'agreement') {
            return 006;
        } elseif ($input == 'email') {
            return 007;
        } elseif ($input == 'activation_code') {
            return 010;
        } elseif ($input == 'longitude') {
            return 011;
        } elseif ($input == 'latitude') {
            return 012;
        } elseif ($input == 'id') {
            return 013;
        } elseif ($input == 'promocode') {
            return 014;
        } elseif ($input == 'doctor_id') {
            return 015;
        } elseif ($input == 'payment_method' || $input == 'payment_method_id') {
            return 016;
        } elseif ($input == 'day_date') {
            return 017;
        } elseif ($input == 'type') {
            return 020;
        } elseif ($input == 'message') {
            return 021;
        } elseif ($input == 'reservation_no') {
            return 022;
        } elseif ($input == 'reason') {
            return 023;
        } elseif ($input == 'branch_no') {
            return 024;
        } elseif ($input == 'name_en') {
            return 025;
        } elseif ($input == 'name_ar') {
            return 026;
        } elseif ($input == 'gender') {
            return 027;
        } elseif ($input == 'rate') {
            return 030;
        } elseif ($input == 'price') {
            return 031;
        } elseif ($input == 'information_en') {
            return 032;
        } elseif ($input == 'information_ar') {
            return 033;
        } elseif ($input == 'street') {
            return 034;
        } elseif ($input == 'branch_id') {
            return 035;
        } elseif ($input == 'insurance_companies') {
            return 036;
        } elseif ($input == 'photo') {
            return 037;
        } elseif ($input == 'insurance_companies') {
            return 040;
        } elseif ($input == 'reservation_period') {
            return 041;
        } elseif ($input == 'nationality_id') {
            return 042;
        } elseif ($input == 'commercial_no') {
            return 043;
        } elseif ($input == 'nickname_id') {
            return 044;
        } elseif ($input == 'reservation_id') {
            return 045;
        } elseif ($input == 'attachments') {
            return 046;
        } elseif ($input == 'summary') {
            return 047;
        } elseif ($input == 'paid') {
            return 050;
        } elseif ($input == 'use_insurance') {
            return 051;
        } elseif ($input == 'doctor_rate') {
            return 052;
        } elseif ($input == 'provider_rate') {
            return 053;
        } elseif ($input == 'message_id') {
            return 054;
        } elseif ($input == 'hide') {
            return 055;
        } elseif ($input == 'checkoutId') {
            return 056;
        } else {
            return 422;
        }
    }
}
