# Iniciando o servidor
php artisan serve

# Configurar o BD no .env

# Executar as migrations
Será criada as tabelas necessárias para execução

php artisan migrate

# Executar os seeds
Será adicionado o usuário Administrador para fazer login no sistema
Username: admin
Password: admin

php artisan db:seed

# Fazer login utilizando os dados acima

# Digitar uma palavra para busca, caso retorne algo será salvo no BD

# Ao voltar para a Home e clicar no botão para Listagem será apresentado todos os dados em uma tabela com opção para exclusão

# Ao exlcuir algum artigo será redirecionado para a listagem