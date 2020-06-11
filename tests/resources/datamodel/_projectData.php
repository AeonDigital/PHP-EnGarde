<?php return array (
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
      'select' => 'SELECT Id, Active, RegisterDate, ApplicationName, Name, Description FROM DomainUserProfile WHERE Id=:Id;',
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
      ),
      'selectParentId' => 
      array (
      ),
      'attatchWith' => 
      array (
        'DomainUser' => 'INSERT INTO secdup_to_secdu (DomainUserProfile_Id, DomainUser_Id) VALUES (:thisId, :tgtId);',
      ),
      'detachWith' => 
      array (
        'DomainUser' => 'DELETE FROM secdup_to_secdu WHERE DomainUserProfile_Id=:thisId AND DomainUser_Id=:tgtId;',
      ),
      'detachWithAll' => 
      array (
        'DomainUser' => 'DELETE FROM secdup_to_secdu WHERE DomainUserProfile_Id=:thisId;',
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
      'select' => 'SELECT Id, RegisterDate, UserAgent, UserAgentIP, MethodHTTP, FullURL, PostData, ApplicationName, ControllerName, ActionName, Activity, Note FROM DomainUserRequestLog WHERE Id=:Id;',
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