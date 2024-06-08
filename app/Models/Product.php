<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="ProductModel",
 *     title="Product Model",
 *     description="Represents a product",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int32",
 *         description="Book ID"
 *     ),
 *
 *     @OA\Property(
 *         property="title",
 *         type="integer",
 *         format="int32",
 *         description="Category ID"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Book title"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="string",
 *         description="Book author"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="integer",
 *         format="int32",
 *         description="Book price"
 *     ),
 *    @OA\Property(
 *         property="inventory",
 *         type="integer",
 *         format="int32",
 *         description="Book price"
 *     ),
 *   @OA\Property(
 *         property="viewcount",
 *         type="integer",
 *         format="int32",
 *         description="Book price"
 *      ),
 *    @OA\Property(
 *         property="discount",
 *         type="integer",
 *         format="int32",
 *         description="Book price"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation date"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Update date"
 *     )
 * )
 */
class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'inventory',
        'view_count',
        'discount',
    ];
}
