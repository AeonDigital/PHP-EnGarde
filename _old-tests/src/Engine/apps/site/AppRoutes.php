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
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
        ),
        'relationedRoutes' => NULL,
        'description' => 'Descrição genérica no controller.',
        'devDescription' => NULL,
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => NULL,
        'responseMimeType' => NULL,
        'responseLocale' => NULL,
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => NULL,
        'masterPage' => 'masterpage.phtml',
        'view' => NULL,
        'form' => NULL,
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => NULL,
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => NULL,
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
          'pdf' => 'application/pdf',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
          3 => 'route_mid_01',
          4 => 'route_mid_02',
          5 => 'route_mid_03',
        ),
        'relationedRoutes' => 
        array (
          0 => '/list',
        ),
        'description' => 'Página home da aplicação',
        'devDescription' => NULL,
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 120,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => NULL,
        'responseMimeType' => NULL,
        'responseLocale' => NULL,
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => 'bem_vindo',
        'masterPage' => 'masterpage.phtml',
        'view' => NULL,
        'form' => NULL,
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => NULL,
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => NULL,
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
          'pdf' => 'application/pdf',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
          3 => 'route_mid_01',
          4 => 'route_mid_02',
          5 => 'route_mid_03',
        ),
        'relationedRoutes' => 
        array (
          0 => '/list',
        ),
        'description' => 'Página home da aplicação',
        'devDescription' => NULL,
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 120,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => NULL,
        'responseMimeType' => NULL,
        'responseLocale' => NULL,
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => 'bem_vindo',
        'masterPage' => 'masterpage.phtml',
        'view' => NULL,
        'form' => NULL,
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => NULL,
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => NULL,
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
          'pdf' => 'application/pdf',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
          3 => 'route_mid_01',
          4 => 'route_mid_02',
          5 => 'route_mid_03',
        ),
        'relationedRoutes' => 
        array (
          0 => '/list',
        ),
        'description' => 'Página home da aplicação',
        'devDescription' => NULL,
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 120,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => NULL,
        'responseMimeType' => NULL,
        'responseLocale' => NULL,
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => 'bem_vindo',
        'masterPage' => 'masterpage.phtml',
        'view' => NULL,
        'form' => NULL,
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => NULL,
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => NULL,
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
          'pdf' => 'application/pdf',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
          3 => 'route_mid_01',
          4 => 'route_mid_02',
          5 => 'route_mid_03',
        ),
        'relationedRoutes' => 
        array (
          0 => '/list',
        ),
        'description' => 'Página home da aplicação',
        'devDescription' => NULL,
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 120,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => NULL,
        'responseMimeType' => NULL,
        'responseLocale' => NULL,
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => 'bem_vindo',
        'masterPage' => 'masterpage.phtml',
        'view' => NULL,
        'form' => NULL,
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => NULL,
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => NULL,
      ),
    ),
    '/^\\/site\\/customrun\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'action' => '-',
        'method' => 'GET',
        'allowedMethods' => 
        array (
          0 => 'GET',
        ),
        'routes' => 
        array (
          0 => '/customrun',
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
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
        ),
        'relationedRoutes' => NULL,
        'description' => 'Página home da aplicação',
        'devDescription' => NULL,
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => NULL,
        'responseMimeType' => NULL,
        'responseLocale' => NULL,
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => NULL,
        'masterPage' => 'masterpage.phtml',
        'view' => NULL,
        'form' => NULL,
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => NULL,
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'customRun',
        'customProperties' => NULL,
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
        ),
        'acceptMimes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
        ),
        'relationedRoutes' => NULL,
        'description' => 'Evoca a view de lista.',
        'devDescription' => NULL,
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => NULL,
        'responseMimeType' => NULL,
        'responseLocale' => NULL,
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => NULL,
        'masterPage' => 'masterpage.phtml',
        'view' => NULL,
        'form' => NULL,
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => NULL,
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => NULL,
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
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
        ),
        'relationedRoutes' => NULL,
        'description' => 'Evoca a view para o formulário de contato.',
        'devDescription' => NULL,
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => NULL,
        'responseMimeType' => NULL,
        'responseLocale' => NULL,
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => NULL,
        'masterPage' => 'masterpage.phtml',
        'view' => NULL,
        'form' => NULL,
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => NULL,
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => NULL,
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
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
        ),
        'relationedRoutes' => NULL,
        'description' => 'Recebe os dados submetidos pelo formulário de contato, processa-os e retorna o resultado.',
        'devDescription' => NULL,
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => NULL,
        'responseMimeType' => NULL,
        'responseLocale' => NULL,
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => NULL,
        'masterPage' => 'masterpage.phtml',
        'view' => NULL,
        'form' => NULL,
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => NULL,
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => NULL,
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
        ),
        'acceptMimes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
        ),
        'relationedRoutes' => NULL,
        'description' => 'Evoca a view de lista.',
        'devDescription' => NULL,
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => NULL,
        'responseMimeType' => NULL,
        'responseLocale' => NULL,
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => NULL,
        'masterPage' => 'masterpage.phtml',
        'view' => NULL,
        'form' => NULL,
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => NULL,
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => NULL,
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
        ),
        'acceptMimes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'isUseXHTML' => true,
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
        ),
        'relationedRoutes' => NULL,
        'description' => 'Evoca a view de lista.',
        'devDescription' => NULL,
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseHeaders' => 
        array (
        ),
        'responseMime' => NULL,
        'responseMimeType' => NULL,
        'responseLocale' => NULL,
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => NULL,
        'masterPage' => 'masterpage.phtml',
        'view' => NULL,
        'form' => NULL,
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'localeDictionary' => NULL,
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'runMethodName' => 'run',
        'customProperties' => NULL,
      ),
    ),
  ),
);