<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Database;

class PriceAlertController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'alerts';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return  $reference = $this->database->getReference($this->tablename)->getValue();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $postData = [
            'name' => $request->name,
            'price' => $request->price,
        ];
        $postRef = $this->database->getReference($this->tablename)->push($postData);
    }
     /**
     * Show the form for editing the specified resource.
     *@param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $key = $request->key;
       
        return  $singleAlert= $this->database->getReference($this->tablename)->getChild($key)->getValue();
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
        $key = $request->id;
        $postData = [
            'name' => $request->name,
            'price' => $request->price,
        ];
        $ref = $this->database->getReference($this->tablename. '/' . $key)->update($postData);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ref = $this->database->getReference($this->tablename. '/' . $id)->remove();
    }
}
