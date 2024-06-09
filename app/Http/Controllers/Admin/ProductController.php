<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
    * @OA\Get(
    *     path="/admin/product",
    *     tags={"Admin Product"},
    *     summary="listAllItem",
    *     description="list all Item",
    *     @OA\Parameter(
    *         name="page",
    *         in="query",
    *         required=true,
    *         @OA\Schema(
    *             type="string",
    *             default="1"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Success Message",
    *         @OA\JsonContent(
    *             @OA\Property(
    *                 property="current_page",
    *                 type="integer",
    *                 format="int32",
    *                 description="Current page number"
    *             ),
    *             @OA\Property(
    *                 property="data",
    *                 type="array",
    *                 @OA\Items(ref="#/components/schemas/ProductModel"),
    *                 description="List of item"
    *             ),
    *             @OA\Property(
    *                 property="first_page_url",
    *                 type="string",
    *                 format="uri",
    *                 description="First page URL"
    *             ),
    *             @OA\Property(
    *                 property="from",
    *                 type="integer",
    *                 format="int32",
    *                 description="First item number in the current page"
    *             ),
    *             @OA\Property(
    *                 property="last_page",
    *                 type="integer",
    *                 format="int32",
    *                 description="Last page number"
    *             ),
    *             @OA\Property(
    *                 property="links",
    *                 type="array",
    *                 @OA\Items(
    *                     oneOf={
    *                         @OA\Schema(ref="#/components/schemas/Previous"),
    *                         @OA\Schema(ref="#/components/schemas/Links"),
    *                         @OA\Schema(ref="#/components/schemas/Next")
    *                     }
    *                 ),
    *                 description="Links"
    *             ),
    *             @OA\Property(
    *                 property="last_page_url",
    *                 type="string",
    *                 format="uri",
    *                 description="Last page URL"
    *             ),
    *             @OA\Property(
    *                 property="next_page_url",
    *                 type="string",
    *                 format="uri",
    *                 description="Next page URL"
    *             ),
    *             @OA\Property(
    *                 property="path",
    *                 type="string",
    *                 description="Path"
    *             ),
    *             @OA\Property(
    *                 property="per_page",
    *                 type="integer",
    *                 format="int32",
    *                 description="Items per page"
    *             )
    *         ),
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="an ""unexpected"" error",
    *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
    *     ),security={{"api_key": {}}}
    * )
    * Display the specified resource.
    */
    public function index()
    {
        return $this->success(Product::latest()->paginate(20));
    }

    /**
        * @OA\Post(
        *     path="/admin/product",
        *     tags={"Admin Product"},
        *     summary="MakeOneItem",
        *     description="make one Item",
        *     @OA\RequestBody(
        *         description="tasks input",
        *         required=true,
        *         @OA\JsonContent(
        *             @OA\Property(
        *                 property="user_id",
        *                 type="string",
        *                 description="user_id",
        *                 example="Item name"
        *             ),
        *             @OA\Property(
        *                 property="title",
        *                 type="string",
        *                 description="title",
        *                 example="Item name"
        *             ),
        *             @OA\Property(
        *                 property="description",
        *                 type="string",
        *                 description="description",
        *                 default="null",
        *                 example="writer Item",
        *             ),
        *             @OA\Property(
        *                 property="price",
        *                 type="integer",
        *                 description="price",
        *                 default="null",
        *                 example=0,
        *             ),
        *             @OA\Property(
        *                 property="image",
        *                 type="string",
        *                 description="image",
        *                 default="null",
        *                 example=0,
        *             ),
        *             @OA\Property(
        *                 property="inventory",
        *                 type="integer",
        *                 description="inventory",
        *                 default="null",
        *                 example=0,
        *             ),
        *             @OA\Property(
        *                 property="view_count",
        *                 type="integer",
        *                 description="view_count",
        *                 default="null",
        *                 example=0,
        *             ),
        *             @OA\Property(
        *                 property="discount",
        *                 type="integer",
        *                 description="discount",
        *                 default="null",
        *                 example=0,
        *             ),
        *         )
        *     ),
        *     @OA\Response(
        *         response=200,
        *         description="Success Message",
        *         @OA\JsonContent(ref="#/components/schemas/ProductModel"),
        *     ),
        *     @OA\Response(
        *         response=400,
        *         description="an 'unexpected' error",
        *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
        *     ),security={{"api_key": {}}}
        * )
        * Make a product
        */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required',
            'title'   => 'required',
            'description'  => 'required',
            'price'   => 'required|numeric',
            'image' => 'required|string',
            'inventory' => 'required|integer',
            'view_count' => 'required|integer',
            'discount' => 'required|integer',
        ]);

        try {
            $book = product::create($request->all());
            return $this->success($book);
        } catch(Exception $e) {
            Log::error($e->getMessage());
            return $this->error('category not created');
        }
    }

    /**
    * @OA\Get(
    *     path="/admin/product/{id}",
    *     tags={"Admin Product"},
    *     summary="getOneProduct",
    *     description="get One Product",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Success Message",
    *         @OA\JsonContent(ref="#/components/schemas/ProductModel"),
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="an ""unexpected"" error",
    *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
    *     ),security={{"api_key": {}}}
    * )
    * Display the specified resource.
    */
    public function show(Int $id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json($product);
        } catch(Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Product not found'], 400);
        }
    }

    /**
        * @OA\Put(
        *     path="/admin/product/{id}",
        *     tags={"Admin Product"},
        *     summary="EditOneItem",
        *     description="edit one Item",
        *     @OA\Parameter(
        *         name="id",
        *         in="path",
        *         required=true,
        *         @OA\Schema(
        *             type="integer"
        *         )
        *     ),
        *     @OA\RequestBody(
        *         description="tasks input",
        *         required=true,
        *         @OA\JsonContent(
        *             @OA\Property(
        *                 property="user_id",
        *                 type="string",
        *                 description="user_id",
        *                 example="Item id"
        *             ),
        *             @OA\Property(
        *                 property="title",
        *                 type="string",
        *                 description="title",
        *                 default="null",
        *                 example="writer Item",
        *             ),
        *             @OA\Property(
        *                 property="description",
        *                 type="integer",
        *                 description="description",
        *                 default="null",
        *                 example="description",
        *             ),
         *             @OA\Property(
        *                 property="price",
        *                 type="integer",
        *                 description="price",
        *                 default="null",
        *                 example="price",
        *             ),
         *             @OA\Property(
        *                 property="image",
        *                 type="string",
        *                 description="image",
        *                 default="null",
        *                 example="image",
        *             ),
         *             @OA\Property(
        *                 property="inventory",
        *                 type="integer",
        *                 description="inventory",
        *                 default="null",
        *                 example="inventory",
        *             ),
         *             @OA\Property(
        *                 property="view_count",
        *                 type="integer",
        *                 description="view_count",
        *                 default="null",
        *                 example="view_count",
        *             ),
         *             @OA\Property(
        *                 property="discount",
        *                 type="integer",
        *                 description="discount",
        *                 default="null",
        *                 example="discount",
        *             ),
        *         )
        *     ),
        *     @OA\Response(
        *         response=200,
        *         description="Success Message",
        *         @OA\JsonContent(ref="#/components/schemas/ProductModel"),
        *     ),
        *     @OA\Response(
        *         response=400,
        *         description="an 'unexpected' error",
        *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
        *     ),security={{"api_key": {}}}
        * )
        * Update the specified resource in storage.
        */
    public function update(Request $request, Int $id)
    {
        $request->validate([
           'user_id'   => 'required',
            'title'   => 'required',
            'description'  => 'required',
            'price'   => 'required|numeric',
            'image' => 'required|string',
            'inventory' => 'required|integer',
            'view_count' => 'required|integer',
            'discount' => 'required|integer',
        ]);

        try {
            $product = product::findOrFail($id);
            $product->update($request->all());
            return response()->json($product);
        } catch(Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'product not update'], 400);
        }
    }
    /**
        * @OA\Delete(
        *     path="/admin/product/{id}",
        *     tags={"Admin Product"},
        *     summary="DeleteOneItem",
        *     description="Delete one Item",
        *     @OA\Parameter(
        *         name="id",
        *         in="path",
        *         required=true,
        *         @OA\Schema(
        *             type="integer"
        *         )
        *     ),
        *     @OA\Response(
        *         response=200,
        *         description="Success Message",
        *         @OA\JsonContent(ref="#/components/schemas/SuccessModel"),
        *     ),
        *     @OA\Response(
        *         response=400,
        *         description="an 'unexpected' error",
        *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
        *     ),security={{"api_key": {}}}
        * )
         * Remove the specified resource from storage.
         */
    public function destroy(Int $id)
    {
        try {
            $product = product::findOrFail($id);
            $product->delete();
            $id = $product->id;
            return response()->json("product $id deleted");
        } catch(Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'product not deleted'], 400);
        }
    }
}
