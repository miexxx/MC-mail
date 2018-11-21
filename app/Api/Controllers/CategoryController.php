<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/17
 * Time: 16:25
 * Function:
 */

namespace App\Api\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Models\ItemCategory;

class CategoryController extends Controller
{
    /**
     * @return \Tanmo\Api\Http\Response
     */
    public function index()
    {
        $categories = (new ItemCategory())->where('parent_id','=',0)->get();
        return api()->collection($categories, CategoryResource::class);
    }

    public function detail($id){
        $categories = (new ItemCategory())->where('parent_id','=',$id)->get();
        return api()->collection($categories, CategoryResource::class);
    }

    /**
     * 分类商品列表
     *
     * @param $id
     * @return \Tanmo\Api\Http\Response
     */
    public function show($id)
    {
        $items = (new Item())->where('category_id', $id)->orderBy('order', 'asc')->orderBy('created_at', 'desc')->paginate(10);
        $items->load('covers');

        return api()->collection($items, ItemResource::class);
    }
}