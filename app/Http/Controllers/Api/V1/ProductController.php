<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductoResource;
use App\Models\Category;
use App\Models\ProductoPresentaciones;
use App\Models\Productos;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Sorteo;
use App\Models\Subscription;
use App\Http\Requests\SubscriptionRequest;

use App\Traits\ApiResponser;

use Illuminate\Http\Request;
use DB;

class ProductController  extends Controller
{
    use ApiResponser;

    public function index($slug)
    {
        $producto = Productos::where('slug', $slug)
            ->with(['categoria', 'subcategoria', 'galleries', 'relacionados'])
            ->where('active', 1)
            ->firstOrFail();

        return new ProductoResource($producto);
    }


}
