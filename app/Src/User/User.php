<?php namespace App\Src\User;

use App\Core\BaseModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * Return All Books For this User
     */
    public function books()
    {
        return $this->hasMany('App\Src\Book\Book');
    }

    /**
     * @return mixed
     * Return Published Books Only For this User
     */
    public function publishedBooks()
    {
        return $this->books()->where('status', 'published');
    }

    /**
     * @return mixed
     * Return Drafted Books Only For this User
     */
    public function draftedBooks()
    {
        return $this->books()->where('status', 'draft');
    }

}
