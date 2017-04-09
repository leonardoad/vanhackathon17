#VanHackathon 2017

This is and app done in the VanHackathon 2017 (http://www.vanhack.com/hackathon/) responding to the Lunch n' Learn Challenge from the Milma Tech company (http://www.mlimatech.com/)

## Getting Started

This web app was built using Zend Framework, Smarty, JQuery, Twitter-bootstrap and much passion on our work!

A sample of this app id running on www.romuloberri.com.br

### Installing

Clone the project files.

```
$ git clone git@github.com:romuloberri/rbmicroframework.git
```
Set permission to the templates and images folder:
```
/Libs/View/templates_c
/site/Public/Images/Course
```

Restore the database using the script that is on the path
```
/Res/vanhackathon17-29.sql
```

Configure the database access information on the file `/site/Application/Config.ini` like the example below
```
db.adapter = pdo_mysql
db.config.host = localhost
db.config.username = vanhackathon17
db.config.password = 'mypassword'
db.config.dbname = vanhackathon17
```

## Authors

* **Rômulo Berri** - [romuloberri](https://github.com/romuloberri)
* **Leonardo Danielli** - [leonardoad](https://github.com/leonardoad)
* **Jose Mario Gutierez** - [josemariogutierrez](https://github.com/josemariogutierrez)
