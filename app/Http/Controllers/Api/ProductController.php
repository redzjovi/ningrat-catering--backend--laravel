<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group product
 */
class ProductController extends Controller
{
    /**
     * GET /
     * @headerParam Accept application/json
     * @queryParam id number
     * @queryParam slug string
     * @queryParam name string
     * @queryParam sell_price_gte number
     * @queryParam sell_price_lte number
     * @queryParam active number
     * @queryParam order_by string Example: -updated_at
     * @queryParam page number
     * @queryParam per_page number
     * @response 200
     *  {
     *      "data": [
     *          {
     *              "id": 2,
     *              "slug": "name-1567838358-2",
     *              "name": "Name 1567838358",
     *              "excerpt": null,
     *              "description": null,
     *              "sell_price": "166.00",
     *              "active": 1,
     *              "created_at": "2019-09-07 06:39:19",
     *              "updated_at": "2019-09-07 06:39:19",
     *              "deleted_at": ""
     *          }
     *      ],
     *      "links": {
     *          "first": "https://ningrat-catering--backend.herokuapp.com/api/product?page=1",
     *          "last": "https://ningrat-catering--backend.herokuapp.com/api/product?page=1",
     *          "prev": null,
     *          "next": null
     *      },
     *      "meta": {
     *          "current_page": 1,
     *          "from": 1,
     *          "last_page": 1,
     *          "path": "https://ningrat-catering--backend.herokuapp.com/api/product",
     *          "per_page": 15,
     *          "to": 13,
     *          "total": 13
     *      }
     *  }
     */
    public function index(Request $request)
    {
        $products = Product::getProductsPaginateWhereData($request->all());

        return ProductResource::collection($products);
    }

    /**
     * POST /
     * @headerParam Accept application/json
     * @bodyParam name string required
     * @bodyParam excerpt string
     * @bodyParam description string
     * @bodyParam sell_price number required
     * @bodyParam active boolean
     * @response 200
     *  {
     *      "data": [
     *          {
     *              "id": 2,
     *              "slug": "name-1567838358-2",
     *              "name": "Name 1567838358",
     *              "excerpt": null,
     *              "description": null,
     *              "sell_price": "166.00",
     *              "active": 1,
     *              "created_at": "2019-09-07 06:39:19",
     *              "updated_at": "2019-09-07 06:39:19",
     *              "deleted_at": ""
     *          }
     *      ]
     *  }
     * @response 422
     *  {
     *      "message": "The given data was invalid.",
     *      "errors": {
     *          "name": [
     *              "The name field is required."
     *          ],
     *          "sell_price": [
     *              "The sell price field is required.",
     *              "The sell price must be a number."
     *          ],
     *          "active": [
     *              "The active field must be true or false."
     *          ]
     *      }
     *  }
     */
    public function store(\App\Http\Requests\Api\Product\StoreRequest $request)
    {
        $product = Product::createProduct($request->all());

        return new ProductResource($product);
    }

    /**
     * GET /:id
     * @headerParam Accept application/json
     * @response 200
     *  {
     *      "data": [
     *          {
     *              "id": 2,
     *              "slug": "name-1567838358-2",
     *              "name": "Name 1567838358",
     *              "excerpt": null,
     *              "description": null,
     *              "sell_price": "166.00",
     *              "active": 1,
     *              "created_at": "2019-09-07 06:39:19",
     *              "updated_at": "2019-09-07 06:39:19",
     *              "deleted_at": ""
     *          }
     *      ]
     *  }
     *  @response 404
     *  {
     *      "message": "Model Not Found."
     *  }
     */
    public function show($id)
    {
        $product = Product::getProductOrFailWhereId($id);

        return new ProductResource($product);
    }

    /**
     * PUT /:id
     * @headerParam Accept application/json
     * @headerParam Content-Type application/x-www-form-urlencoded
     * @bodyParam name string required
     * @bodyParam excerpt string
     * @bodyParam description string
     * @bodyParam sell_price number required
     * @bodyParam active boolean
     * @response 200
     *  {
     *      "data": [
     *          {
     *              "id": 2,
     *              "slug": "name-1567838358-2",
     *              "name": "Name 1567838358",
     *              "excerpt": null,
     *              "description": null,
     *              "sell_price": "166.00",
     *              "active": 1,
     *              "created_at": "2019-09-07 06:39:19",
     *              "updated_at": "2019-09-07 06:39:19",
     *              "deleted_at": ""
     *          }
     *      ]
     *  }
     * @response 404
     *  {
     *      "message": "Model Not Found."
     *  }
     * @response 422
     *  {
     *      "message": "The given data was invalid.",
     *      "errors": {
     *          "name": [
     *              "The name field is required."
     *          ],
     *          "sell_price": [
     *              "The sell price field is required.",
     *              "The sell price must be a number."
     *          ],
     *          "active": [
     *              "The active field must be true or false."
     *          ]
     *      }
     *  }
     */
    public function update(\App\Http\Requests\Api\Product\UpdateRequest $request, $id)
    {
        $product = Product::updateProductOrFailWhereId($id, $request->all());

        return new ProductResource($product);
    }

    /**
     * DELETE /:id
     * @headerParam Accept application/json
     * @response 204
     * @response 404
     *  {
     *      "message": "Model Not Found."
     *  }
     */
    public function destroy($id)
    {
        $product = Product::getProductOrFailWhereId($id);

        Product::deleteProductWhereId($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
