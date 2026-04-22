<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculatorHistory extends Model
{
    protected $fillable = [
        'user_id', 
        'calculator_type', 
        'input_data', 
        'result_data'
    ];

    protected $casts = [
        'input_data' => 'array',
        'result_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
