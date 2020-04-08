<?php return array (
  'simple' => 
  array (
    '/^\\/site\\/test\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'action' => 'test',
        'method' => 'GET',
        'allowedMethods' => 
        array (
          0 => 'GET',
        ),
        'routes' => 
        array (
          0 => '/test',
        ),
        'acceptMimes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
          'txt' => 'text/plain',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'app_mid_01',
          1 => 'app_mid_02',
          2 => 'app_mid_03',
          3 => 'ctrl_mid_01',
          4 => 'ctrl_mid_02',
          5 => 'ctrl_mid_03',
        ),
        'relationedRoutes' => 
        array (
        ),
        'description' => 'Descrição genérica no controller.',
        'devDescription' => '',
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => '',
        'responseMimeType' => '',
        'responseLocale' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => '',
        'masterPage' => '',
        'view' => '',
        'form' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => '',
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => 
        array (
        ),
      ),
    ),
    '/^\\/site\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'action' => 'default',
        'method' => 'GET',
        'allowedMethods' => 
        array (
          0 => 'GET',
          1 => 'POST',
        ),
        'routes' => 
        array (
          0 => '/',
          1 => '/home',
        ),
        'acceptMimes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
          'txt' => 'text/plain',
          'json' => 'application/json',
          'xml' => 'application/xml',
          'csv' => 'text/csv',
          'xls' => 'application/vnd.ms-excel',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'app_mid_01',
          1 => 'app_mid_02',
          2 => 'app_mid_03',
          3 => 'ctrl_mid_01',
          4 => 'ctrl_mid_02',
          5 => 'ctrl_mid_03',
          6 => 'route_mid_01',
          7 => 'route_mid_02',
          8 => 'route_mid_03',
        ),
        'relationedRoutes' => 
        array (
          0 => '/list',
        ),
        'description' => 'Página home da aplicação',
        'devDescription' => '',
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 120,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => '',
        'responseMimeType' => '',
        'responseLocale' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => 'bem_vindo',
        'masterPage' => '',
        'view' => '',
        'form' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => '',
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => 
        array (
        ),
      ),
      'POST' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'action' => 'default',
        'method' => 'POST',
        'allowedMethods' => 
        array (
          0 => 'GET',
          1 => 'POST',
        ),
        'routes' => 
        array (
          0 => '/',
          1 => '/home',
        ),
        'acceptMimes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
          'txt' => 'text/plain',
          'json' => 'application/json',
          'xml' => 'application/xml',
          'csv' => 'text/csv',
          'xls' => 'application/vnd.ms-excel',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'app_mid_01',
          1 => 'app_mid_02',
          2 => 'app_mid_03',
          3 => 'ctrl_mid_01',
          4 => 'ctrl_mid_02',
          5 => 'ctrl_mid_03',
          6 => 'route_mid_01',
          7 => 'route_mid_02',
          8 => 'route_mid_03',
        ),
        'relationedRoutes' => 
        array (
          0 => '/list',
        ),
        'description' => 'Página home da aplicação',
        'devDescription' => '',
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 120,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => '',
        'responseMimeType' => '',
        'responseLocale' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => 'bem_vindo',
        'masterPage' => '',
        'view' => '',
        'form' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => '',
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => 
        array (
        ),
      ),
    ),
    '/^\\/site\\/home\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'action' => 'default',
        'method' => 'GET',
        'allowedMethods' => 
        array (
          0 => 'GET',
          1 => 'POST',
        ),
        'routes' => 
        array (
          0 => '/',
          1 => '/home',
        ),
        'acceptMimes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
          'txt' => 'text/plain',
          'json' => 'application/json',
          'xml' => 'application/xml',
          'csv' => 'text/csv',
          'xls' => 'application/vnd.ms-excel',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'app_mid_01',
          1 => 'app_mid_02',
          2 => 'app_mid_03',
          3 => 'ctrl_mid_01',
          4 => 'ctrl_mid_02',
          5 => 'ctrl_mid_03',
          6 => 'route_mid_01',
          7 => 'route_mid_02',
          8 => 'route_mid_03',
        ),
        'relationedRoutes' => 
        array (
          0 => '/list',
        ),
        'description' => 'Página home da aplicação',
        'devDescription' => '',
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 120,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => '',
        'responseMimeType' => '',
        'responseLocale' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => 'bem_vindo',
        'masterPage' => '',
        'view' => '',
        'form' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => '',
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => 
        array (
        ),
      ),
      'POST' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'action' => 'default',
        'method' => 'POST',
        'allowedMethods' => 
        array (
          0 => 'GET',
          1 => 'POST',
        ),
        'routes' => 
        array (
          0 => '/',
          1 => '/home',
        ),
        'acceptMimes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
          'txt' => 'text/plain',
          'json' => 'application/json',
          'xml' => 'application/xml',
          'csv' => 'text/csv',
          'xls' => 'application/vnd.ms-excel',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'app_mid_01',
          1 => 'app_mid_02',
          2 => 'app_mid_03',
          3 => 'ctrl_mid_01',
          4 => 'ctrl_mid_02',
          5 => 'ctrl_mid_03',
          6 => 'route_mid_01',
          7 => 'route_mid_02',
          8 => 'route_mid_03',
        ),
        'relationedRoutes' => 
        array (
          0 => '/list',
        ),
        'description' => 'Página home da aplicação',
        'devDescription' => '',
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 120,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => '',
        'responseMimeType' => '',
        'responseLocale' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => 'bem_vindo',
        'masterPage' => '',
        'view' => '',
        'form' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => '',
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => 
        array (
        ),
      ),
    ),
    '/^\\/site\\/list\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'action' => 'list',
        'method' => 'GET',
        'allowedMethods' => 
        array (
          0 => 'GET',
        ),
        'routes' => 
        array (
          0 => '/list',
          1 => '/list/orderby:[a-zA-Z]+',
          2 => '/list/orderby:[a-zA-Z]+/page:[0-9]',
          3 => '/configurando-uma-rota/propriedades/propertie:[a-zA-Z]+',
        ),
        'acceptMimes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'app_mid_01',
          1 => 'app_mid_02',
          2 => 'app_mid_03',
          3 => 'ctrl_mid_01',
          4 => 'ctrl_mid_02',
          5 => 'ctrl_mid_03',
        ),
        'relationedRoutes' => 
        array (
        ),
        'description' => 'Evoca a view de lista.',
        'devDescription' => '',
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => '',
        'responseMimeType' => '',
        'responseLocale' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => '',
        'masterPage' => '',
        'view' => '',
        'form' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => '',
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => 
        array (
        ),
      ),
    ),
    '/^\\/site\\/contact\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'action' => 'contact',
        'method' => 'GET',
        'allowedMethods' => 
        array (
          0 => 'GET',
        ),
        'routes' => 
        array (
          0 => '/contact',
        ),
        'acceptMimes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'app_mid_01',
          1 => 'app_mid_02',
          2 => 'app_mid_03',
          3 => 'ctrl_mid_01',
          4 => 'ctrl_mid_02',
          5 => 'ctrl_mid_03',
        ),
        'relationedRoutes' => 
        array (
        ),
        'description' => 'Evoca a view para o formulário de contato.',
        'devDescription' => '',
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => '',
        'responseMimeType' => '',
        'responseLocale' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => '',
        'masterPage' => '',
        'view' => '',
        'form' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => '',
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => 
        array (
        ),
      ),
      'POST' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'action' => 'contact',
        'method' => 'POST',
        'allowedMethods' => 
        array (
          0 => 'POST',
        ),
        'routes' => 
        array (
          0 => '/contact',
        ),
        'acceptMimes' => 
        array (
          'json' => 'application/json',
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'app_mid_01',
          1 => 'app_mid_02',
          2 => 'app_mid_03',
          3 => 'ctrl_mid_01',
          4 => 'ctrl_mid_02',
          5 => 'ctrl_mid_03',
        ),
        'relationedRoutes' => 
        array (
        ),
        'description' => 'Recebe os dados submetidos pelo formulário de contato, processa-os e retorna o resultado.',
        'devDescription' => '',
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => '',
        'responseMimeType' => '',
        'responseLocale' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => '',
        'masterPage' => '',
        'view' => '',
        'form' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => '',
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => 
        array (
        ),
      ),
    ),
  ),
  'complex' => 
  array (
    '/^\\/site\\/list\\/(?P<orderby>[a-zA-Z]+)\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'action' => 'list',
        'method' => 'GET',
        'allowedMethods' => 
        array (
          0 => 'GET',
        ),
        'routes' => 
        array (
          0 => '/list',
          1 => '/list/orderby:[a-zA-Z]+',
          2 => '/list/orderby:[a-zA-Z]+/page:[0-9]',
          3 => '/configurando-uma-rota/propriedades/propertie:[a-zA-Z]+',
        ),
        'acceptMimes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'app_mid_01',
          1 => 'app_mid_02',
          2 => 'app_mid_03',
          3 => 'ctrl_mid_01',
          4 => 'ctrl_mid_02',
          5 => 'ctrl_mid_03',
        ),
        'relationedRoutes' => 
        array (
        ),
        'description' => 'Evoca a view de lista.',
        'devDescription' => '',
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => '',
        'responseMimeType' => '',
        'responseLocale' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => '',
        'masterPage' => '',
        'view' => '',
        'form' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => '',
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => 
        array (
        ),
      ),
    ),
    '/^\\/site\\/list\\/(?P<orderby>[a-zA-Z]+)\\/(?P<page>[0-9])\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'action' => 'list',
        'method' => 'GET',
        'allowedMethods' => 
        array (
          0 => 'GET',
        ),
        'routes' => 
        array (
          0 => '/list',
          1 => '/list/orderby:[a-zA-Z]+',
          2 => '/list/orderby:[a-zA-Z]+/page:[0-9]',
          3 => '/configurando-uma-rota/propriedades/propertie:[a-zA-Z]+',
        ),
        'acceptMimes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'app_mid_01',
          1 => 'app_mid_02',
          2 => 'app_mid_03',
          3 => 'ctrl_mid_01',
          4 => 'ctrl_mid_02',
          5 => 'ctrl_mid_03',
        ),
        'relationedRoutes' => 
        array (
        ),
        'description' => 'Evoca a view de lista.',
        'devDescription' => '',
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => '',
        'responseMimeType' => '',
        'responseLocale' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => '',
        'masterPage' => '',
        'view' => '',
        'form' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => '',
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => 
        array (
        ),
      ),
    ),
    '/^\\/site\\/configurando-uma-rota\\/propriedades\\/(?P<propertie>[a-zA-Z]+)\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'action' => 'list',
        'method' => 'GET',
        'allowedMethods' => 
        array (
          0 => 'GET',
        ),
        'routes' => 
        array (
          0 => '/list',
          1 => '/list/orderby:[a-zA-Z]+',
          2 => '/list/orderby:[a-zA-Z]+/page:[0-9]',
          3 => '/configurando-uma-rota/propriedades/propertie:[a-zA-Z]+',
        ),
        'acceptMimes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'app_mid_01',
          1 => 'app_mid_02',
          2 => 'app_mid_03',
          3 => 'ctrl_mid_01',
          4 => 'ctrl_mid_02',
          5 => 'ctrl_mid_03',
        ),
        'relationedRoutes' => 
        array (
        ),
        'description' => 'Evoca a view de lista.',
        'devDescription' => '',
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => '',
        'responseMimeType' => '',
        'responseLocale' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => '',
        'masterPage' => '',
        'view' => '',
        'form' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => '',
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => 
        array (
        ),
      ),
    ),
  ),
);