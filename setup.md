# Getting Started

 This guide will help you set up and run the project on your local machine.


## Prerequisites

1. **XAMPP**: Download and install [XAMPP](https://www.apachefriends.org/download.html) for your respective OS.
2. **VS Code**: Download and install [Visual Studio Code](https://code.visualstudio.com/).
3. A modern browser.


## Installation Steps
1. **Clone the repository**
    ```bash
    git clone https://github.com/jdai01/CAI_WebTPr
    ```

2. **Install Extensions in VS Code**
    1. Open VS Code.
    2. Go to the Extensions Marketplace (`Cmd+Shift+X`).
    3. Install the following extensions:
    - [**PHP Intelephense**](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client)
   <!-- - [**PHP Debug**](https://marketplace.visualstudio.com/items?itemName=xdebug.php-debug) -->

3. **Configure PHP Path in VS Code**
    1. Locate the PHP executable in your XAMPP installation. It is typically at the default location described in the next steps.
    2. Open VS Code **Settings** (`Cmd+,`) and search for `php`.
    3. Set the **PHP: Executable Path** to: 
        **For Windows**
        ```
        C:\xampp\php\php.exe
        ```
        **For MacOS**
        ```
        /Applications/XAMPP/xamppfiles/bin/php
        ```

4. **Configure Debugging**
    1. Go to the **Run and Debug** view in VS Code (`Cmd+Shift+D`).
    2. Click **Create a launch.json file** and select **PHP** as the environment.
    3. Update the `launch.json` file as follows:
        ```json
        {
        "version": "0.2.0",
        "configurations": [
            {
            "name": "Listen for XDebug",
            "type": "php",
            "request": "launch",
            "port": 9003
            },
            {
            "name": "Launch currently open script",
            "type": "php",
            "request": "launch",
            "program": "${file}",
            "cwd": "${fileDirname}",
            "port": 9003
            }
        ]
        }
        ```

5. Start the project server on PHP.

6. Now you can launch the WebShop!
    Click [here](http://localhost:3000/myWebShop/index.php) or copy the link to launch the site.
    ```
    http://localhost:3000/myWebShop/index.php
    ```