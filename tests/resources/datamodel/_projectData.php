<?php return array (
  'DomainApplication' => 
  array (
    'modelFilePath' => 'DomainApplication.php',
    'ormInstructions' => 
    array (
      'select' => 'SELECT Id, Active, RegisterDate, CommercialName, ApplicationName, Description FROM DomainApplication WHERE Id=:Id;',
      'selectChild' => 
      array (
        'UserProfiles' => 
        array (
          'select' => 'SELECT Id as fkId FROM DomainUserProfile WHERE DomainApplication_Id=:Id;',
          'oColumnFK' => NULL,
          'linkTableName' => NULL,
          'linkTableColumns' => NULL,
        ),
      ),
      'selectParentId' => 
      array (
      ),
      'attatchWith' => 
      array (
        'DomainUserProfile' => 'UPDATE DomainUserProfile SET DomainApplication_Id=:thisId WHERE Id=:tgtId;',
      ),
      'detachWith' => 
      array (
        'DomainUserProfile' => 'UPDATE DomainUserProfile SET DomainApplication_Id=null WHERE Id=:tgtId;',
      ),
      'detachWithAll' => 
      array (
        'DomainUserProfile' => 'UPDATE DomainUserProfile SET DomainApplication_Id=null WHERE DomainApplication_Id=:thisId;',
      ),
      'oColumn' => 
      array (
      ),
      'singleFK' => 
      array (
      ),
      'collectionFK' => 
      array (
      ),
    ),
  ),
  'DomainRoute' => 
  array (
    'modelFilePath' => 'DomainRoute.php',
    'ormInstructions' => 
    array (
      'select' => 'SELECT Id, ControllerName, ActionName, MethodHttp, RawRoute, Description FROM DomainRoute WHERE Id=:Id;',
      'selectChild' => 
      array (
        'Profiles' => 
        array (
          'select' => 'SELECT DomainUserProfile_Id as fkId FROM secdup_to_secdr WHERE DomainRoute_Id=:Id;',
          'oColumnFK' => NULL,
          'linkTableName' => 'secdup_to_secdr',
          'linkTableColumns' => 
          array (
            0 => 'DomainRoute_Id',
            1 => 'DomainUserProfile_Id',
          ),
        ),
      ),
      'selectParentId' => 
      array (
      ),
      'attatchWith' => 
      array (
        'DomainUserProfile' => 'INSERT INTO secdup_to_secdr (DomainRoute_Id, DomainUserProfile_Id) VALUES (:thisId, :tgtId);',
      ),
      'detachWith' => 
      array (
        'DomainUserProfile' => 'DELETE FROM secdup_to_secdr WHERE DomainRoute_Id=:thisId AND DomainUserProfile_Id=:tgtId;',
      ),
      'detachWithAll' => 
      array (
        'DomainUserProfile' => 'DELETE FROM secdup_to_secdr WHERE DomainRoute_Id=:thisId;',
      ),
      'oColumn' => 
      array (
      ),
      'singleFK' => 
      array (
      ),
      'collectionFK' => 
      array (
      ),
    ),
  ),
  'DomainRouteRedirect' => 
  array (
    'modelFilePath' => 'DomainRouteRedirect.php',
    'ormInstructions' => 
    array (
      'select' => 'SELECT Id, OriginURL, DestinyURL, IsPregReplace, KeepQuerystrings, HTTPCode, HTTPMessage FROM DomainRouteRedirect WHERE Id=:Id;',
      'selectChild' => 
      array (
      ),
      'selectParentId' => 
      array (
      ),
      'attatchWith' => 
      array (
      ),
      'detachWith' => 
      array (
      ),
      'detachWithAll' => 
      array (
      ),
      'oColumn' => 
      array (
      ),
      'singleFK' => 
      array (
      ),
      'collectionFK' => 
      array (
      ),
    ),
  ),
  'DomainUser' => 
  array (
    'modelFilePath' => 'DomainUser.php',
    'ormInstructions' => 
    array (
      'select' => 'SELECT Id, Active, RegisterDate, Name, Gender, Login, ShortLogin, Password FROM DomainUser WHERE Id=:Id;',
      'selectChild' => 
      array (
        'Session' => 
        array (
          'select' => 'SELECT Id as fkId FROM DomainUserSession WHERE DomainUser_Id=:Id;',
          'oColumnFK' => NULL,
          'linkTableName' => NULL,
          'linkTableColumns' => NULL,
        ),
        'Profiles' => 
        array (
          'select' => 'SELECT DomainUserProfile_Id as fkId FROM secdup_to_secdu WHERE DomainUser_Id=:Id;',
          'oColumnFK' => NULL,
          'linkTableName' => 'secdup_to_secdu',
          'linkTableColumns' => 
          array (
            0 => 'DomainUser_Id',
            1 => 'DomainUserProfile_Id',
          ),
        ),
        'BlockedAccess' => 
        array (
          'select' => 'SELECT Id as fkId FROM DomainUserBlockedAccess WHERE DomainUser_Id=:Id;',
          'oColumnFK' => NULL,
          'linkTableName' => NULL,
          'linkTableColumns' => NULL,
        ),
        'RequestLog' => 
        array (
          'select' => 'SELECT Id as fkId FROM DomainUserRequestLog WHERE DomainUser_Id=:Id;',
          'oColumnFK' => NULL,
          'linkTableName' => NULL,
          'linkTableColumns' => NULL,
        ),
      ),
      'selectParentId' => 
      array (
      ),
      'attatchWith' => 
      array (
        'DomainUserSession' => 'UPDATE DomainUserSession SET DomainUser_Id=:thisId WHERE Id=:tgtId;',
        'DomainUserProfile' => 'INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) VALUES (:thisId, :tgtId);',
        'DomainUserBlockedAccess' => 'UPDATE DomainUserBlockedAccess SET DomainUser_Id=:thisId WHERE Id=:tgtId;',
        'DomainUserRequestLog' => 'UPDATE DomainUserRequestLog SET DomainUser_Id=:thisId WHERE Id=:tgtId;',
      ),
      'detachWith' => 
      array (
        'DomainUserSession' => 'UPDATE DomainUserSession SET DomainUser_Id=null WHERE Id=:tgtId;',
        'DomainUserProfile' => 'DELETE FROM secdup_to_secdu WHERE DomainUser_Id=:thisId AND DomainUserProfile_Id=:tgtId;',
        'DomainUserBlockedAccess' => 'UPDATE DomainUserBlockedAccess SET DomainUser_Id=null WHERE Id=:tgtId;',
        'DomainUserRequestLog' => 'UPDATE DomainUserRequestLog SET DomainUser_Id=null WHERE Id=:tgtId;',
      ),
      'detachWithAll' => 
      array (
        'DomainUserSession' => 'UPDATE DomainUserSession SET DomainUser_Id=null WHERE DomainUser_Id=:thisId;',
        'DomainUserProfile' => 'DELETE FROM secdup_to_secdu WHERE DomainUser_Id=:thisId;',
        'DomainUserBlockedAccess' => 'UPDATE DomainUserBlockedAccess SET DomainUser_Id=null WHERE DomainUser_Id=:thisId;',
        'DomainUserRequestLog' => 'UPDATE DomainUserRequestLog SET DomainUser_Id=null WHERE DomainUser_Id=:thisId;',
      ),
      'oColumn' => 
      array (
      ),
      'singleFK' => 
      array (
      ),
      'collectionFK' => 
      array (
      ),
    ),
  ),
  'DomainUserBlockedAccess' => 
  array (
    'modelFilePath' => 'DomainUserBlockedAccess.php',
    'ormInstructions' => 
    array (
      'select' => 'SELECT Id, RegisterDate, UserAgentIP, BlockTimeOut FROM DomainUserBlockedAccess WHERE Id=:Id;',
      'selectChild' => 
      array (
      ),
      'selectParentId' => 
      array (
        'DomainUser' => 'SELECT DomainUser_Id FROM DomainUserBlockedAccess WHERE Id=:thisId;',
      ),
      'attatchWith' => 
      array (
        'DomainUser' => 'UPDATE DomainUserBlockedAccess SET DomainUser_Id=:tgtId WHERE Id=:thisId;',
      ),
      'detachWith' => 
      array (
        'DomainUser' => 'UPDATE DomainUserBlockedAccess SET DomainUser_Id=null WHERE Id=:thisId;',
      ),
      'detachWithAll' => 
      array (
        'DomainUser' => 'UPDATE DomainUserBlockedAccess SET DomainUser_Id=null WHERE Id=:thisId;',
      ),
      'oColumn' => 
      array (
      ),
      'singleFK' => 
      array (
      ),
      'collectionFK' => 
      array (
      ),
    ),
  ),
  'DomainUserProfile' => 
  array (
    'modelFilePath' => 'DomainUserProfile.php',
    'ormInstructions' => 
    array (
      'select' => 'SELECT Id, Active, RegisterDate, Name, Description, AllowAll, HomeURL FROM DomainUserProfile WHERE Id=:Id;',
      'selectChild' => 
      array (
        'DomainUsers' => 
        array (
          'select' => 'SELECT DomainUser_Id as fkId FROM secdup_to_secdu WHERE DomainUserProfile_Id=:Id;',
          'oColumnFK' => NULL,
          'linkTableName' => 'secdup_to_secdu',
          'linkTableColumns' => 
          array (
            0 => 'DomainUserProfile_Id',
            1 => 'DomainUser_Id',
          ),
        ),
        'RoutesPermissions' => 
        array (
          'select' => 'SELECT DomainRoute_Id as fkId FROM secdup_to_secdr WHERE DomainUserProfile_Id=:Id;',
          'oColumnFK' => NULL,
          'linkTableName' => 'secdup_to_secdr',
          'linkTableColumns' => 
          array (
            0 => 'DomainUserProfile_Id',
            1 => 'DomainRoute_Id',
          ),
        ),
      ),
      'selectParentId' => 
      array (
        'DomainApplication' => 'SELECT DomainApplication_Id FROM DomainUserProfile WHERE Id=:thisId;',
      ),
      'attatchWith' => 
      array (
        'DomainApplication' => 'UPDATE DomainUserProfile SET DomainApplication_Id=:tgtId WHERE Id=:thisId;',
        'DomainUser' => 'INSERT INTO secdup_to_secdu (DomainUserProfile_Id, DomainUser_Id) VALUES (:thisId, :tgtId);',
        'DomainRoute' => 'INSERT INTO secdup_to_secdr (DomainUserProfile_Id, DomainRoute_Id) VALUES (:thisId, :tgtId);',
      ),
      'detachWith' => 
      array (
        'DomainApplication' => 'UPDATE DomainUserProfile SET DomainApplication_Id=null WHERE Id=:thisId;',
        'DomainUser' => 'DELETE FROM secdup_to_secdu WHERE DomainUserProfile_Id=:thisId AND DomainUser_Id=:tgtId;',
        'DomainRoute' => 'DELETE FROM secdup_to_secdr WHERE DomainUserProfile_Id=:thisId AND DomainRoute_Id=:tgtId;',
      ),
      'detachWithAll' => 
      array (
        'DomainApplication' => 'UPDATE DomainUserProfile SET DomainApplication_Id=null WHERE Id=:thisId;',
        'DomainUser' => 'DELETE FROM secdup_to_secdu WHERE DomainUserProfile_Id=:thisId;',
        'DomainRoute' => 'DELETE FROM secdup_to_secdr WHERE DomainUserProfile_Id=:thisId;',
      ),
      'oColumn' => 
      array (
      ),
      'singleFK' => 
      array (
      ),
      'collectionFK' => 
      array (
      ),
    ),
  ),
  'DomainUserRequestLog' => 
  array (
    'modelFilePath' => 'DomainUserRequestLog.php',
    'ormInstructions' => 
    array (
      'select' => 'SELECT Id, RegisterDate, UserAgent, UserAgentIP, MethodHttp, FullURL, PostData, ApplicationName, ControllerName, ActionName, Activity, Note FROM DomainUserRequestLog WHERE Id=:Id;',
      'selectChild' => 
      array (
      ),
      'selectParentId' => 
      array (
        'DomainUser' => 'SELECT DomainUser_Id FROM DomainUserRequestLog WHERE Id=:thisId;',
      ),
      'attatchWith' => 
      array (
        'DomainUser' => 'UPDATE DomainUserRequestLog SET DomainUser_Id=:tgtId WHERE Id=:thisId;',
      ),
      'detachWith' => 
      array (
        'DomainUser' => 'UPDATE DomainUserRequestLog SET DomainUser_Id=null WHERE Id=:thisId;',
      ),
      'detachWithAll' => 
      array (
        'DomainUser' => 'UPDATE DomainUserRequestLog SET DomainUser_Id=null WHERE Id=:thisId;',
      ),
      'oColumn' => 
      array (
      ),
      'singleFK' => 
      array (
      ),
      'collectionFK' => 
      array (
      ),
    ),
  ),
  'DomainUserSession' => 
  array (
    'modelFilePath' => 'DomainUserSession.php',
    'ormInstructions' => 
    array (
      'select' => 'SELECT Id, RegisterDate, SessionHash, SessionTimeOut, UserAgent, UserAgentIP, GrantPermission FROM DomainUserSession WHERE Id=:Id;',
      'selectChild' => 
      array (
      ),
      'selectParentId' => 
      array (
        'DomainUser' => 'SELECT DomainUser_Id FROM DomainUserSession WHERE Id=:thisId;',
      ),
      'attatchWith' => 
      array (
        'DomainUser' => 'UPDATE DomainUserSession SET DomainUser_Id=:tgtId WHERE Id=:thisId;',
      ),
      'detachWith' => 
      array (
        'DomainUser' => 'UPDATE DomainUserSession SET DomainUser_Id=null WHERE Id=:thisId;',
      ),
      'detachWithAll' => 
      array (
        'DomainUser' => 'UPDATE DomainUserSession SET DomainUser_Id=null WHERE Id=:thisId;',
      ),
      'oColumn' => 
      array (
      ),
      'singleFK' => 
      array (
      ),
      'collectionFK' => 
      array (
      ),
    ),
  ),
);