Yii2 OpenLDAP Auth
==================
Enable the use of OpenLDAP to authenticate users

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist maximilianoraul/yii2-openldap-user "*"
```

or add

```
"maximilianoraul/yii2-openldap-user": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by:

Add in your config (`config/web.php` for the basic app):
~~~php
    'components' => [
        //...
        'user' => [
            'identityClass' => 'MaximilianoRaul\OpenLDAP\model\User',
        ],
        //...
        'openldap' => [
            'class' => 'MaximilianoRaul\OpenLdap\Openldap',
            'host' => "ldap.example.int",
            'protocol' => "ldap://",
            'port' => 389,
            'baseDn' => "dc=example,dc=int",
            'ldapVersion' => 3,
        ],
        //...
~~~

~~~php
~~~