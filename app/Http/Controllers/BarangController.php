<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use Carbon\Carbon;
use Cloudinary;

class BarangController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        // $barangs= Barang::all();
        $barangs= Barang::latest()->get();
        
        return view('Barang.index',compact('barangs')); 

    }
    public function cetak(){
        $barangs= Barang::latest()->get();
        return view('Barang.cetak',compact('barangs')); 

    }
    public function create(){
        return view('Barang.create');
    }
    public function store(Request $request){
  
            $fileName = Carbon::now()->format('Y-m-d H:i:s').'-'.$request->judulBarang;
            $uploadedFile = $request->file('gambar')->storeOnCloudinaryAs('frameworkpro',$fileName);

            $gambar = $uploadedFile->getSecurePath();
            $public_id = $uploadedFile->getPublicId();

            // dd($request->all());

            Barang::create([
                'kategori_barang' =>  $request->kategori_barang,
                'nama_barang' => $request->nama_barang,
                'jumlah_stok' => $request->jumlah_stok,
                'gambar' => $gambar,
                'public_id' => $public_id,
            ]);
    

            

            
        // ]);
        return redirect() ->route('barang.index');
    }
    public function destroy($id){
        $barang = Barang::findOrFail($id);
        // dd($barang);
        Cloudinary::destroy($barang->public_id);
        $barang -> delete();
        return redirect() ->route('barang.index');

        
    }
    public function edit($id){
        $barang = Barang::findOrFail($id);
        return view('Barang.edit',compact('barang')); 

    }
    public function update(Request $request,$id){
        $barang = Barang::findOrFail($id);

        if($request->gambar){
            $fileName = Carbon::now()->format('Y-m-d H:i:s').'-'.$request->judulBarang;
            Cloudinary::destroy($barang->public_id);

            $uploadedFile = $request->file('gambar')->storeOnCloudinaryAs('frameworkpro',$fileName);

            $gambar = $uploadedFile->getSecurePath();
            $public_id = $uploadedFile->getPublicId();
        }

        $barang -> update([
            'kategori_barang' => $request -> kategori_barang,
            'nama_barang' => $request -> nama_barang,
            'jumlah_stok' =>$request -> jumlah_stok,
            'gambar' =>$request -> gambar ? $gambar :$barang->gambar,
            'public_id' => $request -> gambar ? $public_id : $barang->public_id


        ]);
        return redirect() ->route('barang.index');

    }
}
