Menu module for Yii 2
=====================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require infoweb-internet-solutions/yii2-cms-menu "*"
```

or add

```
"infoweb-internet-solutions/yii2-cms-menu": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply modify your application configuration as follows:

```php
'modules' => [
    ...
    'menu' => [
        'class' => 'infoweb\menu\Module',
    ],
],
```

Import the translations and use category 'infoweb/menu':
```
yii i18n/import @infoweb/menu/messages
```

To use the module, execute yii migration
```
yii migrate/up --migrationPath=@vendor/infoweb-internet-solutions/yii2-cms-menu/migrations
```

Configuration
-------------
All available configuration options are listed below with their default values.
___
##### enablePrivateMenuItems (type: `boolean`, default: `false`)
If this option is set to `true`, the `public` attribute of a menu-item can be managed and the `getTree` function in `models/frontend/Menu` will only return public menu-items if the current application user is a guest.
Keep in mind that you will also have to enable the module in your frontend application to if you set this option to `true`.
___
##### defaultPublicVisibility (type: `boolean`, default: `true`)
This is the value that will be used as the default value of the `public` attribute of a menu-item.
___
##### allowContentDuplication (type: `boolean`, default: `true`)
If this option is set to `true`, the `duplicateable` jquery plugin is activated on all translateable attributes.
___
##### createEntityFromMenuItem (type: `boolean`, default: `true`)
If this option is set to `true`, you can for example create a page in the menu item form.
___
##### linkableEntities (type: `boolean`, default: `[]`)
These are the entities will be used in the `menu` module.
The fully qualified name of the entity class is used as the key in the array.
An entity can only be linked if it implements the `getUrl` and `getAllForDropDownList` methods.
For each configured entity the following fields are required:
   - ** label **: The entity label that will be used in the `menu` module
   - ** i18nGroup **: The group that will be used for the translation of the label
   
Example configuration:
```php
'menu' => [
    'class' => 'infoweb\menu\Module',
    'enablePrivateMenuItems' => true,
    'linkableEntities' => [
        MedicalTraining::className()  => [
            'label'     => 'Training',
            'i18nGroup' => 'infoweb/medical-training',
        ]
    ]
],
```
