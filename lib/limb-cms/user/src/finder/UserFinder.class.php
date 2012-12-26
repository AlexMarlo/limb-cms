<?php
lmb_require('lib/limb/dbal/src/criteria/lmbSQLCriteria.class.php');

class UserFinder
{
  static function findById($user_id)
  {
    return User::findById((int)$user_id, false);
  }

  static function findByIds($user_ids)
  {
    if(!count($user_ids))
      return new lmbCollection();

    return User::findByIds($user_ids);
  }

  static function findForEmail($email)
  {
    $criteria = lmbSQLCriteria :: equal('email', $email);
    $criteria->addAnd(new lmbSQLFieldCriteria('is_activated', 0, lmbSQLFieldCriteria::GREATER));
    return lmbActiveRecord::findFirst('User', $criteria);
  }
}