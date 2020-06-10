<?php return array (
  'DomainUser' => 
  array (
    'modelFilePath' => 'DomainUser.php',
    'ormInstructions' => 
    array (
      'select' => 'SELECT Id, Active, RegisterDate, Name, Gender, Login, ShortLogin, Password FROM DomainUser WHERE Id=:Id;',
      'selectChild' => 
      array (
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
      ),
      'selectParentId' => 
      array (
      ),
      'attatchWith' => 
      array (
        'DomainUserProfile' => 'INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) VALUES (:thisId, :tgtId);',
      ),
      'detachWith' => 
      array (
        'DomainUserProfile' => 'DELETE FROM secdup_to_secdu WHERE DomainUser_Id=:thisId AND DomainUserProfile_Id=:tgtId;',
      ),
      'detachWithAll' => 
      array (
        'DomainUserProfile' => 'DELETE FROM secdup_to_secdu WHERE DomainUser_Id=:thisId;',
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
);