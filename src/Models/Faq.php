<?php

namespace Mohan9a\AdminlteFaq\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    // Disable Laravel's mass assignment protection
    protected $guarded = [];

    public function highestOrderItem()
    {
        $order = 1;

        $item = $this->orderBy('order', 'DESC')->first();

        if (!is_null($item)) {
            $order = intval($item->order) + 1;
        }

        return $order;
    }

}
