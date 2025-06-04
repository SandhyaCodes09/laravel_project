<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\Mcq;



class AdminController extends Controller
{
    //login function

    function login(Request $request)
    {
        $validation = $request->validate([
            "name" => "required",
            "password" => "required",

        ]);

        $admin = Admin::where([
            ['name', "=", $request->name],
            ['password', "=", $request->password],
        ])->first();

        // return $admin;
        // return $admin->name;

        if (!$admin) {
            $validation = $request->validate([
                "user" => "required",
            ], [
                "user.required" => "User does not exits",
            ]);
        }

        Session::put('admin', $admin);
        return redirect('admin-dashboard');
    }

    // dashboard function

    function dashboard()
    {
        $admin = Session::get('admin');

        if ($admin) {
            return view('admin', ["name" => $admin->name]);
        } else {
            return redirect('admin-login');
        }
    }

    // categories function

    function categories()
    {
        $categories = Category::get();
        $admin = Session::get('admin');

        if ($admin) {
            return view('categories', ["name" => $admin->name, "categories" => $categories]);
        } else {
            return redirect('admin-login');
        }
    }
    // logout function

    function logout()
    {
        session::forget('admin');
        return redirect('admin-login');
    }

    //category function
    function addCategory(Request $request)
    {
        $validation = $request->validate([
            "category" => "required | min:3 | unique:categories,name"
        ]);
        $admin = Session::get('admin');
        $category = new Category();
        $category->name = $request->category;
        $category->creator = $admin->name;
        if ($category->save()) {
            // return "done";
            Session::flash('category', "Success: Category " . $request->category . " Added.");
        }
        return redirect('admin-categories');
    }


    // delete category

    function deleteCategory($id)
    {
        // return $id;
        $isDelete = Category::find($id)->delete();
        if ($isDelete) {
            Session::flash('category', "Success: Category Deleted.");
            return redirect('admin-categories');
        }
    }

    // add quiz controller

    function addQuiz()
    {
        // return  Session::get('admin');
        $categories = Category::get();
        $admin = Session::get('admin');
        $totalMCQs=0;

        if ($admin) {
            $quizName = request('quiz');
            $category_id = request('category_id');

            if ($quizName && $category_id && !Session::has('quizDetails')) {
                $quiz = new Quiz();
                $quiz->name = $quizName;
                $quiz->category_id = $category_id;
                if ($quiz->save()) {
                    Session::put('quizDetails', $quiz);
                }
            }else{
                $quiz = Session::get('quizDetails');
                $totalMCQs = $quiz && Mcq::where('quiz_id',$quiz->id)->count();
            }

            return view('add-quiz', ["name" => $admin->name, "categories" => $categories,"totalMCQs"=>$totalMCQs]);
        } else {
            return redirect('admin-login');
        }
    }

    function addMCQs(Request $request)
    {
        // return $request;
        $request->validate([
            "question" => "required | min:5",
            "a" => "required ",
            "b" => "required",
            "c" => "required",
            "d" => "required",
            "correct_ans" => "required",


        ]);
        $mcq = new Mcq();
        $quiz = Session::get('quizDetails');
        $admin = Session::get('admin');

        $mcq->question = $request->question;
        $mcq->a = $request->a;
        $mcq->b = $request->b;
        $mcq->c = $request->c;
        $mcq->d = $request->d;
        $mcq->correct_ans = $request->correct_ans;

        $mcq->admin_id = $admin->id;
        $mcq->quiz_id = $quiz->id;
        $mcq->category_id = $quiz->category_id;

        if ($mcq->save()) {
            if ($request->submit == "add-more") {
                return redirect(url()->previous());
            } else {
                Session::forget('quizDetails');
                return redirect("/admin-categories");
            }
        }
    }

    function endQuiz()
    {
        Session::forget('quizDetails');
        return redirect("/admin-categories");
    }

    function showQuiz($id){
        $admin = Session::get('admin');
       $mcqs = Mcq::where('quiz_id',$id)->get();
       
        if ($admin) {
            return view('show-quiz', ["name" => $admin->name, "mcqs" => $mcqs]);
        } else {
            return redirect('admin-login');
        }

    }
}
