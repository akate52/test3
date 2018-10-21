<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Model\StudentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mail;


class StudentController extends Controller
{

    /**
     * 学生列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $students = StudentModel::paginate(5); //分页
        return view('student.index', [
            'students' => $students,
        ]);
    }

    /**
     * 添加-create方法创建
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $studen = new StudentModel();
        if ($request->isMethod('POST')) {
            //1.控制器验证
            /*$this->validate($request, [
                'Student.name' => 'required|min:2|max:20',
                'Student.age'  => 'required|integer',
                'Student.sex'  => 'required|integer',
            ], [
                'required' => ':attribute 为必填项',
                'min'      => ':attribute 长度不符合要求',
                'integer'  => ':attribute 必须为整数'
            ], [
                'Student.name' => '姓名',
                'Student.sex'  => '性别',
                'Student.age'  => '年龄',
            ]);*/
            //2.validate类验证
            $validator = \Validator::make($request->input(), [
                'Student.name' => 'required|min:2|max:20',
                'Student.age'  => 'required|integer',
                'Student.sex'  => 'required|integer',
            ], [
                'required' => ':attribute 为必填项',
                'min'      => ':attribute 长度不符合要求',
                'integer'  => ':attribute 必须为整数'
            ], [
                'Student.name' => '姓名',
                'Student.sex'  => '性别',
                'Student.age'  => '年龄',
            ]);
            //如果有错误就重定向到某个页面,没有错误信息（无自动注册，需手动注册错误信息）
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput(); //withErrors() 错误信息 withInput() 数据保持
            }

            $data = $request->input('Student');
            if (StudentModel::create($data)) {
                return redirect('student/index')->with('success', '添加成功');
            } else {
                return redirect()->back();
            }
        }
        return view('student.create', ['student' => $studen]);
    }


    /**
     * save方法保存数据
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request)
    {
        $data          = $request->input('Student');
        $student       = new StudentModel();
        $student->name = $data['name'];
        $student->age  = $data['age'];
        $student->sex  = $data['sex'];
        if ($student->save()) {
            return redirect('student/index');
        } else {
            return redirect()->back();
        }
    }

    /**
     * 更新数据
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function update(Request $request, $id)
    {
        $student = StudentModel::find($id);

        if ($request->isMethod('POST')) {
            $validator = \Validator::make($request->input(), [
                'Student.name' => 'required|min:2|max:20',
                'Student.age'  => 'required|integer',
                'Student.sex'  => 'required|integer',
            ], [
                'required' => ':attribute 为必填项',
                'min'      => ':attribute 长度不符合要求',
                'integer'  => ':attribute 必须为整数'
            ], [
                'Student.name' => '姓名',
                'Student.sex'  => '性别',
                'Student.age'  => '年龄',
            ]);
            //如果有错误就重定向到某个页面,没有错误信息（无自动注册，需手动注册错误信息）
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput(); //withErrors() 错误信息 withInput() 数据保持
            }
            $data          = $request->input('Student');
            $student->name = $data['name'];
            $student->age  = $data['age'];
            $student->sex  = $data['sex'];
            if ($student->save()) {
                return redirect('student/index')->with('success', '修改成功');
            } else {
                return redirect()->back();
            }
        }

        return view('student.update', [
            'student' => $student
        ]);
    }

    /**
     * 修改数据
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $student = StudentModel::find($id);
        return view('student.detail', ['student' => $student]);
    }

    /**
     * 删除数据
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $student = StudentModel::find($id);
        if ($student->delete()) {
            return redirect('student/index')->with('success', '删除成功');
        } else {
            return redirect('student/index')->with('error', '删除失败');
        }
    }

    public function cache()
    {

        // 1.put() 保存对象到缓存中 无返回值 （key，value，保存时间）
        //Cache::put('key1', 'val1', 10);

        // 2.add() 添加缓存 返回布尔值
        //$bool = Cache::add('key1', 'val1', 10); //如果存在就返回cache
        //dd($bool);

        // 3.forever() 永久保存对象到缓存
        //Cache::forever('key2','val2');

        // 4. has() 判断缓存是否存在
        /*if (Cache::has('key2')) {
            var_dump('key1');
        } else {
            echo 'key1 不存在';
        }*/

        // get() 获取cache 单纯的取
        //echo Cache::get('key1');
        // pull() 获取缓存之后删除
        //echo Cache::pull('key1');
        // forget() 从缓存中删除对象，返回布尔值
        $bool = Cache::forget('key1');
        dd($bool);
    }

    /**
     * 返回错误页面
     */
    public function error()
    {
        $student = null;
        if ($student == null) {
            // abort() 抛出对应错误页面
            abort('503'); //模版放在views/errors/503.blade.php
        }
    }

    /**
     * 生成auth
     * 命令行 php artisan make:auth
     * 数据迁移 php artisan migrate
     *
     * 新建迁移文件
     * 第一种： php artisan make:migration create_student_table 新建一张student表
     * 第二种： 生成模型的同时生成迁移文件 php artisan make:model Student -m
     * 生成文件在database/migrations 下面
     *
     * public function up()
     * {
     * Schema::create('studens', function (Blueprint $table) {
     * $table->increments('id');
     * $table->string('name');
     * $table->integer('age')->unsigned()->default(0);
     * $table->integer('sex')->unsigned()->default(10);
     * $table->integer('created_at')->unsigned()->default(0);
     * $table->integer('updated_at')->unsigned()->default(0);
     * });
     * }
     * 数据填充
     * 1.创建一个填充文件，并完善填充文件
     *  php artisan make:seeder StudentTableSeeder
     *  生成文件在 database/seeds 下面
     * public function run()
     * {
     * DB::table('students')->insert([
     * ['name' => 'lai', 'age' => 18, 'sex' => 10],
     * ['name' => 'fei', 'age' => 20, 'sex' => 20],
     * ]);
     * }
     * 2.指定执行某个填充文件
     * php artisan db:seed --class=StudentTableSeeder
     * 3.批量执行填充文件
     * php artisan db:seed
     * 注意：如果需要批量执行需要把批量执行的文件都引入到DatabaseSeeder.php文件中
     */

    /**
     * 文件上传
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function upload(Request $request)
    {
        if ($request->isMethod('POST')) {
            $file = $request->file('test');
            //判断文件是否上传成功
            if ($file->isValid()) {
                $originalName = $file->getClientOriginalName(); //获取源文件名
                $ext          = $file->getClientOriginalExtension(); //获取扩展名
                $type         = $file->getClientMimeType(); // 获取文件类型
                $path         = $file->getRealPath(); //获取临时文件绝对路径
                $fileName     = date('YmdHis') . uniqid() . $ext;
                //保存文件。调用disk里面的public
                $res = Storage::disk('uploads')->put($fileName, file_get_contents($path));
                dd($res);
            }
        }
        return view('student.upload');
    }

    /**
     * 邮件发送
     */
    public function sendEmail()
    {
        // 1.发送纯文本内容
        Mail::raw('邮件内容', function ($message) {
            $to = 'luanma521@dingtalk.com';
            $message->from('358069268@qq.com', 'lai1');
            $message->subject('邮件主题');
            $message->to($to);
        });
    }

   
    /**
     * 队列流程
     * 迁移队列所需要的数据表 php artisan queue:table 在database/migrations 下面生成一个jobs_table.php文件 执行php artisan migrate
     * 编写任务类 创建任务类 php artisan make:job SendEmail 会在/app 下面生成一个Jobs文件夹 里面有个SendEmail.php类
     * 推送任务到队列 下列代码
     * 运行队列监听器 php artisan queue:listen 进程监控
     * 处理失败任务 php artisan queue:failed-table  在database/migrations 下面生成一个failed_jobs_table.php文件 执行php artisan migrate
     * 如果任务失败会记录到failed_jobs表里面去
     * 查看失败队列信息 php artisan queue:failed
     * 重新指定执行错误队列信息 php artisan queue:retry 1  (1表示失败里面的id)
     * 重新执行错误队列所有信息 php artisan queue:retry all
     * 指定删除错误队列信息 php artisan queue:forget 1 (1表示失败里面的id)
     * 删除所有错误队列信息 php artisan queue:flush
     * 配置文件 config/queue.php
     */
    public function queue()
    {
        //将一个新的任务推送到 Laravel 任务列队
        $to  = 'luanma521@dingtalk.com';
        $res = dispatch(new SendEmail($to));
        if ($res) {
            Log::info('已给' . $to . '发送邮件'); //打印日志 storage/logs/laravel.log
        }
    }


    //活动宣传页面
    public function activity0()
    {
        return '活动快要开始了，敬请期待';
    }

    public function activity1()
    {
        return '互动进行中，1';
    }

    public function activity2()
    {
        return '互动进行中，2';
    }


}
