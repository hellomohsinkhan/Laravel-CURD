<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;


class ItemCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Item::orderBy('id','DESC')->paginate(5);
        return view('ItemCRUD.index',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ItemCRUD.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'brand_name' => 'required',
            'model_name' => 'required',
            'price' => 'required|numeric',
        ]); 
        $image = $request->file('image');         
        $fileName = $image->getClientOriginalName();
        $fileExtension = $image->getClientOriginalExtension();
        // $imageName = date('dmY').'.'.$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(
        base_path() . '/public/images/', $fileName);
        $requestData = $request->all();
        $requestData['image'] = $fileName;
        Item::create($requestData);
        return redirect()->route('itemCRUD.index')
                        ->with('success','Item created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        return view('ItemCRUD.show',compact('item'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        return view('ItemCRUD.edit',compact('item'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'brand_name' => 'required',
            'model_name' => 'required',
            'price' => 'required',
        ]);

        Item::find($id)->update($request->all());
        return redirect()->route('itemCRUD.index')
                        ->with('success','Item updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::find($id)->delete();
        return redirect()->route('itemCRUD.index')
                        ->with('success','Item deleted successfully');
    }
}
?>