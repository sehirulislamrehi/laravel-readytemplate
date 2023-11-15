<?php

namespace App\Models\UserModule;

use App\Models\ProductModule\Product;
// Added for JWT Authentication package
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\SettingsModule\Vendor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Depends on Tymon/JWTAuth Package
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'type',
        'role_id',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function user_location()
    {
        return $this->hasMany(UserLocation::class, "user_id", "id");
    }

    public function vendor()
    {
        return $this->hasOne(VendorUser::class, 'user_id', 'id');
    }

    public function vendors()
    {
        return $this->hasMany(VendorUser::class, 'user_id', 'id');
    }

    function product()
    {
        return $this->belongsToMany(Product::class, 'product_scans');
    }

    function point_user():HasMany
    {
        return $this->hasMany(PointUser::class);
    }

    function attributes():BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'attribute_user','user_id','attribute_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
