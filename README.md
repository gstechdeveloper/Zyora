<h1>Zyora App</h1>

<p>
  Zyora é  um aplicativo de controle de estoque laboratorial desenvolvido para a empresa laborato, nele o usuário operador ou administrador consegue realizar o cadastro de materiais e registrar entradas dos mesmos.

  Os usuários coletores só conseguem registrar requisições(pedido de saídas), visualizar e devem confirmar o recebimento do material.
  
</p>

<p>Administradores conseguem deletar entradas, operadores não conseguem.</p>

<h5>Tela de login:</h5>
<img width="2522" height="1299" alt="image" src="https://github.com/user-attachments/assets/039aac0f-5f0b-4646-8dba-9f45be5c1d93" />


<h5>Tela de Admin/Operador:</h5>

<img width="2543" height="1298" alt="image" src="https://github.com/user-attachments/assets/90ecb630-e2c8-4c33-8aef-d026e43b5ba8" />


<h5>Tela de Coletores:</h5>

<img width="2546" height="1300" alt="image" src="https://github.com/user-attachments/assets/4f9171c4-ead7-4dc1-85f6-e7f81832326e" />


<br>
<h1>Instalação:</h1>

<p>No terminal do windows cole o comando abaixo:</p>

```shell
git clone -b back-end https://github.com/gstechdeveloper/Zyora.git
```

<br>
<p>Na pasta do projeto rode:</p>

```php
composer install
```
<br>

<h5>Depois rode as migrations na pasta raiz do projeto(O servidor no arquivo .env está com o SQLite por padrão).</h5>

```php
php artisan migrate
```
<br>

<h5>Deve ser criado o primeiro usuário(ADMIN) no sistema, como não foi implementado ainda um recurso de criação no próprio APP deve ser feito uma requisição via post usando o postman(ou outros programas) para a rota /register conforme abaixo:</h5>
<br>
<img width="2118" height="576" alt="image" src="https://github.com/user-attachments/assets/9b3be22b-21c0-49c8-b21f-4158680be3e8" />
<br>
<p>IMPORTANTE: Depois de criado os usuários, é sempre importante desativar essa rota, pois a mesma não é protegida por um middleware a mesma é somente utilizada para registrar usuários.</p>
