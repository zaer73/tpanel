<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = ['question', 'answer'];

    protected $appends = ['create_date'];

    public function getCreateDateAttribute(){
        $created_at = $this->attribute['created_at'];
        return jalali($created_at);
    }
}
