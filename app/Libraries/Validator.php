<?php

namespace App\Libraries;

use Request;

class Validator extends \Illuminate\Validation\Validator
{
    public static function validateForm($rules, $custom_rules, &$data) {
        $validator = \Validator::make($data, $rules);

        if ($validator->fails()) {
            $errors = $validator->getMessageBag()->toArray();
        } else {
            $errors = [];
            foreach ($custom_rules as $key => $rules) {
                if (!is_array($rules) || is_callable($rules)) $rules = [$rules];
                foreach ($rules as $rule) {
                    if (!isset($data[$key])) {
                        $data[$key] = null;
                    }
                    $value =& $data[$key];

                    if (is_string($rule) && strpos($rule, '::') === false) {
                        $rule = explode(':', $rule);
                        if (count($rule) == 1) {
                            $parameters = [];
                        } else {
                            $parameters = explode(',', $rule[1]);
                        }
                        $rule = $rule[0];
                    } else {
                        $parameters = [];
                    }

                    $callable = $rule;
                    if (is_string($rule)) {
                        $method = 'filter' . studly_case($rule);
                        if (method_exists(__CLASS__, $method)) {
                            $callable = __CLASS__ . '::' . $method;
                        }
                    }

                    $result = call_user_func_array($callable, [&$value, &$data, $parameters]);
                    if ($result !== true && $result !== null) {
                        if (!is_array($result)) {
                            $result = [$key => $result];
                        }
                        foreach ($result as $k => $v) {
                            $errors[$k][] = $v;
                        }
                        break;
                    }
                }
                if ($errors) {
                    break;
                }
            }
        }

        return $errors;
    }
}
