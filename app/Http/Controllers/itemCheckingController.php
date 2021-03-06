<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App;
use App\Models\Admin;
use Session;
use Carbon\Carbon;

class ItemCheckingController extends Controller
{
    public function itemCheck(Request $request){
        if(isset($_POST['Uncheck'])){
            $this->uncheck($request);
            return redirect('itemChecking');
        } else if(isset($_POST['Check'])){
            $this->check($request);
            return redirect('itemChecking');
        }
    }

    public function uncheck(Request $request){
        try {
            $item = App\Models\Admin\Item::find($request->input('itemID'));
            
            $item->status = 2;

            if($request->defect == "null"){
                $item->DefectDescription = $request->defectDesc;
            }
            else if($request->defect == "none"){
                $item->DefectDescription = 'None';
            }
            else {
                $item->ItemDefectID = $request->defect;
                $item->DefectDescription = $request->defectDesc;
            }

            if($request->hasFile('add_photo')){
                $filename = rand(1000,100000)."-".$request->file('add_photo')->getClientOriginalName();
                $filepath = "photos/";
                $request->file('add_photo')->move($filepath, $filename);
                $item->image_path = $filepath.$filename;
            }

            $item->save();

            $this->ItemLog(
                $item, 
                "Item successfully checked"
                );

            return redirect('itemChecking');

        } catch (Exception $e) {
            return redirect('itemChecking');
        }
    }

    public function check(Request $request){
        try {
            $item = App\Models\Admin\Item::find($request->input('itemID2'));

            if($request->defect == "null"){
                $item->DefectDescription = $request->defectDesc;
            }
            else if($request->defect == "none"){
                $item->ItemDefectID = NULL;
                $item->DefectDescription = 'None';
            }
            else {
                $item->ItemDefectID = $request->defect;
                $item->DefectDescription = $request->defectDesc;
            }

            if($request->hasFile('add_photo')){
                $filename = rand(1000,100000)."-".$request->file('add_photo')->getClientOriginalName();
                $filepath = "photos/";
                $request->file('add_photo')->move($filepath, $filename);
                $item->image_path = $filepath.$filename;
            }

            $item->save();

            $this->ItemLog(
                $item, 
                "Item successfully defect description and/or image updated"
                );

            return redirect('itemChecking');

        } catch (Exception $e) {
            return redirect('itemChecking');
        }

    }
}
