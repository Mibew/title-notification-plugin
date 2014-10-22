/*!
 * This file is a part of Mibew Title Notification Plugin.
 *
 * Copyright 2014 Dmitriy Simushev <simushevds@gmail.com>.
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

(function (Mibew, $) {
    // Initialize separated Marionette.js module for the plugin.
    var module = Mibew.Application.module(
        'MibewTitleNotificationPlugin',
        {startWithParent: false}
    );

    Mibew.Application.on({
        'start': function() {
            // Run the plugin AFTER the main application started
            module.start();
        },
        'stop': function() {
            // Stop the plugin BEFORE the main application stopped
            module.stop();
        }
    });

    module.addInitializer(function() {
        Mibew.Objects.Collections.threads.on('add', function(model) {
            $.titleAlert(Mibew.Localization.trans('A new visitor is waiting for an answer.'), {
                requireBlur: true,
                stopOnFocus: true,
                duration: 0,
                interval: 1000
            });
        });
    });
})(Mibew, jQuery);
