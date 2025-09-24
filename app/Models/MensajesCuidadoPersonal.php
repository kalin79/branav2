<?php

namespace App\Models;

use App\Http\Filters\QueryFilter;
use App\Traits\Audit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MensajesCuidadoPersonal extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Audit;
    use QueryFilter;
    protected $table = 'mensajes_valor';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titulo', 'active', 'orden','icono','color','descripcion'
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
        'descripcion' =>'string'
    ];

    public static function storeValidation($request)
    {
        return [
            'titulo' => 'required',
            //'parent_id' => 'numeric|required',
            'images' => 'image|mimes:jpeg,png,jpg|max:1024'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'titulo' => 'required',
            //'parent_id' => 'numeric|required',
            'images' => 'image|mimes:jpeg,png,jpg|max:1024',
        ];
    }

    public static function attributesValidation()
    {
        return [
            'titulo' => 'titulo',
            //'parent_id' => 'parent_id',

        ];
    }

    public static function finterAndPaginate($q=null)
    {
        $categories = MensajesCuidadoPersonal::orderBy('orden', "asc")
            ->orderBy('titulo','asc');

        return $categories->paginate("10");
    }

    public function scopeActivos($query)
    {
        return $query->where('active', 1);
    }

    /*
     * RELATIONS
     * */


    public function updateIcon($images)
    {
        if ($images) {
            $fileName = $this->id . "-icon-" . time() . '.' . $images->getClientOriginalExtension();
            $path = Storage::disk('cuidado-personal')->putFileAs($this->id, $images, $fileName);
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
