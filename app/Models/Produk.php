<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function barang_masuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
    public function transacton()
    {
        return $this->hasMany(Transaction::class);
    }
}
