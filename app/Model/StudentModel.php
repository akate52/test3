<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudentModel extends Model
{
    const SEX_UN = 10;//未知
    const SEX_BOY = 20;//男
    const SEX_GIRL = 30;//女
    //设置表
    public $timestamps = true;
    //自动维护时间
    protected $table = 'student';
    //create批量赋值
    protected $fillable = ['name', 'age', 'sex'];

    public function getDateFormat()
    {
        return time();
    }

    /*protected function asDateTime($value)
    {
        return $value;
    }*/

    public function sexs($ind = null)
    {
        $arr = [
            self::SEX_UN   => '未知',
            self::SEX_BOY  => '男',
            self::SEX_GIRL => '女'
        ];

        if ($ind != null) {
            return array_key_exists($ind, $arr) ? $arr[$ind] : $arr[self::SEX_UN];
        }

        return $arr;
    }
}
