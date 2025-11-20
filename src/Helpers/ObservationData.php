<?php

namespace mmerlijn\msgRepo\Helpers;

use mmerlijn\msgRepo\Address;
use mmerlijn\msgRepo\Enums\ObservationTestCodeEnum;
use mmerlijn\msgRepo\Msg;
use mmerlijn\msgRepo\Observation;
use mmerlijn\msgRepo\TestCode;

class ObservationData
{
    public static function get(Msg $msg, ObservationTestCodeEnum $code):string|Address
    {
        $obs = $msg->order->getObservationByTestcode($code->value);
        if($code == ObservationTestCodeEnum::HOME_VISIT_ADDRESS && $obs?->value) {
            return self::stringToAddress($obs->value);
        }
        return $obs?->value ?? '';
    }

    public static function set(Msg &$msg, ObservationTestCodeEnum $code, Address|string $value, string $source="99zdl"): void
    {
        if ($value instanceof Address) {
            $value = self::addressToString($value);
        }
        $obs = $msg->order->getObservationByTestcode($code->value);
        if ($obs) {
            $obs->value = $value;
        } else {
            $msg->order->addObservation(
                new Observation(
                    value: $value,
                    test: new TestCode(
                        code:$code->value,
                        value:$code->getTestCodeValue(),
                        source:$source
                    )
                )
            );
        }
    }

    private static function addressToString(Address $address):string
    {
        return $address->street.", ".$address->building.", ".$address->postcode.", ".$address->city;
    }
    private static function stringToAddress(string $str):Address
    {
        $parts = explode(",", $str);
        return new Address(
            postcode: trim($parts[2] ?? ''),
            city: trim($parts[3] ?? ''),
            street: trim($parts[0] ?? ''),
            building: trim($parts[1] ?? ''),
        );
    }
}