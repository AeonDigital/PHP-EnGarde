PHP-EnGarde : Sequestrando Requisições HTTP
============================================

> [Aeon Digital](http://aeondigital.com.br)
>
> rianna@aeondigital.com.br  

Assim como em vários outros frameworks, para que um domínio seja devidamente coordenado por aplicações que utilizem o presente projeto é preciso que seja feita uma configuração para redirecionar toda requisição que chegue ao domínio para o script [index.php](index.php) que deve estar no diretório raiz do domínio e dá início ao processamento da requisição HTTP.  

&nbsp;  

Os arquivos [.htaccess (Apache)](.htaccess) e [web.config (IIS)](webc.config) trazem um modelo das configurações mínimas que devem ser utilizadas para ativar tal comportamento.
