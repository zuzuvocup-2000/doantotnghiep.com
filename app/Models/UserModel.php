<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model{
    protected $table = 'user';

    protected $allowedFields = [
        'catalogueid',
        'email',
        'phone',
        'password',
        'fullname',
        'image',
        'gender',
        'address',
        'cityid',
        'districtid',
        'wardid',
        'birthday',
        'job',
        'created_at',
        'updated_at',
        'userid_created',
        'userid_updated',
        'publish',
        'deleted_at',
    ];
}