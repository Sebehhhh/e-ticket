<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCode extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'code'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}