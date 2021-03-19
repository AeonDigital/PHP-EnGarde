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
        'controllerNamespace' => '\\site\\controllers\\Home',
        'resourceId' => 'c218eb7b4096de45ec538f0629c76b6404aef1e5',
        'action' => 'test',
        'allowedMethods' => 
        array (
          0 => 'GET',
        ),
        'allowedMimeTypes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
          'txt' => 'text/plain',
        ),
        'method' => 'GET',
        'routes' => 
        array (
          0 => '/test',
        ),
        'activeRoute' => '/test',
        'isUseXHTML' => true,
        'runMethodName' => 'run',
        'appStage' => '',
        'customProperties' => 
        array (
        ),
        'isAutoLog' => false,
        'description' => 'Descrição genérica no controller.',
        'devDescription' => '',
        'relationedRoutes' => 
        array (
        ),
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
        ),
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseLocale' => '',
        'responseMime' => '',
        'responseMimeType' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => '',
        'responseHeaders' => 
        array (
        ),
        'masterPage' => '',
        'view' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'localeDictionary' => '',
      ),
    ),
    '/^\\/site\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'controllerNamespace' => '\\site\\controllers\\Home',
        'resourceId' => 'd820d1481d5953a474296d74fd092a6f902f9010',
        'action' => 'default',
        'allowedMethods' => 
        array (
          0 => 'GET',
          1 => 'POST',
        ),
        'allowedMimeTypes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
          'txt' => 'text/plain',
          'json' => 'application/json',
          'xml' => 'application/xml',
          'csv' => 'text/csv',
          'xls' => 'application/vnd.ms-excel',
        ),
        'method' => 'GET',
        'routes' => 
        array (
          0 => '/',
          1 => '/home',
        ),
        'activeRoute' => '/',
        'isUseXHTML' => true,
        'runMethodName' => 'run',
        'appStage' => '',
        'customProperties' => 
        array (
        ),
        'isAutoLog' => false,
        'description' => 'Página home da aplicação',
        'devDescription' => '',
        'relationedRoutes' => 
        array (
          0 => '/list',
        ),
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
          3 => 'route_mid_01',
          4 => 'route_mid_02',
          5 => 'route_mid_03',
        ),
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 120,
        'responseLocale' => '',
        'responseMime' => '',
        'responseMimeType' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => 'bem_vindo',
        'responseHeaders' => 
        array (
        ),
        'masterPage' => '',
        'view' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'localeDictionary' => '',
      ),
      'POST' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'controllerNamespace' => '\\site\\controllers\\Home',
        'resourceId' => 'd820d1481d5953a474296d74fd092a6f902f9010',
        'action' => 'default',
        'allowedMethods' => 
        array (
          0 => 'GET',
          1 => 'POST',
        ),
        'allowedMimeTypes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
          'txt' => 'text/plain',
          'json' => 'application/json',
          'xml' => 'application/xml',
          'csv' => 'text/csv',
          'xls' => 'application/vnd.ms-excel',
        ),
        'method' => 'POST',
        'routes' => 
        array (
          0 => '/',
          1 => '/home',
        ),
        'activeRoute' => '/',
        'isUseXHTML' => true,
        'runMethodName' => 'run',
        'appStage' => '',
        'customProperties' => 
        array (
        ),
        'isAutoLog' => false,
        'description' => 'Página home da aplicação',
        'devDescription' => '',
        'relationedRoutes' => 
        array (
          0 => '/list',
        ),
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
          3 => 'route_mid_01',
          4 => 'route_mid_02',
          5 => 'route_mid_03',
        ),
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 120,
        'responseLocale' => '',
        'responseMime' => '',
        'responseMimeType' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => 'bem_vindo',
        'responseHeaders' => 
        array (
        ),
        'masterPage' => '',
        'view' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'localeDictionary' => '',
      ),
    ),
    '/^\\/site\\/home\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'controllerNamespace' => '\\site\\controllers\\Home',
        'resourceId' => 'd820d1481d5953a474296d74fd092a6f902f9010',
        'action' => 'default',
        'allowedMethods' => 
        array (
          0 => 'GET',
          1 => 'POST',
        ),
        'allowedMimeTypes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
          'txt' => 'text/plain',
          'json' => 'application/json',
          'xml' => 'application/xml',
          'csv' => 'text/csv',
          'xls' => 'application/vnd.ms-excel',
        ),
        'method' => 'GET',
        'routes' => 
        array (
          0 => '/',
          1 => '/home',
        ),
        'activeRoute' => '/home',
        'isUseXHTML' => true,
        'runMethodName' => 'run',
        'appStage' => '',
        'customProperties' => 
        array (
        ),
        'isAutoLog' => false,
        'description' => 'Página home da aplicação',
        'devDescription' => '',
        'relationedRoutes' => 
        array (
          0 => '/list',
        ),
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
          3 => 'route_mid_01',
          4 => 'route_mid_02',
          5 => 'route_mid_03',
        ),
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 120,
        'responseLocale' => '',
        'responseMime' => '',
        'responseMimeType' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => 'bem_vindo',
        'responseHeaders' => 
        array (
        ),
        'masterPage' => '',
        'view' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'localeDictionary' => '',
      ),
      'POST' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'controllerNamespace' => '\\site\\controllers\\Home',
        'resourceId' => 'd820d1481d5953a474296d74fd092a6f902f9010',
        'action' => 'default',
        'allowedMethods' => 
        array (
          0 => 'GET',
          1 => 'POST',
        ),
        'allowedMimeTypes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
          'txt' => 'text/plain',
          'json' => 'application/json',
          'xml' => 'application/xml',
          'csv' => 'text/csv',
          'xls' => 'application/vnd.ms-excel',
        ),
        'method' => 'POST',
        'routes' => 
        array (
          0 => '/',
          1 => '/home',
        ),
        'activeRoute' => '/home',
        'isUseXHTML' => true,
        'runMethodName' => 'run',
        'appStage' => '',
        'customProperties' => 
        array (
        ),
        'isAutoLog' => false,
        'description' => 'Página home da aplicação',
        'devDescription' => '',
        'relationedRoutes' => 
        array (
          0 => '/list',
        ),
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
          3 => 'route_mid_01',
          4 => 'route_mid_02',
          5 => 'route_mid_03',
        ),
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 120,
        'responseLocale' => '',
        'responseMime' => '',
        'responseMimeType' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => 'bem_vindo',
        'responseHeaders' => 
        array (
        ),
        'masterPage' => '',
        'view' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'localeDictionary' => '',
      ),
    ),
    '/^\\/site\\/list\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'controllerNamespace' => '\\site\\controllers\\Home',
        'resourceId' => '8930789d150ec560e2df2d6a5207c75f3492751a',
        'action' => 'list',
        'allowedMethods' => 
        array (
          0 => 'GET',
        ),
        'allowedMimeTypes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'method' => 'GET',
        'routes' => 
        array (
          0 => '/list',
          1 => '/list/orderby:[a-zA-Z]+',
          2 => '/list/orderby:[a-zA-Z]+/page:[0-9]+',
          3 => '/configurando-uma-rota/propriedades/propertie:[a-zA-Z]+',
        ),
        'activeRoute' => '/list',
        'isUseXHTML' => true,
        'runMethodName' => 'run',
        'appStage' => '',
        'customProperties' => 
        array (
        ),
        'isAutoLog' => false,
        'description' => 'Evoca a view de lista.',
        'devDescription' => '',
        'relationedRoutes' => 
        array (
        ),
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
        ),
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseLocale' => '',
        'responseMime' => '',
        'responseMimeType' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => '',
        'responseHeaders' => 
        array (
        ),
        'masterPage' => '',
        'view' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'localeDictionary' => '',
      ),
    ),
    '/^\\/site\\/contact\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'controllerNamespace' => '\\site\\controllers\\Home',
        'resourceId' => '712ba545c011c4ecee568feba5a9da2ace0366c2',
        'action' => 'contact',
        'allowedMethods' => 
        array (
          0 => 'GET',
        ),
        'allowedMimeTypes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'method' => 'GET',
        'routes' => 
        array (
          0 => '/contact',
        ),
        'activeRoute' => '/contact',
        'isUseXHTML' => true,
        'runMethodName' => 'run',
        'appStage' => '',
        'customProperties' => 
        array (
        ),
        'isAutoLog' => false,
        'description' => 'Evoca a view para o formulário de contato.',
        'devDescription' => '',
        'relationedRoutes' => 
        array (
        ),
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
        ),
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseLocale' => '',
        'responseMime' => '',
        'responseMimeType' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => '',
        'responseHeaders' => 
        array (
        ),
        'masterPage' => '',
        'view' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'localeDictionary' => '',
      ),
      'POST' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'controllerNamespace' => '\\site\\controllers\\Home',
        'resourceId' => 'f11e2a56058f363e612072a069fd031c7da44214',
        'action' => 'contact',
        'allowedMethods' => 
        array (
          0 => 'POST',
        ),
        'allowedMimeTypes' => 
        array (
          'json' => 'application/json',
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'method' => 'POST',
        'routes' => 
        array (
          0 => '/contact',
        ),
        'activeRoute' => '/contact',
        'isUseXHTML' => true,
        'runMethodName' => 'run',
        'appStage' => '',
        'customProperties' => 
        array (
        ),
        'isAutoLog' => false,
        'description' => 'Recebe os dados submetidos pelo formulário de contato, processa-os e retorna o resultado.',
        'devDescription' => '',
        'relationedRoutes' => 
        array (
        ),
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
        ),
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseLocale' => '',
        'responseMime' => '',
        'responseMimeType' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => '',
        'responseHeaders' => 
        array (
        ),
        'masterPage' => '',
        'view' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'localeDictionary' => '',
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
        'controllerNamespace' => '\\site\\controllers\\Home',
        'resourceId' => '8930789d150ec560e2df2d6a5207c75f3492751a',
        'action' => 'list',
        'allowedMethods' => 
        array (
          0 => 'GET',
        ),
        'allowedMimeTypes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'method' => 'GET',
        'routes' => 
        array (
          0 => '/list',
          1 => '/list/orderby:[a-zA-Z]+',
          2 => '/list/orderby:[a-zA-Z]+/page:[0-9]+',
          3 => '/configurando-uma-rota/propriedades/propertie:[a-zA-Z]+',
        ),
        'activeRoute' => '/list/orderby:[a-zA-Z]+',
        'isUseXHTML' => true,
        'runMethodName' => 'run',
        'appStage' => '',
        'customProperties' => 
        array (
        ),
        'isAutoLog' => false,
        'description' => 'Evoca a view de lista.',
        'devDescription' => '',
        'relationedRoutes' => 
        array (
        ),
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
        ),
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseLocale' => '',
        'responseMime' => '',
        'responseMimeType' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => '',
        'responseHeaders' => 
        array (
        ),
        'masterPage' => '',
        'view' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'localeDictionary' => '',
      ),
    ),
    '/^\\/site\\/list\\/(?P<orderby>[a-zA-Z]+)\\/(?P<page>[0-9]+)\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'controllerNamespace' => '\\site\\controllers\\Home',
        'resourceId' => '8930789d150ec560e2df2d6a5207c75f3492751a',
        'action' => 'list',
        'allowedMethods' => 
        array (
          0 => 'GET',
        ),
        'allowedMimeTypes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'method' => 'GET',
        'routes' => 
        array (
          0 => '/list',
          1 => '/list/orderby:[a-zA-Z]+',
          2 => '/list/orderby:[a-zA-Z]+/page:[0-9]+',
          3 => '/configurando-uma-rota/propriedades/propertie:[a-zA-Z]+',
        ),
        'activeRoute' => '/list/orderby:[a-zA-Z]+/page:[0-9]+',
        'isUseXHTML' => true,
        'runMethodName' => 'run',
        'appStage' => '',
        'customProperties' => 
        array (
        ),
        'isAutoLog' => false,
        'description' => 'Evoca a view de lista.',
        'devDescription' => '',
        'relationedRoutes' => 
        array (
        ),
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
        ),
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseLocale' => '',
        'responseMime' => '',
        'responseMimeType' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => '',
        'responseHeaders' => 
        array (
        ),
        'masterPage' => '',
        'view' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'localeDictionary' => '',
      ),
    ),
    '/^\\/site\\/configurando-uma-rota\\/propriedades\\/(?P<propertie>[a-zA-Z]+)\\//' => 
    array (
      'GET' => 
      array (
        'application' => 'site',
        'namespace' => '\\site\\controllers',
        'controller' => 'Home',
        'controllerNamespace' => '\\site\\controllers\\Home',
        'resourceId' => '8930789d150ec560e2df2d6a5207c75f3492751a',
        'action' => 'list',
        'allowedMethods' => 
        array (
          0 => 'GET',
        ),
        'allowedMimeTypes' => 
        array (
          'xhtml' => 'application/xhtml+xml',
          'html' => 'text/html',
        ),
        'method' => 'GET',
        'routes' => 
        array (
          0 => '/list',
          1 => '/list/orderby:[a-zA-Z]+',
          2 => '/list/orderby:[a-zA-Z]+/page:[0-9]+',
          3 => '/configurando-uma-rota/propriedades/propertie:[a-zA-Z]+',
        ),
        'activeRoute' => '/configurando-uma-rota/propriedades/propertie:[a-zA-Z]+',
        'isUseXHTML' => true,
        'runMethodName' => 'run',
        'appStage' => '',
        'customProperties' => 
        array (
        ),
        'isAutoLog' => false,
        'description' => 'Evoca a view de lista.',
        'devDescription' => '',
        'relationedRoutes' => 
        array (
        ),
        'middlewares' => 
        array (
          0 => 'ctrl_mid_01',
          1 => 'ctrl_mid_02',
          2 => 'ctrl_mid_03',
        ),
        'isSecure' => false,
        'isUseCache' => false,
        'cacheTimeout' => 0,
        'responseLocale' => '',
        'responseMime' => '',
        'responseMimeType' => '',
        'responseIsPrettyPrint' => false,
        'responseIsDownload' => false,
        'responseDownloadFileName' => '',
        'responseHeaders' => 
        array (
        ),
        'masterPage' => '',
        'view' => '',
        'styleSheets' => 
        array (
        ),
        'javaScripts' => 
        array (
        ),
        'metaData' => 
        array (
          'Author' => 'Aeon Digital',
          'CopyRight' => '20xx Aeon Digital',
          'FrameWork' => 'PHP-AeonDigital\\EnGarde 0.9.0 [alpha]',
        ),
        'localeDictionary' => '',
      ),
    ),
  ),
);