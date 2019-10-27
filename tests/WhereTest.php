<?php

require_once __DIR__ .'/../Where.php';


class WhereTest extends PHPUnit_Framework_TestCase
{
    // ========== linkOr() и linkAnd() ==========
    // --- при использовании одного массива, без вложенности, в случае если содержит одну логическую операцию ---
    public function test_linkOr_oneArray() {
        $wh = new Where();
        $wh->linkOr(['t.a', '=', 2])->generate();
        $temp = $this->converterRawTempInTemp($wh->getBind(), " t.a  =  |-=alias=-| ", [2]);
        $this->assertEquals($temp['sql'], $wh->getSql());
        $this->assertEquals($temp['binds'], $wh->getBind());
    }

    public function test_linkAnd_oneArray() {
        $wh = new Where();
        $wh->linkAnd(['t.a', '=', 'sql' => 'SIN(:x)', 'bind' => ['x'=>1]])->generate();
        $temp = $this->converterRawTempInTemp($wh->getBind(), " t.a  =  SIN(:x) ", [1]);
        $this->assertEquals($temp['sql'], $wh->getSql());
        $this->assertEquals($temp['binds'], $wh->getBind());
    }

//    private function _oneArray($wh) {
//        $temp = $this->converterRawTempInTemp($wh->getBind(), " t.a  =  |-=alias=-| ", [2]);
//        $this->assertEquals($temp['sql'], $wh->getSql());
//        $this->assertEquals($temp['binds'], $wh->getBind());
//    }



    // --- простой случай с несколькими логическими операциями ---
    public function test_linkOr() {
        $wh = new Where();
        $wh->linkOr([
                ['t.a', '>', 1],
                ['t.b', '=', 2],
                ['t.c', '<>', 3],
                ['t.d', '   like ', '%qaz']
            ])->generate();
        $temp = $this->converterRawTempInTemp($wh->getBind(),
            " t.a  >  |-=alias=-|  or  t.b  =  |-=alias=-|  or  t.c  <>  |-=alias=-|  or  t.d     like   |-=alias=-| ",
            [1, 2, 3, '%qaz']);
        $this->assertEquals($temp['sql'], $wh->getSql());
        $this->assertEquals($temp['binds'], $wh->getBind());
    }

    public function test_linkAnd() {
        $wh = new Where();
        $wh->linkAnd([
            ['t.a', '>', 1],
            ['t.b', '=', 2],
            ['t.c', '<>', 3],
            ['t.d', '   like ', '%qaz']
        ])->generate();
        $temp = $this->converterRawTempInTemp($wh->getBind(),
            " t.a  >  |-=alias=-|  and  t.b  =  |-=alias=-|  and  t.c  <>  |-=alias=-|  and  t.d     like   |-=alias=-| ",
            [1, 2, 3, '%qaz']);
        $this->assertEquals($temp['sql'], $wh->getSql());
        $this->assertEquals($temp['binds'], $wh->getBind());
    }



    // --- использование c ключами sql и bind ---
    public function test_linkOr_keySqlBind() {
        $wh = new Where();
        $number = -199;
        $wh->linkOr(['ABS(t.number)', '>', 'sql' => "ABS(:number)", 'bind' => ['number' => $number]])->generate();
        $this->_keySqlBind($wh);
    }

    public function test_linkAnd_keySqlBind() {
        $wh = new Where();
        $number = -199;
        $wh->linkAnd(['ABS(t.number)', '>', 'sql' => "ABS(:number)", 'bind' => ['number' => $number]])->generate();
        $this->_keySqlBind($wh);
    }

    private function _keySqlBind($wh) {
        $temp = $this->converterRawTempInTemp($wh->getBind(), " ABS(t.number)  >  ABS(|-=alias=-|) ", [-199]);
        $this->assertEquals($temp['sql'], $wh->getSql());
        $this->assertEquals($temp['binds'], $wh->getBind());
    }



