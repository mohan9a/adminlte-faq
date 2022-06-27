## FAQ Builder for Adminlte

FAQ Builder is a Laravel package for adminlte that allow the create and manage FAQ in an easy way.

## **Quick Installation**

Begin by installing this package through Composer.

You can run:

```
composer require mohan9a/adminlte-faq 1.*
```

Or edit your project's composer.json file to require mohan9a/adminlte-faq.

```
    "require": {
        "mohan9a/adminlte-faq": "1.*"
    }
```

Next, update Composer from the Terminal:

```
composer update
```

Once the package's installation completes, the final step is to add the service provider. Open  `config/app.php`, and add a new item to the providers array:

```
Mohan9a\AdminlteFaq\AdminLteFaqServiceProvider::class,
```

Finally Publish package's configuration file:

```
php artisan vendor:publish --provider="Mohan9a\AdminlteFaq\AdminLteFaqServiceProvider" --tag="config"
```

Then the file  `config/adminlte-faq.php`  will be created. Define your own table name, prefix and middleware name.

Publish package's migration file:

```
php artisan vendor:publish --provider="Mohan9a\AdminlteFaq\AdminLteFaqServiceProvider" --tag="migrations"
```

Finally run migration:

```
php artisan migrate
```

Publish package's assets:
```
php artisan vendor:publish --provider="Mohan9a\AdminlteFaq\AdminLteFaqServiceProvider" --tag="assets"
```

Install one dependancy package using adminlte way.
```
php artisan adminlte:plugins install --plugin=toastr
```

That's it! You're ready to go. 

Run Laravel app:

```
php artisan serve
```

You can access the faqs at with URL: http://127.0.0.1/admin/faqs 


## **Contribute and share ;-)**

If you like this little piece of code share it with you friends and feel free to contribute with any improvements.