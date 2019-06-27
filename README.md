# Data Layer @CoffeeCode

[![Maintainer](http://img.shields.io/badge/maintainer-@robsonvleite-blue.svg?style=flat-square)](https://twitter.com/robsonvleite)
[![Source Code](http://img.shields.io/badge/source-coffeecode/datalayer-blue.svg?style=flat-square)](https://github.com/robsonvleite/datalayer)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/coffeecode/datalayer.svg?style=flat-square)](https://packagist.org/packages/coffeecode/datalayer)
[![Latest Version](https://img.shields.io/github/release/robsonvleite/datalayer.svg?style=flat-square)](https://github.com/robsonvleite/datalayer/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/robsonvleite/datalayer.svg?style=flat-square)](https://scrutinizer-ci.com/g/robsonvleite/datalayer)
[![Quality Score](https://img.shields.io/scrutinizer/g/robsonvleite/datalayer.svg?style=flat-square)](https://scrutinizer-ci.com/g/robsonvleite/datalayer)
[![Total Downloads](https://img.shields.io/packagist/dt/coffeecode/datalayer.svg?style=flat-square)](https://packagist.org/packages/coffeecode/datalayer)

###### The data layer is a persistent abstraction component of your database that PDO has prepared instructions for performing common routines such as registering, reading, editing, and removing data.

O data layer é um componente para abstração de persistência no seu banco de dados que usa PDO com prepared statements para executar rotinas comuns como cadastrar, ler, editar e remover dados.

## About CoffeeCode

###### CoffeeCode is a set of small and optimized PHP components for common tasks. Held by Robson V. Leite and the UpInside team. With them you perform routine tasks with fewer lines, writing less and doing much more.

CoffeeCode é um conjunto de pequenos e otimizados componentes PHP para tarefas comuns. Mantido por Robson V. Leite e a equipe UpInside. Com eles você executa tarefas rotineiras com poucas linhas, escrevendo menos e fazendo muito mais.

### Highlights

- Easy to set up (Fácil de configurar)
- Total CRUD asbtration (Asbtração total do CRUD)
- Create safe models (Crie de modelos seguros)
- Composer ready (Pronto para o composer)
- PSR-2 compliant (Compatível com PSR-2)

## Installation

Data Layer is available via Composer:

```bash
"coffeecode/datalayer": "^1.0"
```

or run

```bash
composer require coffeecode/datalayer
```

## Documentation

###### For details on how to use the Data Layer, see the sample folder with details in the component directory

Para mais detalhes sobre como usar o Data Layer, veja a pasta de exemplo com detalhes no diretório do componente

#### find

```php
<?php
use Example\Models\User;
$model = new User();

//find all users
$users = $model->find()->fetch(true);

//find all users limit 2
$users = $model->find()->limit(2)->fetch(true);

//find all users limit 2 offset 2
$users = $model->find()->limit(2)->offset(2)->fetch(true);

//find all users limit 2 offset 2 order by filed ASC
$users = $model->find()->limit(2)->offset(2)->order("first_name ASC")->fetch(true);

//looping users
foreach ($users as $user) {
    echo $user->first_name;
}

//find one user by condition
$user = $model->find("first_name = :name", "name=Robson")->fetch();
echo $user->first_name;
```

#### findById

```php
<?php
use Example\Models\User;

$model = new User();
$user = $model->findById(2);
echo $user->first_name;
```

#### count

```php
<?php
use Example\Models\User;
$model = new User();

$count = $model->find()->count();
```

#### save create

```php
<?php
use Example\Models\User;
$user = new User();

$user->first_name = "Robson";
$user->last_name = "Leite";
$userId = $user->save();
```

#### save update

```php
<?php
use Example\Models\User;
$user = (new User())->findById(2);

$user->first_name = "Robson";
$userId = $user->save();
```

#### destroy

```php
<?php
use Example\Models\User;
$user = (new User())->findById(2);

$user->destroy();
```

#### fail

```php
<?php
use Example\Models\User;
$user = (new User())->findById(2);

if($user->fail()){
    echo $user->fail()->getMessage();
}
```

## Contributing

Please see [CONTRIBUTING](https://github.com/robsonvleite/datalayer/blob/master/CONTRIBUTING.md) for details.

## Support

###### Security: If you discover any security related issues, please email cursos@upinside.com.br instead of using the issue tracker.

Se você descobrir algum problema relacionado à segurança, envie um e-mail para cursos@upinside.com.br em vez de usar o rastreador de problemas.

Thank you

## Credits

- [Robson V. Leite](https://github.com/robsonvleite) (Developer)
- [UpInside Treinamentos](https://github.com/upinside) (Team)
- [All Contributors](https://github.com/robsonvleite/datalayer/contributors) (This Rock)

## License

The MIT License (MIT). Please see [License File](https://github.com/robsonvleite/datalayer/blob/master/LICENSE) for more information.
