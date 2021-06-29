<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    // public $guarded = [];
    protected $table = "barangs";
    protected $primaryKet = "id";
    protected $fillable = [
        'id', 'kategori_barang', 'nama_barang', 'jumlah_stok', 'gambar','public_id'
    ];

}