    // --- оператор between числа ---
    public function test_linkOr_intBetween() {
        $wh = new Where();
        $wh->linkOr(['t.a', ' BetWeeN', 1, 10])->generate();
        $this->_intBetween($wh);
    }

    public function test_linkAnd_intBetween() {
        $wh = new Where();
        $wh->linkAnd(['t.a', ' BetWeeN', 1, 10])->generate();
        $this->_intBetween($wh);
    }

    private function _intBetween($wh) {
        $temp = $this->converterRawTempInTemp($wh->getBind()," t.a   BetWeeN  |-=alias=-| and |-=alias=-| ", [1, 10]);
        $this->assertEquals($temp['sql'], $wh->getSql());
        $this->assertEquals($temp['binds'], $wh->getBind());
    }



    // --- оператор between даты ---
    public function test_linkOr_dateBetween() {
        $wh = new Where();
        $wh->linkOr(['t.a', ' BetWeeN', '12.02.2019', '12.06.2019'])->generate();
        $this->_dateBetween($wh);
    }

    public function test_linkAnd_dateBetween() {
        $wh = new Where();
        $wh->linkAnd(['t.a', ' BetWeeN', '12.02.2019', '12.06.2019'])->generate();
        $this->_dateBetween($wh);
    }

    private function _dateBetween($wh) {
        $sql = " t.a   BetWeeN  ". $wh->strToDate('|-=alias=-|') ." and ".
            $wh->strToDate('|-=alias=-|') ." ";
        $temp = $this->converterRawTempInTemp($wh->getBind(), $sql, ['12.02.2019', '12.06.2019']);
        $this->assertEquals($temp['sql'], $wh->getSql());
        $this->assertEquals($temp['binds'], $wh->getBind());
    }



    // --- оператор in ---
    public function test_linkOr_in() {
        $wh = new Where();
        $wh->linkOr(['t.a', ' iN  ', [12, 34, 'qaz', 0]])->generate();
        $this->_in($wh);
    }

    public function test_linkAnd_in() {
        $wh = new Where();
        $wh->linkAnd(['t.a', ' iN  ', [12, 34, 'qaz', 0]])->generate();
        $this->_in($wh);
    }

    private function _in($wh) {
        $temp = $this->converterRawTempInTemp(
            $wh->getBind(),
            " t.a   iN    ( |-=alias=-| ,  |-=alias=-| ,  |-=alias=-| ,  |-=alias=-| ) ",
            [12, 34, 'qaz', 0]);
        $this->assertEquals($temp['sql'], $wh->getSql());
        $this->assertEquals($temp['binds'], $wh->getBind());
    }
    // ===============================================================================



    // --- fullFlex ---
    public function test_fullFlex() {
        $wh = new Where();
        $wh->linkAnd($wh->fullFlex('t.a', 'bfg'))->generate();

        $temp = $this->converterRawTempInTemp(
            $wh->getBind(),
            " LOWER(t.a)  like  LOWER(|-=alias=-|) ",
            ['%bfg%']);
        $this->assertEquals($temp['sql'], $wh->getSql());
        $this->assertEquals($temp['binds'], $wh->getBind());
    }



    // --- repStar ---
    public function test_repStar() {
        $wh = new Where();
        $this->assertEquals('  f%Fff %%%%%%%5       *  % d  %%%%%',
                    $wh->repStar('  f%Fff %*****%5       \*  * d  *****'));
    }



