<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BankingInformation
 *
 * @property int $id
 * @property int $banking_informationable_id
 * @property string $banking_informationable_type
 * @property int $account_type
 * @property int $financial_institution_types
 * @property string $financial_institution_bank
 * @property string $account_number
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class BankingInformation extends Model
{
    use UserStamps;

    protected $table = 'banking_information';

    protected $casts = [
        'banking_informationable_id' => 'int',
        'account_type' => 'int',
        'financial_institution_types' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'banking_informationable_id',
        'banking_informationable_type',
        'account_type',
        'financial_institution_types',
        'financial_institution_bank',
        'account_number',
        'created_by',
        'updated_by',
    ];
}
