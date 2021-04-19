<?php

function stringTo($tipe, $value)
{
    switch ($tipe) {
        case 'integer':
            return intval($value);
        case 'boolean':
            return boolval($value);
        case 'double':
            return floatval($value);
        case 'float':
            return floatval($value);
        case 'array':
            return explode('|', $value);
        case 'object':
            return json_decode($value);
        default:
            return $value;
            break;
    }
}

function toString($tipe, $value)
{
    switch ($tipe) {
        case 'integer':
            return strval($value);
        case 'boolean':
            return strval($value);
        case 'double':
            return strval($value);
        case 'float':
            return strval($value);
        case 'array':
            return implode('|', $value);
        case 'object':
            return json_encode($value);
        default:
            return $value;
            break;
    }
}

function stringConvert($data, $stringto = true)
{

    if ($stringto) {
        foreach ($data as $key => $v) {
            $data[$key]->values = stringTo($v->type, $v->values);
        }
    } else {
        foreach ($data as $key => $v) {
            $data[$key]->values = toString($v->type, $v->values);
        }
    }

    return $data;
}

function toArrayConfig($array)
{
    $arrayConfig = [];
    foreach ($array as $item) {
        $arrayConfig[$item->name] = $item->values;
    }

    return $arrayConfig;
}