    // Составной, включающий все элементы тест
    public function test_global() {
        $wh = new Where();
        $sqlTemp = " ( core  =  |-=alias=-|  or  core  =  |-=alias=-| )  and  size_ram  between  |-=alias=-| and |-=alias=-|  and  mark_motherboard  in  ( |-=alias=-| ,  |-=alias=-| ,  |-=alias=-| ,  |-=alias=-| )  and  build_date  between   TO_DATE(|-=alias=-|, 'dd.mm.yyyy hh24:mi::ss')  and  TO_DATE(|-=alias=-|, 'dd.mm.yyyy hh24:mi::ss')   and  avg(build_rating)  >=  abs(|-=alias=-|)  and  LOWER(author_build)  like  LOWER(|-=alias=-|) ";
        $wh->linkAnd([
            $wh->linkOr([ ['core', '=', 'i5'], ['core', '=', 'i7'] ])->getRaw(),
            ['size_ram', 'between', 4, 32],
            ['mark_motherboard', 'in', ['ASUS', 'GIGABYTE', 'Intel', 'MSI'] ],
            ['build_date', 'between', '01.01.2016', '01.01.2019'],
            ['avg(build_rating)', '>=', 'sql' => 'abs(:x)', 'bind' => ['x' => 3]],
            $wh->fullFlex('author_build', 'Вася')
        ])->generate();
        $temp = $this->converterRawTempInTemp($wh->getBind(), $sqlTemp, ['i5', 'i7', 4, 32, 'ASUS', 'GIGABYTE', 'Intel', 'MSI', '01.01.2016', '01.01.2019', 3, '%Вася%']);
        $this->assertEquals($temp['sql'], $wh->getSql());
        $this->assertEquals($temp['binds'], $wh->getBind());
    }



    // тест с множеством вложенных скобок
    public function test_nestedBrackets() {
        $wh = new Where();
        $sqlTemp = " core  =  |-=alias=-|  or  ( core  =  |-=alias=-|  and  orm  =  |-=alias=-|  and  ( LOWER(mark_monitor)  like  LOWER(|-=alias=-|)  or  ( LOWER(mark_monitor)  like  LOWER(|-=alias=-|)  and  diagonal  =  |-=alias=-| ) ) ) ";
        $wh->linkOr([
            ['core', '=', 'i7'],
            $wh->linkAnd([
                ['core', '=', 'i5'],
                ['orm', '=', '64'],
                $wh->linkOr([
                    $wh->fullFlex('mark_monitor', 'apple'),
                    $wh->linkAnd([
                        $wh->fullFlex('mark_monitor', 'samsung'),
                        ['diagonal', '=', 27]
                    ])->getRaw()
                ])->getRaw()
            ])->getRaw()
        ])->generate();
        $temp = $this->converterRawTempInTemp($wh->getBind(), $sqlTemp, ['i7', 'i5', 64, '%apple%', '%samsung%', 27]);
        $this->assertEquals($temp['sql'], $wh->getSql());
        $this->assertEquals($temp['binds'], $wh->getBind());
    }



    // ========== вспомогательные функции ==========

    /**
     * Функция подставляет на место |-=alias=-| алиасы, которые сгенерились в результате выполнения функции generate()
     * @param $binds array          сгенеренный ассоциативный массив биндов
     * @param $sqlTemplate string   sql шаблон в котором еще надо подставить настоящие алиасы
     * @param $bindsTemplate array  одноиерный массив в котором только значения биндов
     * @return array  1) sql - эталонный sql с подставленными алиасами из сгенеренного sql
     *                2) binds - асоциативный массив, сформированный из ключей $binds и значений $bindsTemplate
     */
    private function converterRawTempInTemp($binds, $sqlTemplate, $bindsTemplate) {
        $bindsResult = [];
        $i = 0;
        foreach ($binds as $key => $val) {
            $sqlTemplate = $this->strReplaceOnce('|-=alias=-|', ':'.$key, $sqlTemplate);
            $bindsResult[$key] = $bindsTemplate[$i++];
        }
        return ['sql' => $sqlTemplate, 'binds' => $bindsResult];
    }

    private function strReplaceOnce($search, $replace, $text)
    {
        $pos = strpos($text, $search);
        return $pos!==false ? substr_replace($text, $replace, $pos, strlen($search)) : $text;
    }

}