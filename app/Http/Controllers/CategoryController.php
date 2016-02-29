<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests;
use App;
use Session;

class CategoryController extends Controller
{
    public function manageCategory(){

       $results = App\Category::all();
       $results2 = App\SubCategory::all();

       return view('category')->with ('results', $results)->with ('results2', $results2);
    }

    public function confirmCategory(Request $request){

		if (isset($_POST['add'])) {
			$this->insertCategory($request);
			Session::put('message', '1');
			return redirect('category');
		}
		elseif (isset($_POST['edit'])) {
	        $this->updateCategory($request);
	        Session::put('message', '2');
			return redirect('category');
	    }
	    elseif (isset($_POST['delete'])) {
	        $this->deleteCategory($request);
	        Session::put('message', '3');
			return redirect('category');
	    }
    }

    public function insertCategory(Request $request){

		$category = new App\Category;

		$category->CategoryName = $request->input('add_name');
		$category->Description = $request->input('add_desc');

		try {
			$category->save();
		} catch (Exception $e) {
			Session::put('message', '-1');
			return redirect('category');
		}
	}

	public function updateCategory(Request $request){

		$category = new App\Category;
		$category = App\Category::find($request->input('edit_ID'));

		$category->CategoryName = $request->input('edit_name');
		$category->Description = $request->input('edit_desc');

		try {
			$category->save();
		} catch (Exception $e) {
			Session::put('message', '-1');
			return redirect('category');
		}
	}

	public function deleteCategory(Request $request){
		$category = new App\Category;
		$category = App\Category::find($request->input('del_ID'));
		
		try {
			$category->delete();
		} catch (Exception $e) {
			Session::put('message', '-1');
			return redirect('category');
		}
	}
}
