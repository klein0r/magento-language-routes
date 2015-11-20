# Magento Language Routes

[![Build Status](https://travis-ci.org/klein0r/magento-language-routes.svg?branch=master)](https://travis-ci.org/klein0r/magento-language-routes) [![Code Climate](https://codeclimate.com/github/klein0r/magento-language-routes/badges/gpa.svg)](https://codeclimate.com/github/klein0r/magento-language-routes) [![Latest Stable Version](https://poser.pugx.org/mkleine/magento-language-routes/v/stable)](https://packagist.org/packages/mkleine/magento-language-routes) [![Total Downloads](https://poser.pugx.org/mkleine/magento-language-routes/downloads)](https://packagist.org/packages/mkleine/magento-language-routes) [![Latest Unstable Version](https://poser.pugx.org/mkleine/magento-language-routes/v/unstable)](https://packagist.org/packages/mkleine/magento-language-routes) [![License](https://poser.pugx.org/mkleine/magento-language-routes/license)](https://packagist.org/packages/mkleine/magento-language-routes)


## Features

- Translate all URLs for each store (e.g. /customer/account/create -> /kunde/konto/erstellen)
- Easy translation without development skills by using the backend
- Translate third party extensions out of the box
- Ability to translate URLs to CMS pages, too
- Extension uses the **Magento Cache** to avoid performance issues
- **Manage permissions** for translations by roles
- Old URLs are still working (even if they translated)
- **Inline-Translation of URLs**

## Configuration

You can enable the translation module for each store in configuration:

- System / Configuration / Web / Url Options / Enable route translation (**default: Yes**)

It is possible to forward the user automatically to the translated URL:

- System / Configuration / Web / Url Options / Forward to translated route (**default: No**)

## Usage

**It is recommended, to install and test this extension in a test environment.**

Example: You want translate "/customer/account/login" to "/kunde/konto/anmelden"

### By using the Backend

*This is recommended when adding translations in production environments*

1. Go to System / Language Routes
2. Click Add
3. Choose your store
4. Select a route part
 - Route: **customer** is the route in this url
 - Controller: **account** is the controller
 - Action: **login** is the action
5. Enter a translation
6. Save
7. Check the changes in Frontend

### By using inline translation

*This is recommended when adding translations in staging / development environments*

1. Go to System / Configuration
2. Open the Developer menu
3. Navigate to "Translate inline"
4. Enabled for Frontend -> Yes
5. Clear caches
6. Open the frontend and translate every url step by step

## Screenshots

![Backend Grid](/screenshots/Backend-Grid.png)

![Backend Grid](/screenshots/Backend-Form.png)

![Backend Grid](/screenshots/Inline-Translation.png)

## Dev

If you need an url which is not translated, you can add the parameter _notranslate (set it to true)
This is the same behavior, as requesting secure urls by adding _secure.

This package is also available at [Packagist](https://packagist.org/packages/mkleine/magento-language-routes)

## Requirements

- PHP >= 5.3.0
- Magento 1.6, 1.7, 1.8, 1.9

## Contributors

- Matthias Kleine - [Magento Certified Developer](http://www.magentocommerce.com/certification/directory/dev/878053/)

Copyright (c) 2014 Matthias Kleine

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
