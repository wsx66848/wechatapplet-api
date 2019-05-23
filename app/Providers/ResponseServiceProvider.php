<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * Class: ResponseServiceProvider
 *
 * @see ServiceProvider
 * @author also
 */
class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(ResponseFactory $response) {
        $handleFormRequest = function ($rules, $customRules = [], $handler = null) {
            if (is_callable($rules)) {
                $handler = $rules;
                $rules = [];
            } elseif (is_callable($customRules)) {
                $handler = $customRules;
                $customRules = [];
            }

            $data = \Request::all();
            $errors = \App\Libraries\Validator::validateForm($rules, $customRules, $data);

            $return = ['success' => true, 'data' => ''];
            if ($errors) {
                $return = [
                    'success' => false,
                    'errors' => $errors,
                ];
            } else if ($handler) {
                $result = $handler($data);
                if ($result === false) {
                    $return = [
                        'success' => false,
                        'errors' => '操作失败'
                    ];
                } else if ($result instanceof \Illuminate\Support\MessageBag) {
                    $return = [
                        'success' => false,
                        'errors' => $result->toArray()
                    ];
                } else if (is_array($result)) {
                    if (isset($result['success'])) {
                        $success = $result['success'];
                        unset($result['success']);
                        if (count($result) == 1) {
                            $result = array_values($result)[0];
                        }
                        $return = [
                            'success' => $success ? true : false,
                        ];
                        if(!$success) {
                            $return['errors'] = $result;
                        } else {
                            $return['data'] = $result;
                        }
                    } else {
                        $return = [
                            'success' => true,
                            'data' => $result,
                        ];
                    }
                } else {
                    $return = [
                        'success' => true,
                        'data' => $result,
                    ];
                }
            }

            return \Response::json($return);
        };

        $response->macro('api', $handleFormRequest);

        $response->macro('apiWithTransaction',
            function ($rules, $customRules, $handler = null) use ($handleFormRequest) {
                if (is_callable($rules)) {
                    $handler = $rules;
                    $rules = [];
                } elseif (is_callable($customRules)) {
                    $handler = $customRules;
                    $customRules = [];
                }

                if ($handler !== null) {
                    $handler = function () use ($handler) {
                        DB::beginTransaction();
                        try {
                            $result = call_user_func_array($handler, func_get_args());
                        } catch (\Exception $e) {
                            DB::rollback();
                            throw $e;
                        }
                        if ($result === true || !empty($result['success'])) {
                            DB::commit();
                        } else {
                            DB::rollback();
                        }
                        return $result;
                    };
                }

                return $handleFormRequest($rules, $customRules, $handler);

            }
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
