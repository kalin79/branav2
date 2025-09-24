<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Filters\QueryFilter;

class Productos extends Model
{
    use HasFactory;
    use SoftDeletes;
    use QueryFilter;
    protected $table = 'productos';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'title_small', 'title_large', 'slug', 'precio_normal', 'precio_online', 'stock', 'description', 'poster', 'active',
        'categoria_id','sub_categoria_id','price_delivery','description_small','poster_mobile','presentacion','imagen_acerca_producto',
        'acerca_producto','imagen_como_usarlo','como_usarlo','poster_mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title_small' => 'string',
        'title_large' => 'string',
        'slug' => 'string',
        'price_normal' => 'double',
        'price_online' => 'double',
        'price_partner' => 'double',
        'price_delivery' => 'double',
        'stock' => 'integer',
        'description' => 'string',
        'poster' => 'string',
        'active' => 'boolean',
        'categoria_id' => 'integer',
        'sub_categoria_id' => 'integer'


    ];

    //var $category = null;

    public static function storeValidation($request)
    {
        return [
            'title_small' => 'required',
            'title_large' => 'required',
            //'slug' => 'required',
            'preview' => 'array',
            'images' => 'array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:1024',//2M
            'price_normal' => 'numeric|required',
            'price_online' => 'numeric|required',
            'price_partner' => 'numeric|required',
            'stock' => 'numeric|required',
            //'cupon_expire_in' => 'numeric|required',
            //'active' => 'required',
            'product_shops_save' => 'array|required',
            'product_shops_save.*' => 'integer|exists:shops,id|max:4294967295|required',
            'product_categories_save' => 'array|required',
            'product_categories_save.*' => 'integer|exists:categories,id|max:4294967295|required',

        ];
    }

    public static function updateValidation($request)
    {
        return [
            'title_small' => 'required',
            'title_large' => 'required',
            //'slug' => 'required',
            'preview' => 'array',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:1024',//2M
            'price_normal' => 'numeric|required',
            'price_online' => 'numeric|required',
            'price_partner' => 'numeric|required',
            'stock' => 'numeric|required',
            //'cupon_expire_in' => 'numeric|required',
            //'active' => 'required',
            'product_shops_save' => 'array|required',
            'product_shops_save.*' => 'integer|exists:shops,id|max:4294967295|required',
            'product_categories_save' => 'array|required',
            'product_categories_save.*' => 'integer|exists:categories,id|max:4294967295|required',

        ];
    }

    public static function attributesValidation()
    {
        return [
            'product_shops_save' => 'Tiendas',
            'title_small' => 'Título corto',
            'title_large' => 'Título largo',
            'poster' => 'Imagen',//2M
            'slug' => 'Slug',
            'price_normal' => 'Precio normal',
            'price_online' => 'Precio Online',
            'price_partner' => 'Precio Socio',
            'stock' => 'Stock',
            'cupon_expire_in' => 'Expiración de cupón',
            'active' => 'Estado',
            'product_categories_save' => 'Categorías',

        ];
    }


    public function updateImagePoster($posterImage)
    {
        if ($posterImage) {
            $fileName = $this->id . "-" . time() . '-' . uniqid() . '-pc.' . $posterImage->getClientOriginalExtension();
            Storage::disk('products')->putFileAs($this->id, $posterImage, $fileName);
            $this->poster = $fileName;
            $this->update();
        }

    }

    public function updateImagePosterMobile($posterImage)
    {
        if ($posterImage) {
            $fileName = $this->id . "-" . time() . '-' . uniqid() . '-mb.' . $posterImage->getClientOriginalExtension();
            Storage::disk('products')->putFileAs($this->id, $posterImage, $fileName);
            $this->poster_mobile = $fileName;
            $this->update();
        }

    }
    public function updateImageAcercaProducto($posterImage)
    {
        if ($posterImage) {
            $fileName = $this->id . "-" . time() . '-' . uniqid() . '-ap.' . $posterImage->getClientOriginalExtension();
            Storage::disk('products')->putFileAs($this->id, $posterImage, $fileName);
            $this->imagen_acerca_producto = $fileName;
            $this->update();
        }

    }
    public function updateImageComoUsarlo($posterImage)
    {
        if ($posterImage) {
            $fileName = $this->id . "-" . time() . '-' . uniqid() . '-cc.' . $posterImage->getClientOriginalExtension();
            Storage::disk('products')->putFileAs($this->id, $posterImage, $fileName);
            $this->imagen_como_usarlo = $fileName;
            $this->update();
        }

    }



    public function updateImages($images, $orders)
    {
        $filePoster = '';
        ProductoImagenes::where('producto_id', $this->id)->delete();
        $gallery = [];
        $imageUploads = [];

        if ($images) {
            foreach ($images as $key => $image) {
                $nameOriginal = $image->getClientOriginalName();
                $fileName = $this->id . "-" . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                Storage::disk('products')->putFileAs($this->id, $image, $fileName);
                $imageUploads[] = [
                    'original' => $nameOriginal,
                    'upload' => $fileName
                ];
            }
        } else {
            $this->fill([
                'poster' => $filePoster
            ])->save();
        }



        if (count($gallery) > 0) {
            $prodImage = new ProductoImagenes();
            $prodImage->updateImages($this->id, $gallery);
        }
    }

    public function storeGallery($images)
    {
        if ($images) {
            foreach ($images as $key => $image) {
                $nameOriginal = $image->getClientOriginalName();
                $fileName = $this->id . "-" . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                Storage::disk('products')->putFileAs($this->id, $image, $fileName);
                ProductoImagenes::create([
                    'producto_id' => $this->id,
                    'image' => $fileName,
                    'order' => $key + 1
                ]);
            }
        }
    }

    public function updateGallery($images)
    {
        $last_order = $this->galleries()->orderBy('order', 'desc')->first() ? $this->galleries()->orderBy('order', 'desc')->first()->order : 0;
        if ($images) {
            foreach ($images as $key => $image) {
                $nameOriginal = $image->getClientOriginalName();
                $fileName = $this->id . "-" . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                Storage::disk('products')->putFileAs($this->id, $image, $fileName);
                ProductoImagenes::create([
                    'product_id' => $this->id,
                    'image' => $fileName,
                    'order' => $last_order + 1
                ]);
                $last_order ++;
            }
        }
    }

    public function loadGallery()
    {
        return $this->galleries()->orderBy('order', 'asc')->get();
    }

    public static function finterAndPaginate($filters,  $paginate = 10)
    {
        $prods = Productos::filterDynamic($filters)
            ->with(['categoria'])
            ->withCount(['relationProduct'])
            ->orderBy('id', 'desc');
        return $prods->paginate($paginate);


    }

    public function getBaseImages()
    {
        return Storage::disk('products')->url($this->id . "/");;
    }

    public function getImages()
    {
        $baseUrl = $this->getBaseImages();
        $images[] = $this->poster;
        return [
            'url' => $baseUrl,
            'data' => $images
        ];
    }

    public function scopeActivos($query)
    {
        return $query->where('active', 1);
    }


    /*
     * RELATIONS
     * */

    public function galleries()
    {
        return $this->hasMany(ProductoImagenes::class, 'producto_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'categoria_id', 'id');
    }

    public function subcategoria()
    {
        return $this->belongsTo(Categorias::class, 'sub_categoria_id', 'id');
    }



    public function productImages()
    {
        return $this->hasMany(ProductoImagenes::class, 'producto_id');
    }
    public function relationProduct()
    {
        return $this->hasMany(ProductoRelacionados::class, 'producto_id');
    }

    public function relacionados()
    {
        return $this->belongsToMany(
            Productos::class,               // Modelo relacionado
            'productos_relacionados',      // Tabla pivote
            'producto_id',                 // FK de este producto
            'producto_relacionado_id'      // FK del producto relacionado
        )
            ->where('productos_relacionados.active', 1)
            ->whereNull('productos_relacionados.deleted_at'); // 👈 ignorar eliminados
    }



}
