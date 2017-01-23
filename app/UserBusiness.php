<?php

namespace app;

/*
 * Antvel - Business Model
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\Eloquent\Model;
use App\User;
// use Illuminate\Database\Eloquent\SoftDeletes;
class UserBusiness extends Model
{
	// use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_business';

    /**
     * Get business user.
     *
     * @return belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}