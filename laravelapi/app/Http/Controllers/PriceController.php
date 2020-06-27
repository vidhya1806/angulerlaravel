<?php
namespace App\Http\Controllers;
use JWTAuth;
use App\Price;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
        return response()->json(['data' => Price::whereNull('deleted_at')->get()], Response::HTTP_OK);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required|unique:price',
            'price' => 'required|lte:1000'
        ]);
        if ($validator->fails()) {
          return response()->json(['data' => $validator->errors(),'status'=>'error'], Response::HTTP_CREATED);
        }

     $return_arr = Price::create(
        array_merge(
            $request->all(),
            [
                'created_date'=>date('Y-m-d'),
                'updated_date'=>date('Y-m-d'),
                'deleted_date'=>NULL,
                'deleted_by'=>Null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        )
    );
        $message = 'Created Successfully.';
        return response()->json(['data' => $return_arr,'status'=>'success', 'message' => $message], Response::HTTP_CREATED);
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $page=$request->get('page');
        $count=$request->get('count');
        $start=($page * $count) - ($count);
        $search=$request->get('search');
        $order=$request->get('order');
          $columns = array (
                 0 =>'id',
                 1=>'name',
                 2=>'code',
                 3=>'price'
       );
       
        $orders1 = Price::select('*');
         $totalData = $orders1->count(); 
         $totalFiltered = $totalData; 
         $getdata = Price::whereNull('deleted_at');
           if ($request->has('search')) {
                if ($search != '') {
                       $getdata->where('name', 'Like','%' .$search. '%')->orWhere('code', 'Like','%' .$search. '%')->orWhere('inactive', 'Like','%' .$search. '%');
                }
           }
           if($request->has('order')) {
             if ($order!= '') {
                 $column=$order[0]['column'];
                 $dir=$order[0]['dir'];
                 $orderColumn = $column;
                 $orderDirection =  $dir;
                 $getdata->orderBy($columns [intval( $orderColumn )], $orderDirection);
             }
         }
      
           $totalFiltered = $getdata->count();
           $getdata = $getdata->skip($start)->take($count);
      
       $getdata= $getdata->get();
       
        $tableContent = array (
                 "recordsTotal" => intval($totalData), 
                 "recordsFiltered" => intval($totalFiltered), 
                 "data" => $getdata
         );
        return response()->json(['data' => $tableContent],Response::HTTP_OK);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => "required|unique:price,code,{$id}",
            'price' => 'required|lte:1000'
        ]);
        if ($validator->fails()) {
          return response()->json(['data' => $validator->errors(),'status'=>'error'], Response::HTTP_CREATED);
        }
     $return_arr = Price::find($id)->update(
        array_merge(
            $request->all(),
            [
                'created_date'=>date('Y-m-d'),
                'updated_date'=>date('Y-m-d'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        )
    );
    $message = 'Updated Successfully.';
    return response()->json(['data' => $return_arr ,'status'=>'success','message' => $message], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $return_arr = Price::find($request->id)->delete();
        $message = 'deleted successfully.';
        return response()->json(['data' => $return_arr, 'message' => $message], Response::HTTP_OK);
    }
}
