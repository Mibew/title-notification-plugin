<?php
/*
 * This file is a part of Mibew Title Notification Plugin.
 *
 * Copyright 2014 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * @file The main file of Mibew:TitleNotification plugin.
 */

namespace Mibew\Mibew\Plugin\TitleNotification;

use Symfony\Component\HttpFoundation\Request;

/**
 * The main plugin's file definition.
 *
 * It only attaches needed CSS and JS files to chat windows.
 */
class Plugin extends \Mibew\Plugin\AbstractPlugin implements \Mibew\Plugin\PluginInterface
{
    /**
     * List of the plugin configs.
     *
     * @var array
     */
    protected $config;

    /**
     * Indicates if the plugin was initialized correctly.
     *
     * @var boolean
     */
    protected  $initialized = false;

    /**
     * Class constructor.
     *
     * @param array $config List of the plugin config. The following options are
     * supported:
     *   - "new_thread": boolean, if set to true window title of the visitors
     *     awaiting page will be changed when a visitor starts a new thread.
     *     The default value is true.
     *   - "new_message": string, indicates in what chat windows the title
     *     should be changed when a new message is came. The possible values
     *     are "client", "operator", "both", "none". The default value is "both".
     */
    public function __construct($config)
    {
        $bad_config = isset($config['new_message'])
            && !in_array(
                $config['new_message'],
                array('client', 'operator', 'both', 'none')
            );

        if ($bad_config) {
            // Config is invalid the plugin cannot be used. Nevertheless
            // the system should work well without the plugin.
            trigger_error(
                'Wrong value of "new_message" configuration parameter',
                E_USER_WARNING
            );

            return;
        }

        $this->initialized = true;
        $this->config = $config + array(
            'new_thread' => true,
            'new_message' => 'both',
        );
    }

    /**
     * The main entry point of a plugin.
     */
    public function run()
    {
        // Attach CSS and JS files of the plugin to chat window.
        $dispatcher = \Mibew\EventDispatcher::getInstance();
        $dispatcher->attachListener('pageAddJS', $this, 'attachJsFiles');
    }

    /**
     * Event handler for "pageAddJS" event.
     *
     * @param array $args
     */
    public function attachJSFiles(&$args)
    {
        $need_users_plugin = $this->needUsersPlugin($args['request']);
        $need_chat_plugin = $this->needChatPlugin($args['request']);

        if ($need_users_plugin || $need_chat_plugin) {
            $base_path = $this->getFilesPath();
            $args['js'][] = $base_path . '/vendor/jquery-titlealert/jquery.titlealert.js';

            if ($need_users_plugin) {
                $args['js'][] = $base_path . '/js/users_plugin.js';
            } else {
                $args['js'][] = $base_path . '/js/chat_plugin.js';
            }
        }
    }

    /**
     * Specify dependencies of the plugin.
     *
     * @return array List of dependencies
     */
    public static function getDependencies()
    {
        // This plugin does not depend on others so return an empty array.
        return array();
    }

    /**
     * Checks if the JS part for users page should be attached.
     *
     * @param Request $request Incoming request
     * @return boolean
     */
    protected function needUsersPlugin(Request $request)
    {
        return $request->attributes->get('_route') == 'users' && $this->config['new_thread'];
    }

    /**
     * Checks if the JS part for chat page should be attached.
     *
     * @param Request $request Incoming request
     * @return boolean
     */
    protected function needChatPlugin(Request $request)
    {
        $route = $request->attributes->get('_route');
        $new_message = $this->config['new_message'];
        $notify_operator = ($new_message == 'operator') || ($new_message == 'both');
        $notify_client = ($new_message == 'client') || ($new_message == 'both');

        return ($route == 'chat_operator' && $notify_operator)
            || (in_array($route, array('chat_user', 'chat_user_start')) && $notify_client);
    }
}
