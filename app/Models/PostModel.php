<?php 
namespace App\Models;
use CodeIgniter\Model;
class PostModel extends Model
{
    protected $table = 'post';
    protected $primaryKey = 'post_id';
    protected $allowedFields = ['category', 'headtitle', 'body', 'image_path', 'creator_id'];
}