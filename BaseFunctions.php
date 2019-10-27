<?php
namespace GreenPigDAO;


trait BaseFunctions
{
    public function strToDate($aliasForStrDate, $format = false)
    {
        $sql = '';
        if (!$format) $format = $this->settings['functions']['formatToDate'];
        if (trim(strtolower($this->settings['nameDatabase'])) == 'oracle') $sql = " TO_DATE($aliasForStrDate, '$format') ";
        if (trim(strtolower($this->settings['nameDatabase'])) == 'mysql') $sql = " STR_TO_DATE($aliasForStrDate, '$format') ";
        if ($sql) return $sql;
        else throw new Exception('В settings.php неверно указано название базы данных.');
    }



    /**
     * Генерим случайную строку длиной $length
     * @param int $length
     * @return string
     */
    public function genStr($length = 10){
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }


    public function isClass($object, $nameClass)
    {
        $classObject = get_class($object);
        $classObject = substr($classObject, strrpos($classObject, '\\') + 1);
        return $classObject === $nameClass;
    }

}