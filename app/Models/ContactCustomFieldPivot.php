<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactCustomFieldPivot extends Model
{
    protected $fillable = ['contact_id', 'custom_field_id', 'field_value', 'is_merge', 'merged_id'];
}
