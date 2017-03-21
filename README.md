# Mibew Title Notification plugin

It provides notification about new messages and new threads in window title.


## Installation

1. Get the archive with the plugin sources. You can download it from the [official site](https://mibew.org/plugins#mibew-title-notification) or build the plugin from sources.

2. Untar/unzip the plugin's archive.

3. Put files of the plugins to the `<Mibew root>/plugins`  folder.

4. (optional) Add plugins configs to "plugins" structure in "`<Mibew root>`/configs/config.yml". If the "plugins" stucture looks like `plugins: []` it will become:
    ```yaml
    plugins:
        "Mibew:TitleNotification": # Plugin's configurations are described below
            new_thread: false
            new_message: "operator"
    ```

5. Navigate to "`<Mibew Base URL>`/operator/plugin" page and enable the plugin.


## Plugin's configurations

The plugin can be configured with values in "`<Mibew root>`/configs/config.yml" file.

### config.new_thread

Type: `Boolean`

Default: `true`

If set to true, window title of the visitors awaiting page will be changed when a visitor starts a new thread.
This value is optional and can be skipped.

### config.new_message

Type: `String`

Default: `both`

This option indicates in what chat windows the title should be changed when a new message is came.
The possible values are "`client`", "`operator`", "`both`" and "`none`". This value is optional and can be skipped.


## Build from sources

There are several actions one should do before use the latest version of the plugin from the repository:

1. Obtain a copy of the repository using `git clone`, download button, or another way.
2. Install [node.js](http://nodejs.org/) and [npm](https://www.npmjs.org/).
3. Install [Gulp](http://gulpjs.com/).
4. Install npm dependencies using `npm install`.
5. Run Gulp to build the sources using `gulp default`.

Finally `.tar.gz` and `.zip` archives of the ready-to-use Plugin will be available in `release` directory.


## License

[Apache License 2.0](http://www.apache.org/licenses/LICENSE-2.0.html)
