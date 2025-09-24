<?php

namespace App\Models;

use App\Traits\Audit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Filters\QueryFilter;

class Categorias extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Audit;
    use QueryFilter;
    protected $table = 'categorias';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titulo',
        'slug',
        'parent_id',
        'active',
        'position',
        'poster',
        'poster_mobile',
        'icono',
        'color',
        'descripcion'
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
        'titulo' => 'string',
        'slug' => 'string',
        'active' => 'boolean',
        'poster' => 'string',
        'icono' => 'string',
        'descripcion' => 'string'
    ];

    public static function storeValidation($request)
    {
        return [
            'titulo' => 'required',
            'parent_id' => 'numeric|required',
            'images' => 'image|mimes:jpeg,png,jpg|max:1024'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'titulo' => 'required',
            'parent_id' => 'numeric|required',
            'images' => 'image|mimes:jpeg,png,jpg|max:1024',
        ];
    }

    public static function attributesValidation()
    {
        return [
            'titulo' => 'titulo',
            'parent_id' => 'parent_id',

        ];
    }

    public static function finterAndPaginate($q = null, $parent = null)
    {
        $categories = Categorias::orderBy('position', "asc")
            ->withCount('subCategories')
            ->orderBy('titulo', 'asc');

        if ($parent) {
            $categories->where('parent_id', $parent);
        } else {
            $categories->where('parent_id', 0);
        }
        return $categories->paginate("10");
    }

    public function scopeActivos($query)
    {
        return $query->where('active', 1);
    }

    /*
     * RELATIONS
     * */

    public function subCategories()
    {
        return $this->hasMany(Categorias::class, 'parent_id', 'id');
    }

    public function productos()
    {
        return $this->hasMany(Productos::class, 'categoria_id', 'id');
    }

    public function updateImages($images)
    {
        if ($images) {
            $fileName = $this->id . "-" . time() . '.' . $images->getClientOriginalExtension();
            $path = Storage::disk('categoria')->putFileAs($this->id, $images, $fileName);
            $this->fill([
                'poster' => basename($path)
            ])->save();
        }
    }

    public function updateImageMobile($images)
    {
        if ($images) {
            $destinationPath = public_path('/images/categoria/' . $this->id);
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            $file = $images;
            //$imagename = time() . "-sl." . $file->getClientOriginalExtension();
            $imagename = $this->id . "-mb-" . time() . '.' . $images->getClientOriginalExtension();
            $file->move($destinationPath, $imagename);
            $this->update(['poster_mobile' => $imagename]);
        }
    }
    public function updateIcon($images)
    {
        if ($images) {
            $fileName = $this->id . "-icon-" . time() . '.' . $images->getClientOriginalExtension();
            $path = Storage::disk('categoria')->putFileAs($this->id, $images, $fileName);
            $this->fill([
                'icono' => basename($path)
            ])->save();
        }
    }

    public function getImages()
    {
        $baseUrl = Storage::disk('categoria')->url();
        $images[] = $this->poster;
        return [
            'url' => $baseUrl,
            'data' => $images
        ];
    }
}
