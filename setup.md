# PHP Development with VS Code and XAMPP

This guide explains how to configure Visual Studio Code (VS Code) to run PHP scripts using XAMPP.

---

## Prerequisites

1. **XAMPP**: Download and install [XAMPP for macOS](https://www.apachefriends.org/download.html).
2. **VS Code**: Download and install [Visual Studio Code](https://code.visualstudio.com/).

---

## Step 1: Install Extensions in VS Code

1. Open VS Code.
2. Go to the Extensions Marketplace (`Cmd+Shift+X`).
3. Install the following extensions:
   - [**PHP Intelephense**](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client)
   - [**PHP Debug**](https://marketplace.visualstudio.com/items?itemName=xdebug.php-debug)

---

## Step 2: Configure PHP Path in VS Code

**For Windows**
1. Locate the PHP executable in your XAMPP installation. It is typically at: 
    ```
    C:\xampp\php\php.exe
    ```
2. Open VS Code **Settings** (`Cmd+,`) and search for `php`.
3. Set the **PHP: Executable Path** to: 
    ```
    C:\xampp\php\php.exe
    ```

**For MacOS**
1. Locate the PHP executable in your XAMPP installation. It is typically at: 
    ```
    /Applications/XAMPP/xamppfiles/bin/php
    ```
2. Open VS Code **Settings** (`Cmd+,`) and search for `php`.
3. Set the **PHP: Executable Path** to: 
    ```
    /Applications/XAMPP/xamppfiles/bin/php
    ```


---

## Step 3: Configure Debugging

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