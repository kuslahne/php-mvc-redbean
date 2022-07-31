<?php

namespace app\core;

use RedBeanPHP\Facade as R;

abstract class DbModel extends Model
{
    abstract protected function getAttributes();


    public function save()
    {
        $attributes = implode(", ", $this->getAttributes());
        $values = implode(", ", array_map(fn($a) => ":$a", $this->getAttributes()));
        
        $user = R::dispense( 'user' );
        foreach($this->getAttributes() as $attribute)
        {
            $user[$attribute] = $this->{$attribute};
            if($attribute === "password"){
            	$user[$attribute] = password_hash( $this->{$attribute}, PASSWORD_BCRYPT);
            }
        }
        $id = R::store( $user );
    }

    protected static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    protected function hashPassword($attribute, $value)
    {
        return ($attribute === "password") ? password_hash($value, PASSWORD_BCRYPT) : $value;
    }

    public static function findOne($data)
    {
        $attributes = implode(", ", array_keys($data));       
        $user = R::findOne( 'user', " $attributes = ? ", [ $data[$attributes] ] );

        return $user;        
    }
}




?>
